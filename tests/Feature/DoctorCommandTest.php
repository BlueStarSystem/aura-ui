<?php

use Illuminate\Support\Facades\File;

function auraDoctorViews(string $blade): string
{
    $dir = sys_get_temp_dir().'/aura-doctor-'.uniqid();
    File::ensureDirectoryExists($dir);
    File::put($dir.'/page.blade.php', $blade);

    return $dir;
}

it('passes on a clean view', function () {
    $dir = auraDoctorViews('<x-aura::button variant="primary">Save</x-aura::button>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->expectsOutputToContain('no problems found')
        ->assertSuccessful();

    File::deleteDirectory($dir);
});

it('flags a variant the component does not style', function () {
    $dir = auraDoctorViews('<x-aura::badge variant="neutral">Draft</x-aura::badge>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->expectsOutputToContain('invalid-variant')
        ->assertFailed();

    File::deleteDirectory($dir);
});

it('accepts a variant the component does style', function () {
    $dir = auraDoctorViews('<x-aura::badge variant="info">Draft</x-aura::badge>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->assertSuccessful();

    File::deleteDirectory($dir);
});

it('flags an unknown component name', function () {
    $dir = auraDoctorViews('<x-aura::buton variant="primary">Typo</x-aura::buton>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->expectsOutputToContain('unknown-component')
        ->assertFailed();

    File::deleteDirectory($dir);
});

it('flags an icon-only button with no accessible name', function () {
    $dir = auraDoctorViews('<x-aura::button><x-aura::icon name="trash" /></x-aura::button>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->expectsOutputToContain('a11y')
        ->assertFailed();

    File::deleteDirectory($dir);
});

it('accepts an icon-only button that carries an aria-label', function () {
    $dir = auraDoctorViews('<x-aura::button aria-label="Delete"><x-aura::icon name="trash" /></x-aura::button>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->assertSuccessful();

    File::deleteDirectory($dir);
});

it('reports findings as JSON when asked', function () {
    $dir = auraDoctorViews('<x-aura::badge variant="neutral">Draft</x-aura::badge>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true, '--json' => true])
        ->expectsOutputToContain('"check": "invalid-variant"')
        ->assertFailed();

    File::deleteDirectory($dir);
});
