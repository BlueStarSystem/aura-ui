<?php

namespace BlueStarSystem\AuraUI\Support;

use Closure;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class RemoteRegistry
{
    /**
     * @param  array<int, string>  $allowedHosts
     */
    public function __construct(
        private array $allowedHosts,
        private int $maxBytes,
        private Closure $confirmHost,
    ) {}

    public static function isUrl(string $arg): bool
    {
        return (bool) preg_match('#^https?://#i', $arg);
    }

    public static function pathIsSafe(string $path): bool
    {
        if ($path === '' || str_contains($path, "\0") || str_contains($path, '\\')) {
            return false;
        }

        if (str_starts_with($path, '/') || preg_match('#^[A-Za-z]:#', $path)) {
            return false;
        }

        foreach (explode('/', $path) as $segment) {
            if ($segment === '' || $segment === '..') {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array{name:string,type:string,tier:string,files:array<string,string>,deps:array<int,string>}
     */
    public function fetch(string $url): array
    {
        $parts = parse_url($url);

        if (($parts['scheme'] ?? '') !== 'https') {
            throw new RuntimeException("Refusing non-HTTPS registry URL: {$url}");
        }

        $host = $parts['host'] ?? '';

        if (! in_array($host, $this->allowedHosts, true) && ! ($this->confirmHost)($host)) {
            throw new RuntimeException("Aborted: registry host \"{$host}\" is not allowed. Pass --allow-host={$host} to trust it.");
        }

        $response = Http::timeout(15)->acceptJson()->get($url);

        if (! $response->successful()) {
            throw new RuntimeException("Registry request failed ({$response->status()}): {$url}");
        }

        $body = $response->body();

        if (strlen($body) > $this->maxBytes) {
            throw new RuntimeException("Registry item exceeds the {$this->maxBytes}-byte limit: {$url}");
        }

        $data = json_decode($body, true);

        if (! is_array($data)) {
            throw new RuntimeException("Registry item is not valid JSON: {$url}");
        }

        return $this->normalize($data, $url);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array{name:string,type:string,tier:string,files:array<string,string>,deps:array<int,string>}
     */
    private function normalize(array $data, string $url): array
    {
        $name = $data['name'] ?? null;

        if (! is_string($name) || $name === '') {
            throw new RuntimeException("Registry item missing a valid \"name\": {$url}");
        }

        $files = [];

        foreach ($data['files'] ?? [] as $file) {
            if (! is_array($file) || ! isset($file['path'], $file['content']) || ! is_string($file['path']) || ! is_string($file['content'])) {
                throw new RuntimeException("Registry item \"{$name}\" has an invalid file entry.");
            }

            if (! self::pathIsSafe($file['path'])) {
                throw new RuntimeException("Registry item \"{$name}\" has an unsafe file path: {$file['path']}");
            }

            $files[$file['path']] = $file['content'];
        }

        $deps = [];

        foreach ($data['deps'] ?? [] as $dep) {
            if (is_string($dep) && $dep !== '') {
                $deps[] = $dep;
            }
        }

        return [
            'name' => $name,
            'type' => is_string($data['type'] ?? null) ? $data['type'] : 'component',
            'tier' => is_string($data['tier'] ?? null) ? $data['tier'] : 'free',
            'files' => $files,
            'deps' => $deps,
        ];
    }

    /**
     * @return array<int, array{name:string,type:string,tier:string,files:array<string,string>,deps:array<int,string>}>
     */
    public function resolveTree(string $url): array
    {
        $items = [];
        $visited = [];

        $visit = function (string $u) use (&$visit, &$items, &$visited): void {
            if (isset($visited[$u])) {
                return;
            }

            $visited[$u] = true;

            $item = $this->fetch($u);

            foreach ($item['deps'] as $dep) {
                $visit(self::isUrl($dep) ? $dep : $this->siblingUrl($u, $dep));
            }

            $items[] = $item;
        };

        $visit($url);

        return $items;
    }

    private function siblingUrl(string $url, string $name): string
    {
        $parts = parse_url($url);
        $port = isset($parts['port']) ? ':'.$parts['port'] : '';

        return $parts['scheme'].'://'.$parts['host'].$port.'/r/'.$name.'.json';
    }
}
