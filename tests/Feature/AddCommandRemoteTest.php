<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

it('installs a component from a remote registry url', function () {
    $dest = sys_get_temp_dir().'/aura-add-remote-'.uniqid();

    Http::fake([
        'aura-ui.com/r/accordion.json' => Http::response([
            'name' => 'accordion', 'type' => 'component', 'tier' => 'free',
            'files' => [['path' => 'accordion.blade.php', 'content' => '<x-aura::icon />']],
            'deps' => ['icon'],
        ]),
        'aura-ui.com/r/icon.json' => Http::response([
            'name' => 'icon', 'files' => [['path' => 'icon.blade.php', 'content' => 'ICON']], 'deps' => [],
        ]),
    ]);

    $this->artisan('aura:add', [
        'components' => ['https://aura-ui.com/r/accordion.json'],
        '--path' => $dest,
        '--no-interaction' => true,
    ])->assertSuccessful();

    expect(File::exists($dest.'/accordion.blade.php'))->toBeTrue();
    expect(File::exists($dest.'/icon.blade.php'))->toBeTrue();
    expect(File::get($dest.'/accordion.blade.php'))->toContain('<x-aura.icon');

    File::deleteDirectory($dest);
});

it('refuses a non-allowlisted host in --no-interaction without --allow-host', function () {
    Http::fake(['evil.test/*' => Http::response(['name' => 'x', 'files' => [], 'deps' => []])]);

    $this->artisan('aura:add', [
        'components' => ['https://evil.test/r/x.json'],
        '--no-interaction' => true,
    ])->assertFailed();
});

it('allows a host passed via --allow-host', function () {
    $dest = sys_get_temp_dir().'/aura-add-allow-'.uniqid();
    Http::fake(['ok.test/r/x.json' => Http::response([
        'name' => 'x', 'files' => [['path' => 'x.blade.php', 'content' => 'X']], 'deps' => [],
    ])]);

    $this->artisan('aura:add', [
        'components' => ['https://ok.test/r/x.json'],
        '--allow-host' => ['ok.test'],
        '--path' => $dest,
        '--no-interaction' => true,
    ])->assertSuccessful();

    expect(File::exists($dest.'/x.blade.php'))->toBeTrue();
    File::deleteDirectory($dest);
});
