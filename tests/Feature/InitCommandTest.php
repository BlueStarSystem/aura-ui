<?php

use Illuminate\Support\Facades\File;

it('creates the destination directory and prints the import hint', function () {
    $dest = sys_get_temp_dir().'/aura-init-'.uniqid();

    $this->artisan('aura:init', ['--path' => $dest])
        ->expectsOutputToContain('vendor/aura-ui/aura.css')
        ->assertSuccessful();

    expect(File::exists($dest.'/.gitkeep'))->toBeTrue();

    File::deleteDirectory($dest);
});
