<?php

use BlueStarSystem\AuraUI\Support\RemoteRegistry;
use Illuminate\Support\Facades\Http;

function remoteRegistry(array $allowed = ['aura-ui.com'], bool $confirm = false): RemoteRegistry
{
    return new RemoteRegistry($allowed, 512 * 1024, fn (string $host): bool => $confirm);
}

it('detects URLs and validates safe paths', function () {
    expect(RemoteRegistry::isUrl('https://x.com/r/a.json'))->toBeTrue();
    expect(RemoteRegistry::isUrl('button'))->toBeFalse();
    expect(RemoteRegistry::pathIsSafe('card.blade.php'))->toBeTrue();
    expect(RemoteRegistry::pathIsSafe('card/item.blade.php'))->toBeTrue();
    expect(RemoteRegistry::pathIsSafe('../evil.php'))->toBeFalse();
    expect(RemoteRegistry::pathIsSafe('/etc/passwd'))->toBeFalse();
    expect(RemoteRegistry::pathIsSafe('a\\b'))->toBeFalse();
});

it('fetches and normalizes a registry item', function () {
    Http::fake(['aura-ui.com/r/button.json' => Http::response([
        'name' => 'button', 'type' => 'component', 'tier' => 'free',
        'files' => [['path' => 'button.blade.php', 'content' => '<button></button>']],
        'deps' => ['icon'],
    ])]);

    $item = remoteRegistry()->fetch('https://aura-ui.com/r/button.json');

    expect($item['name'])->toBe('button');
    expect($item['files'])->toBe(['button.blade.php' => '<button></button>']);
    expect($item['deps'])->toBe(['icon']);
});

it('rejects non-HTTPS URLs', function () {
    remoteRegistry()->fetch('http://aura-ui.com/r/button.json');
})->throws(RuntimeException::class);

it('rejects a non-allowlisted host when not confirmed', function () {
    Http::fake();
    remoteRegistry(['aura-ui.com'], confirm: false)->fetch('https://evil.test/r/x.json');
})->throws(RuntimeException::class);

it('rejects an item with an unsafe file path', function () {
    Http::fake(['*' => Http::response([
        'name' => 'x', 'files' => [['path' => '../../../evil.php', 'content' => 'x']], 'deps' => [],
    ])]);
    remoteRegistry()->fetch('https://aura-ui.com/r/x.json');
})->throws(RuntimeException::class);

it('resolves a dependency tree with siblings, deps first', function () {
    Http::fake([
        'aura-ui.com/r/accordion.json' => Http::response([
            'name' => 'accordion', 'files' => [['path' => 'accordion.blade.php', 'content' => 'A']], 'deps' => ['icon'],
        ]),
        'aura-ui.com/r/icon.json' => Http::response([
            'name' => 'icon', 'files' => [['path' => 'icon.blade.php', 'content' => 'I']], 'deps' => [],
        ]),
    ]);

    $items = remoteRegistry()->resolveTree('https://aura-ui.com/r/accordion.json');

    expect(array_column($items, 'name'))->toBe(['icon', 'accordion']);
});

it('is cycle-safe', function () {
    Http::fake([
        'aura-ui.com/r/a.json' => Http::response(['name' => 'a', 'files' => [], 'deps' => ['b']]),
        'aura-ui.com/r/b.json' => Http::response(['name' => 'b', 'files' => [], 'deps' => ['a']]),
    ]);

    $items = remoteRegistry()->resolveTree('https://aura-ui.com/r/a.json');

    expect(count($items))->toBe(2);
});
