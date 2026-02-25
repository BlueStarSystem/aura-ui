<?php

use Illuminate\Support\Facades\Blade;

it('renders a kbd element', function () {
    $html = Blade::render('<x-aura::kbd>Ctrl</x-aura::kbd>');

    expect($html)
        ->toContain('<kbd')
        ->toContain('aura-kbd')
        ->toContain('Ctrl');
});

it('renders default md size', function () {
    $html = Blade::render('<x-aura::kbd>K</x-aura::kbd>');

    expect($html)->toContain('text-xs');
});

it('renders small size', function () {
    $html = Blade::render('<x-aura::kbd size="sm">K</x-aura::kbd>');

    expect($html)->toContain('text-[10px]');
});

it('renders large size', function () {
    $html = Blade::render('<x-aura::kbd size="lg">K</x-aura::kbd>');

    expect($html)->toContain('text-sm');
});

it('renders with mono font', function () {
    $html = Blade::render('<x-aura::kbd>Enter</x-aura::kbd>');

    expect($html)->toContain('font-mono');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::kbd class="custom-class">A</x-aura::kbd>');

    expect($html)->toContain('custom-class');
});
