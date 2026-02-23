<?php

use Illuminate\Support\Facades\Blade;

it('renders paragraph by default', function () {
    $html = Blade::render('<x-aura::text>Hello world</x-aura::text>');

    expect($html)
        ->toContain('<p')
        ->toContain('aura-text')
        ->toContain('Hello world');
});

it('renders as span', function () {
    $html = Blade::render('<x-aura::text as="span">Inline</x-aura::text>');

    expect($html)->toContain('<span');
});

it('renders as div', function () {
    $html = Blade::render('<x-aura::text as="div">Block</x-aura::text>');

    expect($html)->toContain('<div');
});

it('renders muted color', function () {
    $html = Blade::render('<x-aura::text color="muted">Muted</x-aura::text>');

    expect($html)->toContain('text-aura-surface-400');
});

it('renders primary color', function () {
    $html = Blade::render('<x-aura::text color="primary">Primary</x-aura::text>');

    expect($html)->toContain('text-aura-primary-600');
});

it('renders small size', function () {
    $html = Blade::render('<x-aura::text size="sm">Small</x-aura::text>');

    expect($html)->toContain('text-sm');
});

it('renders bold weight', function () {
    $html = Blade::render('<x-aura::text weight="bold">Bold</x-aura::text>');

    expect($html)->toContain('font-bold');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::text id="txt">T</x-aura::text>');

    expect($html)->toContain('id="txt"');
});
