<?php

use Illuminate\Support\Facades\Blade;

it('renders with default props', function () {
    $html = Blade::render('<x-aura::subheading>Description text</x-aura::subheading>');

    expect($html)
        ->toContain('<p')
        ->toContain('aura-subheading')
        ->toContain('text-sm')
        ->toContain('text-aura-surface-500')
        ->toContain('Description text');
});

it('renders all sizes', function (string $size, string $expected) {
    $html = Blade::render("<x-aura::subheading size=\"{$size}\">Text</x-aura::subheading>");

    expect($html)->toContain($expected);
})->with([
    ['sm', 'text-sm'],
    ['base', 'text-base'],
    ['lg', 'text-lg'],
]);

it('renders as span', function () {
    $html = Blade::render('<x-aura::subheading as="span">Inline</x-aura::subheading>');

    expect($html)
        ->toContain('<span')
        ->not->toContain('<p');
});

it('renders as div', function () {
    $html = Blade::render('<x-aura::subheading as="div">Block</x-aura::subheading>');

    expect($html)
        ->toContain('<div')
        ->not->toContain('<p');
});

it('falls back to p for invalid tag', function () {
    $html = Blade::render('<x-aura::subheading as="script">Safe</x-aura::subheading>');

    expect($html)->toContain('<p');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::subheading id="subtitle" class="mt-2">Text</x-aura::subheading>');

    expect($html)
        ->toContain('id="subtitle"')
        ->toContain('mt-2');
});

it('includes leading-relaxed', function () {
    $html = Blade::render('<x-aura::subheading>Text</x-aura::subheading>');

    expect($html)->toContain('leading-relaxed');
});
