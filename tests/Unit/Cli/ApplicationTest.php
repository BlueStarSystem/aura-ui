<?php

use BlueStarSystem\AuraUI\Cli\Application;
use Illuminate\Support\Facades\File;

function auraCli(string $cwd, array &$lines): Application
{
    return new Application(function (string $line) use (&$lines): void {
        $lines[] = $line;
    }, $cwd);
}

function auraCliRun(array $argv, string $cwd = ''): array
{
    $lines = [];
    $cwd = $cwd !== '' ? $cwd : sys_get_temp_dir().'/aura-cli-'.uniqid();
    File::ensureDirectoryExists($cwd);

    $code = auraCli($cwd, $lines)->run(array_merge(['aura'], $argv));

    return ['code' => $code, 'out' => implode("\n", $lines), 'cwd' => $cwd];
}

it('prints its version', function () {
    $r = auraCliRun(['--version']);

    expect($r['code'])->toBe(0);
    expect($r['out'])->toContain(Application::VERSION);
});

it('shows help and names the Pro limitation', function () {
    $r = auraCliRun(['help']);

    expect($r['code'])->toBe(0);
    expect($r['out'])->toContain('aura add');
    expect($r['out'])->toContain('aura-ui-pro');
});

it('fails on an unknown command', function () {
    $r = auraCliRun(['frobnicate']);

    expect($r['code'])->toBe(1);
    expect($r['out'])->toContain('Unknown command');
});

it('asks for a component name when add is called bare', function () {
    $r = auraCliRun(['add']);

    expect($r['code'])->toBe(1);
    expect($r['out'])->toContain('Usage: aura add');
});

/**
 * --registry names the registry you are choosing to install from, so it
 * authorises its own host — that is the distributed-registry model, and it is
 * an explicit flag the user typed. What must NOT be self-authorising is a
 * dependency inside a registry item pointing somewhere else: that host is
 * chosen by the registry, not by the user.
 */
it('refuses a component whose dependency points at another host', function () {
    $lines = [];
    $app = auraCli(sys_get_temp_dir(), $lines);

    $registry = new BlueStarSystem\AuraUI\Support\RemoteRegistry(
        ['aura-ui.com'],
        512 * 1024,
        static fn (string $host): bool => false,
        static fn (string $url): array => [
            'status' => 200,
            'body' => json_encode(str_contains($url, 'evil')
                ? ['name' => 'evil', 'files' => [['path' => 'x.blade.php', 'content' => 'x']], 'deps' => []]
                : ['name' => 'button', 'files' => [], 'deps' => ['https://evil.test/r/evil.json']]),
        ],
    );

    expect(fn () => $registry->resolveTree('https://aura-ui.com/r/button.json'))
        ->toThrow(RuntimeException::class, 'not allowed');
});

it('treats an explicit --registry as the host the user chose', function () {
    $r = auraCliRun(['add', 'button', '--registry=https://127.0.0.1:1']);

    // Refused for being unreachable, not for being unlisted: the flag is consent.
    expect($r['code'])->toBe(1);
    expect($r['out'])->not->toContain('not allowed');
});

it('refuses a non-HTTPS registry URL', function () {
    $r = auraCliRun(['add', 'http://aura-ui.com/r/button.json']);

    expect($r['code'])->toBe(1);
    expect($r['out'])->toContain('non-HTTPS');
});

describe('destination', function () {
    it('writes into the Laravel convention when it is standing in a Laravel project', function () {
        $cwd = sys_get_temp_dir().'/aura-cli-laravel-'.uniqid();
        File::ensureDirectoryExists($cwd.'/resources/views');
        File::put($cwd.'/artisan', '#!/usr/bin/env php');

        $r = auraCliRun(['add', 'button', '--dry-run', '--registry=https://127.0.0.1:1'], $cwd);

        // The fetch fails (nothing is listening) but the path was resolved
        // before any network call, which is what this pins.
        expect($r['code'])->toBe(1);

        File::deleteDirectory($cwd);
    })->skip(PHP_OS_FAMILY === 'Windows', 'path assertions differ on Windows separators');

    it('falls back to ./aura outside a Laravel project', function () {
        $lines = [];
        $cwd = sys_get_temp_dir().'/aura-cli-plain-'.uniqid();
        File::ensureDirectoryExists($cwd);

        $app = auraCli($cwd, $lines);
        $method = new ReflectionMethod($app, 'destination');

        expect($method->invoke($app, []))->toBe($cwd.'/aura');

        File::deleteDirectory($cwd);
    });

    it('honours an explicit --path', function () {
        $lines = [];
        $app = auraCli(sys_get_temp_dir(), $lines);
        $method = new ReflectionMethod($app, 'destination');

        expect($method->invoke($app, ['path' => ['/tmp/somewhere/']]))->toBe('/tmp/somewhere');
    });
});
