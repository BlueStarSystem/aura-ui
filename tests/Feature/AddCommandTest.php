<?php

use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->root = sys_get_temp_dir().'/aura-add-'.uniqid();
    $this->free = $this->root.'/free';
    $this->dest = $this->root.'/dest';
    File::ensureDirectoryExists($this->free.'/resources/views/components');
    File::put($this->free.'/resources/views/components/icon.blade.php', '<svg>icon</svg>');
    File::put($this->free.'/resources/views/components/button.blade.php', '<button><x-aura::icon /></button>');
    File::put($this->free.'/resources/aura-registry.json', json_encode([
        'button' => ['tier' => 'free', 'files' => ['button.blade.php'], 'deps' => ['icon']],
        'icon'   => ['tier' => 'free', 'files' => ['icon.blade.php'], 'deps' => []],
        'scheduler' => ['tier' => 'pro', 'files' => ['scheduler.blade.php'], 'deps' => []],
    ]));
});

afterEach(fn () => File::deleteDirectory($this->root));

it('adds a component and its deps with rewritten references', function () {
    $this->artisan('aura:add', [
        'components' => ['button'], '--path' => $this->dest, '--free-root' => $this->free,
    ])->assertSuccessful();

    expect(File::get($this->dest.'/button.blade.php'))->toBe('<button><x-aura.icon /></button>')
        ->and(File::exists($this->dest.'/icon.blade.php'))->toBeTrue();
});

it('skips deps with --no-deps', function () {
    $this->artisan('aura:add', [
        'components' => ['button'], '--path' => $this->dest, '--free-root' => $this->free, '--no-deps' => true,
    ])->assertSuccessful();

    expect(File::exists($this->dest.'/button.blade.php'))->toBeTrue()
        ->and(File::exists($this->dest.'/icon.blade.php'))->toBeFalse();
});

it('fails for an unknown component', function () {
    $this->artisan('aura:add', [
        'components' => ['nope'], '--path' => $this->dest, '--free-root' => $this->free,
    ])->assertFailed();
});

it('blocks a pro component when the pro package is absent', function () {
    $this->artisan('aura:add', [
        'components' => ['scheduler'], '--path' => $this->dest, '--free-root' => $this->free,
    ])->expectsOutputToContain('composer require bluestarsystem/aura-ui-pro')->assertFailed();
});
