<?php

namespace BlueStarSystem\AuraUI\Support;

use RuntimeException;

/**
 * HTTP fetcher with no framework dependency, for the standalone `aura` binary.
 *
 * The size cap is enforced while reading rather than after: a registry that
 * answered with a hundred megabytes would otherwise be fully downloaded before
 * anyone checked. RemoteRegistry still re-checks the length it receives, so a
 * fetcher that ignores the cap cannot slip past.
 */
final class RegistryFetcher
{
    public function __construct(
        private int $maxBytes,
        private int $timeout = 15,
    ) {}

    /**
     * @return array{status:int, body:string}
     */
    public function __invoke(string $url): array
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "Accept: application/json\r\nUser-Agent: aura-cli\r\n",
                'timeout' => $this->timeout,
                'follow_location' => 0,
                'ignore_errors' => true,
            ],
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
            ],
        ]);

        $handle = @fopen($url, 'rb', false, $context);

        if ($handle === false) {
            throw new RuntimeException("Could not reach the registry: {$url}");
        }

        // Read one byte past the cap so an oversized body is detectable rather
        // than silently truncated into something that still parses as JSON.
        $body = (string) stream_get_contents($handle, $this->maxBytes + 1);
        $meta = stream_get_meta_data($handle);
        fclose($handle);

        return [
            'status' => $this->statusFrom($meta['wrapper_data'] ?? []),
            'body' => $body,
        ];
    }

    /**
     * @param  array<int, string>|mixed  $headers
     */
    private function statusFrom(mixed $headers): int
    {
        if (! is_array($headers)) {
            return 0;
        }

        // A redirect chain leaves several status lines; the last one is the
        // response actually being read. follow_location is off, so in practice
        // a redirect surfaces as 3xx and is reported rather than followed.
        $status = 0;

        foreach ($headers as $header) {
            if (is_string($header) && preg_match('#^HTTP/\d(?:\.\d)?\s+(\d{3})#', $header, $m) === 1) {
                $status = (int) $m[1];
            }
        }

        return $status;
    }
}
