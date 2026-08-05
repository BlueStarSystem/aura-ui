<?php

namespace BlueStarSystem\AuraUI\Cli;

use BlueStarSystem\AuraUI\Support\ComponentInstaller;
use BlueStarSystem\AuraUI\Support\RegistryFetcher;
use BlueStarSystem\AuraUI\Support\RemoteRegistry;
use Closure;
use RuntimeException;

/**
 * The standalone `aura` binary.
 *
 * `aura:add` needs a Laravel application that already has the package
 * installed. This does not: it resolves component names against the public
 * registry over HTTPS and copies the source into whatever project you are
 * standing in — which is the point of own-the-code. Your project ends up with
 * the files and no dependency on Aura at all.
 *
 * All the security-relevant work (host allowlist, size cap, path
 * sanitisation, cycle-safe dependency resolution) is RemoteRegistry's, shared
 * verbatim with the artisan command rather than reimplemented here.
 */
final class Application
{
    public const VERSION = '1.0.0';

    private const DEFAULT_REGISTRY = 'https://aura-ui.com';

    /** @var Closure(string): void */
    private Closure $out;

    /**
     * @param  Closure(string): void|null  $out
     */
    public function __construct(?Closure $out = null, private string $cwd = '')
    {
        $this->out = $out ?? static function (string $line): void {
            fwrite(STDOUT, $line."\n");
        };

        $this->cwd = $cwd !== '' ? $cwd : (string) getcwd();
    }

    /**
     * @param  list<string>  $argv
     */
    public function run(array $argv): int
    {
        array_shift($argv);

        $command = $argv[0] ?? 'help';

        if (in_array($command, ['-V', '--version'], true)) {
            ($this->out)('aura '.self::VERSION);

            return 0;
        }

        $arguments = [];
        $options = [];

        foreach (array_slice($argv, 1) as $token) {
            if (str_starts_with($token, '--')) {
                [$key, $value] = array_pad(explode('=', substr($token, 2), 2), 2, true);
                $options[$key][] = $value;

                continue;
            }

            $arguments[] = $token;
        }

        try {
            return match ($command) {
                'add' => $this->add($arguments, $options),
                'list' => $this->list($options),
                'help', '-h', '--help' => $this->help(),
                default => $this->unknown($command),
            };
        } catch (RuntimeException $e) {
            ($this->out)('Error: '.$e->getMessage());

            return 1;
        }
    }

    /**
     * @param  list<string>  $names
     * @param  array<string, list<string|true>>  $options
     */
    private function add(array $names, array $options): int
    {
        if ($names === []) {
            ($this->out)('Usage: aura add <component...> [--path=DIR] [--force] [--dry-run]');

            return 1;
        }

        $registryBase = rtrim($this->first($options, 'registry', self::DEFAULT_REGISTRY), '/');
        $maxBytes = (int) $this->first($options, 'max-bytes', (string) (512 * 1024));
        $force = isset($options['force']);
        $dryRun = isset($options['dry-run']);
        $noDeps = isset($options['no-deps']);
        $destination = $this->destination($options);

        $allowed = array_merge(
            [(string) parse_url($registryBase, PHP_URL_HOST)],
            array_map('strval', array_filter($options['allow-host'] ?? [], 'is_string')),
        );

        $fetcher = new RegistryFetcher($maxBytes);

        $registry = new RemoteRegistry(
            array_values(array_filter($allowed)),
            $maxBytes,
            // Non-interactive by design: a binary that prompts is a binary that
            // hangs in CI. An unlisted host must be named with --allow-host.
            static fn (string $host): bool => false,
            $fetcher(...),
        );

        $installer = new ComponentInstaller(['free' => $destination], $destination);
        $written = [];
        $skipped = [];

        foreach ($names as $name) {
            $url = RemoteRegistry::isUrl($name) ? $name : $registryBase.'/r/'.$name.'.json';

            $items = $noDeps ? [$registry->fetch($url)] : $registry->resolveTree($url);
            $report = $installer->installRemote($items, $force, $dryRun);

            $written = array_merge($written, $report['written']);
            $skipped = array_merge($skipped, $report['skipped']);
        }

        foreach ($written as $file) {
            ($this->out)(($dryRun ? '  would write  ' : '  wrote  ').$destination.'/'.$file);
        }

        foreach ($skipped as $file) {
            ($this->out)('  skipped '.$file.' (already there — use --force)');
        }

        if ($written !== []) {
            ($this->out)('');
            ($this->out)($dryRun
                ? 'Dry run: nothing written.'
                : 'Use them as <x-aura.'.$names[0].'> — the copied source is yours to edit.');
        }

        return 0;
    }

    /**
     * @param  array<string, list<string|true>>  $options
     */
    private function list(array $options): int
    {
        $registryBase = rtrim($this->first($options, 'registry', self::DEFAULT_REGISTRY), '/');
        $maxBytes = 4 * 1024 * 1024;

        $response = (new RegistryFetcher($maxBytes))($registryBase.'/r/registry.json');

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new RuntimeException("Could not read the registry index ({$response['status']}).");
        }

        $data = json_decode($response['body'], true);

        if (! is_array($data) || ! is_array($data['components'] ?? null)) {
            throw new RuntimeException('The registry index is not in the expected shape.');
        }

        $onlyFree = isset($options['free']);

        foreach ($data['components'] as $component) {
            $tier = $component['tier'] ?? 'free';

            if ($onlyFree && $tier !== 'free') {
                continue;
            }

            ($this->out)(sprintf(
                '  %-24s %-5s %s',
                $component['name'] ?? '?',
                $tier === 'pro' ? 'pro' : '',
                $component['description'] ?? '',
            ));
        }

        return 0;
    }

    private function help(): int
    {
        foreach ([
            'aura '.self::VERSION.' — copy Aura UI components into your project.',
            '',
            'USAGE',
            '  aura add <component...>   Copy components (and their dependencies) here',
            '  aura list [--free]        List everything the registry offers',
            '',
            'OPTIONS for add',
            '  --path=DIR                Where to write (default: resources/views/components/aura',
            '                            in a Laravel project, ./aura otherwise)',
            '  --force                   Overwrite files that already exist',
            '  --dry-run                 Show what would be written',
            '  --no-deps                 Do not follow dependencies',
            '  --registry=URL            Use another registry (default: '.self::DEFAULT_REGISTRY.')',
            '  --allow-host=HOST         Trust a registry host other than the default',
            '',
            'Pro components are not published by the registry: install',
            'bluestarsystem/aura-ui-pro and use php artisan aura:add instead.',
        ] as $line) {
            ($this->out)($line);
        }

        return 0;
    }

    private function unknown(string $command): int
    {
        ($this->out)("Unknown command \"{$command}\". Try: aura help");

        return 1;
    }

    /**
     * @param  array<string, list<string|true>>  $options
     */
    private function destination(array $options): string
    {
        $explicit = $this->first($options, 'path', '');

        if ($explicit !== '') {
            return rtrim($explicit, '/\\');
        }

        // A Laravel project has somewhere conventional to put these; anywhere
        // else, guessing a framework layout would be worse than being obvious.
        return is_file($this->cwd.'/artisan') && is_dir($this->cwd.'/resources/views')
            ? $this->cwd.'/resources/views/components/aura'
            : $this->cwd.'/aura';
    }

    /**
     * @param  array<string, list<string|true>>  $options
     */
    private function first(array $options, string $key, string $default): string
    {
        $value = $options[$key][0] ?? null;

        return is_string($value) && $value !== '' ? $value : $default;
    }
}
