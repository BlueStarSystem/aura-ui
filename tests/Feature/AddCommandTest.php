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

it('blocks when a free component has a pro dep and pro package is absent', function () {
    // Overwrite the registry so that a free component ("card") depends on a pro component ("scheduler")
    File::put($this->free.'/resources/aura-registry.json', json_encode([
        'card'      => ['tier' => 'free', 'files' => ['card.blade.php'], 'deps' => ['scheduler']],
        'scheduler' => ['tier' => 'pro',  'files' => ['scheduler.blade.php'], 'deps' => []],
    ]));
    File::put($this->free.'/resources/views/components/card.blade.php', '<div>card</div>');

    $this->artisan('aura:add', [
        'components' => ['card'], '--path' => $this->dest, '--free-root' => $this->free,
    ])->expectsOutputToContain('composer require bluestarsystem/aura-ui-pro')->assertFailed();
});

it('installs a block and its component deps into the blocks subdir with rewritten namespace', function () {
    $root = sys_get_temp_dir().'/aura-add-block-'.uniqid();
    $free = $root.'/free';
    $dest = $root.'/dest';
    \Illuminate\Support\Facades\File::ensureDirectoryExists($free.'/resources/views/components/blocks');
    \Illuminate\Support\Facades\File::put($free.'/resources/views/components/button.blade.php', '<button>x</button>');
    \Illuminate\Support\Facades\File::put($free.'/resources/views/components/blocks/hero-split.blade.php', '<section><x-aura::button>Go</x-aura::button></section>');
    \Illuminate\Support\Facades\File::put($free.'/resources/aura-registry.json', json_encode([
        'button' => ['tier' => 'free', 'type' => 'component', 'files' => ['button.blade.php'], 'deps' => []],
        'hero-split' => ['tier' => 'free', 'type' => 'block', 'files' => ['blocks/hero-split.blade.php'], 'deps' => ['button']],
    ]));

    $this->artisan('aura:add', ['components' => ['hero-split'], '--path' => $dest, '--free-root' => $free])->assertSuccessful();

    expect(\Illuminate\Support\Facades\File::get($dest.'/blocks/hero-split.blade.php'))->toContain('<x-aura.button>')
        ->and(\Illuminate\Support\Facades\File::exists($dest.'/button.blade.php'))->toBeTrue();

    \Illuminate\Support\Facades\File::deleteDirectory($root);
});
