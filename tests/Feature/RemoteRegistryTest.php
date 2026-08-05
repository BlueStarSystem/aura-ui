<?php

use BlueStarSystem\AuraUI\Support\RemoteRegistry;
use Illuminate\Support\Facades\Http;

function remoteRegistry(array $allowed = ['aura-ui.com'], bool $confirm = false): RemoteRegistry
{
    // The fetcher is injected so the class carries no framework dependency;
    // here it is the same Http-facade closure the artisan command uses, which
    // keeps Http::fake() working for every test below.
    $fetcher = function (string $url): array {
        $response = Http::timeout(15)->acceptJson()->get($url);

        return ['status' => $response->status(), 'body' => $response->body()];
    };

    return new RemoteRegistry($allowed, 512 * 1024, fn (string $host): bool => $confirm, $fetcher);
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

it('defeats the userinfo host bypass', function () {
    Http::fake();
    remoteRegistry(['aura-ui.com'], confirm: false)->fetch('https://aura-ui.com@evil.test/r/x.json');
})->throws(RuntimeException::class);

it('rejects a non-array files value', function () {
    Http::fake(['*' => Http::response(['name' => 'x', 'files' => 'evil', 'deps' => []])]);
    remoteRegistry()->fetch('https://aura-ui.com/r/x.json');
})->throws(RuntimeException::class);

it('rejects a non-string file content', function () {
    Http::fake(['*' => Http::response(['name' => 'x', 'files' => [['path' => 'x.blade.php', 'content' => 123]], 'deps' => []])]);
    remoteRegistry()->fetch('https://aura-ui.com/r/x.json');
})->throws(RuntimeException::class);

it('refuses to install a Pro component the registry will not publish', function () {
    Http::fake(['aura-ui.com/r/dock.json' => Http::response([
        'name' => 'dock', 'type' => 'component', 'tier' => 'pro',
        'files' => [], 'deps' => [],
        'requires_license' => true,
        'license_url' => 'https://aura-ui.com/pricing',
    ])]);

    expect(fn () => remoteRegistry()->fetch('https://aura-ui.com/r/dock.json'))
        ->toThrow(RuntimeException::class, 'Pro component');
});

it('also refuses a Pro item that merely arrives with no files', function () {
    Http::fake(['aura-ui.com/r/kanban.json' => Http::response([
        'name' => 'kanban', 'type' => 'component', 'tier' => 'pro', 'files' => [], 'deps' => [],
    ])]);

    expect(fn () => remoteRegistry()->fetch('https://aura-ui.com/r/kanban.json'))
        ->toThrow(RuntimeException::class);
});

it('still allows a free component that genuinely ships no files', function () {
    Http::fake(['aura-ui.com/r/meta.json' => Http::response([
        'name' => 'meta', 'type' => 'component', 'tier' => 'free', 'files' => [], 'deps' => [],
    ])]);

    expect(remoteRegistry()->fetch('https://aura-ui.com/r/meta.json')['files'])->toBe([]);
});
