<?php

use Illuminate\Support\Facades\Blade;

it('renders navbar container', function () {
    $html = Blade::render('<x-aura::navbar>content</x-aura::navbar>');

    expect($html)
        ->toContain('aura-navbar')
        ->toContain('x-data');
});

it('renders bordered by default', function () {
    $html = Blade::render('<x-aura::navbar>c</x-aura::navbar>');

    expect($html)->toContain('border-b');
});

it('renders without border', function () {
    $html = Blade::render('<x-aura::navbar :bordered="false">c</x-aura::navbar>');

    expect($html)->not->toContain('border-b');
});

it('renders sticky when set', function () {
    $html = Blade::render('<x-aura::navbar :sticky="true">c</x-aura::navbar>');

    expect($html)->toContain('sticky');
});

it('renders glass effect', function () {
    $html = Blade::render('<x-aura::navbar :glass="true">c</x-aura::navbar>');

    expect($html)->toContain('aura-glass');
});

it('renders mobile toggle button', function () {
    $html = Blade::render('<x-aura::navbar>c</x-aura::navbar>');

    expect($html)
        ->toContain('aura-navbar-toggle')
        ->toContain('aria-label="Toggle navigation"');
});

it('renders navbar item', function () {
    $html = Blade::render('<x-aura::navbar.item href="/about">About</x-aura::navbar.item>');

    expect($html)
        ->toContain('aura-navbar-item')
        ->toContain('href="/about"')
        ->toContain('About');
});

it('renders active navbar item', function () {
    $html = Blade::render('<x-aura::navbar.item href="/" :active="true">Home</x-aura::navbar.item>');

    expect($html)
        ->toContain('text-aura-primary-600')
        ->toContain('aria-current="page"');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::navbar id="nav">c</x-aura::navbar>');

    expect($html)->toContain('id="nav"');
});
