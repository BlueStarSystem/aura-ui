<?php

use Illuminate\Support\Facades\Blade;

it('renders a drawer with default props', function () {
    $html = Blade::render('<x-aura::drawer name="test-drawer">Content</x-aura::drawer>');

    expect($html)
        ->toContain('aura-drawer')
        ->toContain('Content')
        ->toContain('x-teleport="body"');
});

it('renders with a title', function () {
    $html = Blade::render('<x-aura::drawer name="d" title="My Drawer">Body</x-aura::drawer>');

    expect($html)
        ->toContain('My Drawer')
        ->toContain('aura-drawer-header');
});

it('renders right position by default', function () {
    $html = Blade::render('<x-aura::drawer name="d">X</x-aura::drawer>');

    expect($html)->toContain('right-0');
});

it('renders left position', function () {
    $html = Blade::render('<x-aura::drawer name="d" position="left">X</x-aura::drawer>');

    expect($html)->toContain('left-0');
});

it('renders top position', function () {
    $html = Blade::render('<x-aura::drawer name="d" position="top">X</x-aura::drawer>');

    expect($html)->toContain('top-0');
});

it('renders bottom position', function () {
    $html = Blade::render('<x-aura::drawer name="d" position="bottom">X</x-aura::drawer>');

    expect($html)->toContain('bottom-0');
});

it('renders different sizes', function () {
    $html = Blade::render('<x-aura::drawer name="d" size="lg">X</x-aura::drawer>');

    expect($html)->toContain('max-w-xl');
});

it('renders small size', function () {
    $html = Blade::render('<x-aura::drawer name="d" size="sm">X</x-aura::drawer>');

    expect($html)->toContain('max-w-xs');
});

it('renders full size', function () {
    $html = Blade::render('<x-aura::drawer name="d" size="full">X</x-aura::drawer>');

    expect($html)->toContain('max-w-full');
});

it('renders overlay by default', function () {
    $html = Blade::render('<x-aura::drawer name="d">X</x-aura::drawer>');

    expect($html)->toContain('aura-drawer-overlay');
});

it('renders close button when closeable', function () {
    $html = Blade::render('<x-aura::drawer name="d" title="T">X</x-aura::drawer>');

    expect($html)->toContain('open = false');
});

it('renders footer slot', function () {
    $html = Blade::render('
        <x-aura::drawer name="d">
            Body
            <x-slot:footer>Footer Content</x-slot:footer>
        </x-aura::drawer>
    ');

    expect($html)
        ->toContain('aura-drawer-footer')
        ->toContain('Footer Content');
});
