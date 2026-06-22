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
        ->and($manifest['button'])->toBe(['tier' => 'free', 'files' => ['button.blade.php'], 'deps' => ['icon']])
        ->and($manifest['icon']['deps'])->toBe([])
        ->and($manifest['accordion']['files'])->toBe(['accordion.blade.php', 'accordion/item.blade.php'])
        ->and($manifest['accordion']['deps'])->toBe([]);
});
