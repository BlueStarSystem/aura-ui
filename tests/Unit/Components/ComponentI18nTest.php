<?php

use Illuminate\Support\Facades\Blade;

it('renders English component labels by default', function () {
    expect(Blade::render('<x-aura::spinner />'))->toContain('aria-label="Loading"');
    expect(Blade::render('<x-aura::breadcrumbs :items="[]" />'))->toContain('aria-label="Breadcrumbs"');
});

it('translates component labels to the active app locale', function () {
    app()->setLocale('it');

    expect(Blade::render('<x-aura::spinner />'))->toContain('aria-label="Caricamento"');
    expect(Blade::render('<x-aura::breadcrumbs :items="[]" />'))->toContain('aria-label="Percorso"');

    app()->setLocale('en');
});
