<?php

use Illuminate\Support\Facades\Blade;

it('renders with default props', function () {
    $html = Blade::render('<x-aura::badge>Active</x-aura::badge>');

    expect($html)
        ->toContain('aura-badge')
        ->toContain('aura-badge-primary')
        ->toContain('aura-badge-md')
        ->toContain('Active');
});

it('renders all variants', function (string $variant) {
    $html = Blade::render("<x-aura::badge variant=\"{$variant}\">Test</x-aura::badge>");

    expect($html)->toContain("aura-badge-{$variant}");
})->with(['primary', 'secondary', 'success', 'warning', 'danger', 'info']);

it('renders outline variant', function () {
    $html = Blade::render('<x-aura::badge outline>Test</x-aura::badge>');

    expect($html)->toContain('aura-badge-outline');
});

it('renders with dot indicator', function () {
    $html = Blade::render('<x-aura::badge dot>Online</x-aura::badge>');

    expect($html)->toContain('aura-badge-dot');
});

it('renders pill shape', function () {
    $html = Blade::render('<x-aura::badge rounded>Pill</x-aura::badge>');

    expect($html)->toContain('aura-badge-pill');
});

it('renders removable with close button', function () {
    $html = Blade::render('<x-aura::badge removable>Tag</x-aura::badge>');

    expect($html)->toContain('aura-badge-remove');
});

it('renders all sizes', function (string $size) {
    $html = Blade::render("<x-aura::badge size=\"{$size}\">Test</x-aura::badge>");

    expect($html)->toContain("aura-badge-{$size}");
})->with(['sm', 'md', 'lg']);
