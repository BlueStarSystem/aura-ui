<?php

use Illuminate\Support\Facades\Blade;

it('renders a drawer with default props', function () {
    $html = Blade::render('<x-aura::drawer name="test-drawer">Content</x-aura::drawer>');

    expect($html)
        ->toContain('Content')
        ->toContain('drawerOpen')
        ->toContain('openDrawer')
        ->toContain('closeDrawer');
});

it('renders with a title', function () {
    $html = Blade::render('<x-aura::drawer name="d" title="My Drawer">Body</x-aura::drawer>');

    expect($html)
        ->toContain('My Drawer')
        ->toContain('Body');
});

it('renders right position by default', function () {
    $html = Blade::render('<x-aura::drawer name="d">X</x-aura::drawer>');

    expect($html)->toContain('right:0;top:0;bottom:0');
});

it('renders left position', function () {
    $html = Blade::render('<x-aura::drawer name="d" position="left">X</x-aura::drawer>');

    expect($html)->toContain('left:0;top:0;bottom:0');
});

it('renders top position', function () {
    $html = Blade::render('<x-aura::drawer name="d" position="top">X</x-aura::drawer>');

    expect($html)->toContain('top:0;left:0;right:0');
});

it('renders bottom position', function () {
    $html = Blade::render('<x-aura::drawer name="d" position="bottom">X</x-aura::drawer>');

    expect($html)->toContain('bottom:0;left:0;right:0');
});

it('renders different sizes', function () {
    $html = Blade::render('<x-aura::drawer name="d" size="lg">X</x-aura::drawer>');

    expect($html)->toContain('max-width:576px');
});

it('renders small size', function () {
    $html = Blade::render('<x-aura::drawer name="d" size="sm">X</x-aura::drawer>');

    expect($html)->toContain('max-width:320px');
});

it('renders full size', function () {
    $html = Blade::render('<x-aura::drawer name="d" size="full">X</x-aura::drawer>');

    expect($html)->toContain('max-width:100%');
});

it('renders overlay by default', function () {
    $html = Blade::render('<x-aura::drawer name="d">X</x-aura::drawer>');

    expect($html)->toContain('z-index:var(--z-aura-overlay, 400)');
});

it('renders close button when closeable', function () {
    $html = Blade::render('<x-aura::drawer name="d" title="T">X</x-aura::drawer>');

    expect($html)
        ->toContain('closeDrawer()')
        ->toContain('aria-label="Close"');
});

it('renders footer slot', function () {
    $html = Blade::render('
        <x-aura::drawer name="d">
            Body
            <x-slot:footer>Footer Content</x-slot:footer>
        </x-aura::drawer>
    ');

    expect($html)->toContain('Footer Content');
});
