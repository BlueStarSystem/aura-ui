<?php

use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->src = sys_get_temp_dir().'/aura-manifest-'.uniqid();
    $this->out = $this->src.'/aura-registry.json';
    File::ensureDirectoryExists($this->src.'/accordion');
    File::put($this->src.'/icon.blade.php', '<svg>{{ $name }}</svg>');
    File::put($this->src.'/button.blade.php', '<button><x-aura::icon :name="$leftIcon" /></button>');
    File::put($this->src.'/accordion.blade.php', '<div><x-aura::accordion.item /></div>');
    File::put($this->src.'/accordion/item.blade.php', '<div>item</div>');
});

afterEach(function () {
    File::deleteDirectory($this->src);
});

it('writes a sorted manifest with files and parsed deps', function () {
    $this->artisan('aura:manifest', ['--source' => $this->src, '--output' => $this->out, '--tier' => 'free'])
        ->assertSuccessful();

    $manifest = json_decode(File::get($this->out), true);

    expect(array_keys($manifest))->toBe(['accordion', 'button', 'icon'])
        ->and($manifest['button'])->toBe(['tier' => 'free', 'type' => 'component', 'files' => ['button.blade.php'], 'deps' => ['icon']])
        ->and($manifest['icon']['deps'])->toBe([])
        ->and($manifest['accordion']['files'])->toBe(['accordion.blade.php', 'accordion/item.blade.php'])
        ->and($manifest['accordion']['deps'])->toBe([]);
});

it('emits block entries from the blocks subdir with type block', function () {
    $src = sys_get_temp_dir().'/aura-manifest-blocks-'.uniqid();
    $out = $src.'/aura-registry.json';
    \Illuminate\Support\Facades\File::ensureDirectoryExists($src.'/blocks');
    \Illuminate\Support\Facades\File::put($src.'/button.blade.php', '<button>x</button>');
    \Illuminate\Support\Facades\File::put($src.'/blocks/hero-split.blade.php', '<section><x-aura::button>Go</x-aura::button></section>');

    $this->artisan('aura:manifest', ['--source' => $src, '--output' => $out, '--tier' => 'free'])->assertSuccessful();
    $manifest = json_decode(\Illuminate\Support\Facades\File::get($out), true);

    expect($manifest['button']['type'])->toBe('component')
        ->and($manifest['hero-split']['type'])->toBe('block')
        ->and($manifest['hero-split']['files'])->toBe(['blocks/hero-split.blade.php'])
        ->and($manifest['hero-split']['deps'])->toBe(['button']);

    \Illuminate\Support\Facades\File::deleteDirectory($src);
});
