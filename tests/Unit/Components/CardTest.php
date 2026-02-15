<?php

use Illuminate\Support\Facades\Blade;

it('renders with default props', function () {
    $html = Blade::render('<x-aura::card>Content</x-aura::card>');

    expect($html)
        ->toContain('aura-card')
        ->toContain('aura-card-body')
        ->toContain('Content');
});

it('renders header slot', function () {
    $html = Blade::render('
        <x-aura::card>
            <x-slot:header>Header</x-slot:header>
            Body
        </x-aura::card>
    ');

    expect($html)
        ->toContain('aura-card-header')
        ->toContain('Header');
});

it('renders footer slot', function () {
    $html = Blade::render('
        <x-aura::card>
            Content
            <x-slot:footer>Footer</x-slot:footer>
        </x-aura::card>
    ');

    expect($html)
        ->toContain('aura-card-footer')
        ->toContain('Footer');
});

it('renders hover class', function () {
    $html = Blade::render('<x-aura::card hover>Content</x-aura::card>');

    expect($html)->toContain('aura-card-hover');
});

it('renders glass class', function () {
    $html = Blade::render('<x-aura::card glass>Content</x-aura::card>');

    expect($html)->toContain('aura-glass');
});

it('renders bordered class by default', function () {
    $html = Blade::render('<x-aura::card>Content</x-aura::card>');

    expect($html)->toContain('aura-card-bordered');
});

it('renders shadow variants', function (string $shadow) {
    $html = Blade::render("<x-aura::card shadow=\"{$shadow}\">Content</x-aura::card>");

    expect($html)->toContain("aura-card-shadow-{$shadow}");
})->with(['none', 'sm', 'md', 'lg']);
