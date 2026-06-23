<?php

use BlueStarSystem\AuraUI\Support\ComponentInstaller;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->dest = sys_get_temp_dir().'/aura-remote-test-'.uniqid();
    File::ensureDirectoryExists($this->dest);
});

afterEach(function () {
    File::deleteDirectory($this->dest);
});

it('writes remote files with the namespace rewrite', function () {
    $installer = new ComponentInstaller(['free' => $this->dest.'/__unused'], $this->dest);

    $report = $installer->installRemote([
        ['name' => 'button', 'files' => ['button.blade.php' => '<x-aura::icon />']],
    ], force: false, dryRun: false);

    expect($report['written'])->toContain('button.blade.php');
    expect(File::get($this->dest.'/button.blade.php'))->toContain('<x-aura.icon');
});

it('skips existing files without force and honours dry-run', function () {
    $installer = new ComponentInstaller(['free' => $this->dest.'/__unused'], $this->dest);
    File::put($this->dest.'/button.blade.php', 'OLD');

    $report = $installer->installRemote([['name' => 'button', 'files' => ['button.blade.php' => 'NEW']]], false, false);
    expect($report['skipped'])->toContain('button.blade.php');
    expect(File::get($this->dest.'/button.blade.php'))->toBe('OLD');

    $dry = $installer->installRemote([['name' => 'x', 'files' => ['x.blade.php' => 'X']]], false, true);
    expect($dry['written'])->toContain('x.blade.php');
    expect(File::exists($this->dest.'/x.blade.php'))->toBeFalse();
});

it('refuses an unsafe path', function () {
    $installer = new ComponentInstaller(['free' => $this->dest.'/__unused'], $this->dest);
    $installer->installRemote([['name' => 'evil', 'files' => ['../evil.php' => 'x']]], false, false);
})->throws(RuntimeException::class);
