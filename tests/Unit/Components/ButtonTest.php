<?php

use Illuminate\Support\Facades\Blade;

it('renders with default props', function () {
    $html = Blade::render('<x-aura::button>Click me</x-aura::button>');

    expect($html)
        ->toContain('aura-btn')
        ->toContain('aura-btn-primary')
        ->toContain('aura-btn-md')
        ->toContain('Click me');
});

it('renders all variant classes', function (string $variant) {
    $html = Blade::render("<x-aura::button variant=\"{$variant}\">Test</x-aura::button>");

    expect($html)->toContain("aura-btn-{$variant}");
})->with(['primary', 'secondary', 'success', 'warning', 'danger', 'ghost', 'link']);

it('renders all size classes', function (string $size) {
    $html = Blade::render("<x-aura::button size=\"{$size}\">Test</x-aura::button>");

    expect($html)->toContain("aura-btn-{$size}");
})->with(['xs', 'sm', 'md', 'lg', 'xl']);

it('applies outline class', function () {
    $html = Blade::render('<x-aura::button outline>Test</x-aura::button>');

    expect($html)->toContain('aura-btn-outline');
});

it('applies gradient class', function () {
    $html = Blade::render('<x-aura::button gradient>Test</x-aura::button>');

    expect($html)->toContain('aura-btn-gradient');
});

it('renders as disabled when disabled', function () {
    $html = Blade::render('<x-aura::button disabled>Test</x-aura::button>');

    expect($html)->toContain('disabled');
});

it('renders as disabled when loading', function () {
    $html = Blade::render('<x-aura::button loading>Test</x-aura::button>');

    expect($html)
        ->toContain('aura-btn-loading')
        ->toContain('disabled')
        ->toContain('aura-btn-spinner');
});

it('renders as link when href is provided', function () {
    $html = Blade::render('<x-aura::button href="/dashboard">Go</x-aura::button>');

    expect($html)
        ->toContain('<a ')
        ->toContain('href="/dashboard"')
        ->not->toContain('<button');
});

it('renders as button by default', function () {
    $html = Blade::render('<x-aura::button>Test</x-aura::button>');

    expect($html)
        ->toContain('<button')
        ->toContain('type="button"');
});

it('renders submit type', function () {
    $html = Blade::render('<x-aura::button type="submit">Save</x-aura::button>');

    expect($html)->toContain('type="submit"');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::button id="my-btn" data-action="save">Test</x-aura::button>');

    expect($html)
        ->toContain('id="my-btn"')
        ->toContain('data-action="save"');
});
