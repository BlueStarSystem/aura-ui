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

it('does not flag an unknown component name that only exists inside a Blade comment', function () {
    $dir = auraDoctorViews('{{-- <x-aura::buton variant="primary">Typo</x-aura::buton> --}}');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->assertSuccessful();

    File::deleteDirectory($dir);
});

describe('--a11y', function () {
    beforeEach(function () {
        $this->views = sys_get_temp_dir().'/aura-doctor-'.uniqid();
        File::makeDirectory($this->views, 0777, true);
    });

    afterEach(function () {
        File::deleteDirectory($this->views);
    });

    function writeView(string $dir, string $name, string $contents): void
    {
        File::put($dir.'/'.$name.'.blade.php', $contents);
    }

    it('flags an input with neither label nor aria-label', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertFailed();
    });

    it('does not flag an input that has a label', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" label="Email" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag an input that has an aria-label', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" aria-label="Email" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag a dynamic label', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" :label="$label" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag an input wrapped by a <label> with no for/id', function () {
        writeView($this->views, 'page', '<label>Email <x-aura::input name="email" /></label>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('still flags an unlabelled input that follows an unrelated, already-closed <label>', function () {
        writeView($this->views, 'page', '<label>Something else</label><x-aura::input name="email" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertFailed();
    });

    it('flags a second, genuinely unlabelled input that follows a wrapping label', function () {
        writeView($this->views, 'page', '<label>Email <x-aura::input name="email" /></label><x-aura::input name="name" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--json' => true, '--skip-setup' => true])
            ->expectsOutputToContain('"errors": 1')
            ->assertFailed();
    });

    it('still flags an input that has an id but no matching <label for>', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" id="email" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertFailed();
    });

    it('does not flag an input associated with a native <label for>', function () {
        writeView($this->views, 'page', '<label for="email">Email</label><x-aura::input name="email" id="email" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag an input with a dynamic id, since the matching label cannot be resolved statically', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" :id="$fieldId" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('flags an img without alt', function () {
        writeView($this->views, 'page', '<img src="/logo.png">');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertFailed();
    });

    it('accepts an empty alt as a deliberate decorative image', function () {
        writeView($this->views, 'page', '<img src="/deco.png" alt="">');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('accepts role="presentation" as a deliberate decorative image', function () {
        writeView($this->views, 'page', '<img src="/deco.png" role="presentation">');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('accepts role="none" as a deliberate decorative image', function () {
        writeView($this->views, 'page', '<img src="/deco.png" role="none">');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('warns without failing on generic link text', function () {
        writeView($this->views, 'page', '<a href="/x">clicca qui</a>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();   // warning, non error
    });

    it('flags a positive tabindex', function () {
        writeView($this->views, 'page', '<div tabindex="3">x</div>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertFailed();
    });

    it('does not flag tabindex="-1" or tabindex="0"', function () {
        writeView($this->views, 'page', '<div tabindex="-1">a</div><div tabindex="0">b</div>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('flags a modal with no accessible name', function () {
        writeView($this->views, 'page', '<x-aura::modal name="confirm">body</x-aura::modal>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertFailed();
    });

    it('does not flag a modal that has a title', function () {
        writeView($this->views, 'page', '<x-aura::modal name="confirm" title="Confirm">body</x-aura::modal>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag a modal whose title comes from a named slot', function () {
        writeView($this->views, 'page', '<x-aura::modal name="confirm"><x-slot:title>Confirm</x-slot:title>body</x-aura::modal>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag <x-aura::select.option> as an unlabelled select', function () {
        writeView($this->views, 'page', '<x-aura::select label="Plan"><x-aura::select.option value="a">A</x-aura::select.option></x-aura::select>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('warns without failing when a heading level is skipped', function () {
        writeView($this->views, 'page', '<h1>Title</h1><h3>Sub</h3>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();   // warning, non error
    });

    it('does not warn on a well-ordered outline, nor on going back up', function () {
        writeView($this->views, 'page', '<h1>A</h1><h2>B</h2><h3>C</h3><h2>D</h2>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--json' => true, '--skip-setup' => true])
            ->expectsOutputToContain('"warnings": 0')
            ->assertSuccessful();
    });

    it('runs no a11y checks without the flag', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" />');

        $this->artisan('aura:doctor', ['--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag markup that only exists inside a Blade comment', function () {
        writeView($this->views, 'page', '{{-- <x-aura::input name="email" /> --}}{{-- <img src="/x.png"> --}}');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('reports the correct line number for a finding that follows a multi-line comment', function () {
        writeView($this->views, 'page', "{{--\n  a comment\n  spanning lines\n--}}\n<img src=\"/logo.png\">");

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--json' => true, '--skip-setup' => true])
            ->expectsOutputToContain('"line": 5')
            ->assertFailed();
    });
});
