<?php

use Illuminate\Support\Facades\Blade;

// Container tests

it('renders container with default size', function () {
    $html = Blade::render('<x-aura::container>Content</x-aura::container>');

    expect($html)
        ->toContain('aura-container')
        ->toContain('max-w-screen-lg')
        ->toContain('mx-auto')
        ->toContain('Content');
});

it('renders container with all sizes', function (string $size, string $expected) {
    $html = Blade::render("<x-aura::container size=\"{$size}\">Content</x-aura::container>");

    expect($html)->toContain($expected);
})->with([
    ['sm', 'max-w-screen-sm'],
    ['md', 'max-w-screen-md'],
    ['lg', 'max-w-screen-lg'],
    ['xl', 'max-w-screen-xl'],
    ['full', 'max-w-full'],
]);

it('merges custom attributes on container', function () {
    $html = Blade::render('<x-aura::container id="main-container">Content</x-aura::container>');

    expect($html)->toContain('id="main-container"');
});

// Layout tests

it('renders layout with default aside right', function () {
    $html = Blade::render('<x-aura::layout>Content</x-aura::layout>');

    expect($html)
        ->toContain('aura-layout')
        ->toContain('aura-layout-aside-right')
        ->toContain('flex')
        ->toContain('Content');
});

it('renders layout with aside left', function () {
    $html = Blade::render('<x-aura::layout aside="left">Content</x-aura::layout>');

    expect($html)
        ->toContain('aura-layout-aside-left')
        ->toContain('flex-row-reverse');
});

it('merges custom attributes on layout', function () {
    $html = Blade::render('<x-aura::layout class="custom-layout">Content</x-aura::layout>');

    expect($html)->toContain('custom-layout');
});

// Main tests

it('renders main element', function () {
    $html = Blade::render('<x-aura::main>Content</x-aura::main>');

    expect($html)
        ->toContain('<main')
        ->toContain('aura-main')
        ->toContain('flex-1')
        ->toContain('Content');
});

it('merges custom attributes on main', function () {
    $html = Blade::render('<x-aura::main id="content-area">Content</x-aura::main>');

    expect($html)->toContain('id="content-area"');
});

// Aside tests

it('renders aside with default width', function () {
    $html = Blade::render('<x-aura::aside>Sidebar</x-aura::aside>');

    expect($html)
        ->toContain('<aside')
        ->toContain('aura-aside')
        ->toContain('lg:w-64')
        ->toContain('Sidebar');
});

it('renders aside with all widths', function (string $width, string $expected) {
    $html = Blade::render("<x-aura::aside width=\"{$width}\">Sidebar</x-aura::aside>");

    expect($html)->toContain($expected);
})->with([
    ['sm', 'lg:w-56'],
    ['md', 'lg:w-64'],
    ['lg', 'lg:w-80'],
]);

it('renders aside with sticky', function () {
    $html = Blade::render('<x-aura::aside sticky>Sidebar</x-aura::aside>');

    expect($html)
        ->toContain('aura-aside-sticky')
        ->toContain('lg:sticky');
});

it('merges custom attributes on aside', function () {
    $html = Blade::render('<x-aura::aside id="sidebar">Content</x-aura::aside>');

    expect($html)->toContain('id="sidebar"');
});

// Full layout composition

it('renders full layout composition', function () {
    $html = Blade::render('
        <x-aura::container>
            <x-aura::layout>
                <x-aura::main>Main content</x-aura::main>
                <x-aura::aside>Sidebar</x-aura::aside>
            </x-aura::layout>
        </x-aura::container>
    ');

    expect($html)
        ->toContain('aura-container')
        ->toContain('aura-layout')
        ->toContain('<main')
        ->toContain('<aside')
        ->toContain('Main content')
        ->toContain('Sidebar');
});
