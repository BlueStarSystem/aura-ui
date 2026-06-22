<?php

use BlueStarSystem\AuraUI\Support\ComponentInstaller;
use BlueStarSystem\AuraUI\Support\ComponentManifest;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->root = sys_get_temp_dir().'/aura-install-'.uniqid();
    $this->srcFree = $this->root.'/src-free';
    $this->dest = $this->root.'/dest';
    File::ensureDirectoryExists($this->srcFree);
    File::put($this->srcFree.'/icon.blade.php', '<svg>icon</svg>');
    File::put($this->srcFree.'/button.blade.php', '<button><x-aura::icon /></button>');

    $this->manifest = new ComponentManifest([
        'button' => ['tier' => 'free', 'files' => ['button.blade.php'], 'deps' => ['icon']],
        'icon'   => ['tier' => 'free', 'files' => ['icon.blade.php'], 'deps' => []],
    ]);
    $this->installer = new ComponentInstaller(['free' => $this->srcFree], $this->dest);
});

afterEach(fn () => File::deleteDirectory($this->root));

it('rewrites the inter-component namespace to dot form', function () {
    expect(ComponentInstaller::rewriteNamespace('<x-aura::icon /></x-aura::icon>'))
        ->toBe('<x-aura.icon /></x-aura.icon>');
});

it('writes resolved components with rewritten references', function () {
    $report = $this->installer->install(['icon', 'button'], $this->manifest, force: false, dryRun: false);

    expect($report['written'])->toBe(['icon.blade.php', 'button.blade.php'])
        ->and(File::get($this->dest.'/button.blade.php'))->toBe('<button><x-aura.icon /></button>')
        ->and(File::exists($this->dest.'/icon.blade.php'))->toBeTrue();
});

it('skips existing files unless forced', function () {
    File::ensureDirectoryExists($this->dest);
    File::put($this->dest.'/icon.blade.php', 'MINE');

    $report = $this->installer->install(['icon'], $this->manifest, force: false, dryRun: false);
    expect($report['skipped'])->toBe(['icon.blade.php'])
        ->and(File::get($this->dest.'/icon.blade.php'))->toBe('MINE');

    $this->installer->install(['icon'], $this->manifest, force: true, dryRun: false);
    expect(File::get($this->dest.'/icon.blade.php'))->toBe('<svg>icon</svg>');
});

it('writes nothing on dry-run', function () {
    $report = $this->installer->install(['icon'], $this->manifest, force: false, dryRun: true);
    expect($report['written'])->toBe(['icon.blade.php'])
        ->and(File::exists($this->dest.'/icon.blade.php'))->toBeFalse();
});
