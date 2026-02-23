<?php

use Illuminate\Support\Facades\Blade;

it('renders brand with name', function () {
    $html = Blade::render('<x-aura::brand name="Acme" />');

    expect($html)
        ->toContain('aura-brand')
        ->toContain('aura-brand-name')
        ->toContain('Acme');
});

it('renders brand with logo', function () {
    $html = Blade::render('<x-aura::brand logo="/logo.svg" name="Acme" />');

    expect($html)
        ->toContain('aura-brand-logo')
        ->toContain('src="/logo.svg"');
});

it('renders as link with default href', function () {
    $html = Blade::render('<x-aura::brand name="Acme" />');

    expect($html)
        ->toContain('<a')
        ->toContain('href="/"');
});

it('renders custom href', function () {
    $html = Blade::render('<x-aura::brand name="Acme" href="/home" />');

    expect($html)->toContain('href="/home"');
});

it('renders small size', function () {
    $html = Blade::render('<x-aura::brand name="Acme" size="sm" />');

    expect($html)->toContain('text-sm');
});

it('renders large size', function () {
    $html = Blade::render('<x-aura::brand name="Acme" size="lg" />');

    expect($html)->toContain('text-xl');
});

it('renders slot content when no logo or name', function () {
    $html = Blade::render('<x-aura::brand>Custom Brand</x-aura::brand>');

    expect($html)->toContain('Custom Brand');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::brand name="Acme" id="brand" />');

    expect($html)->toContain('id="brand"');
});
