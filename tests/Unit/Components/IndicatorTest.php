<?php

use Illuminate\Support\Facades\Blade;

it('renders an indicator', function () {
    $html = Blade::render('<x-aura::indicator><span>Icon</span></x-aura::indicator>');

    expect($html)
        ->toContain('aura-indicator')
        ->toContain('aura-indicator-badge')
        ->toContain('Icon');
});

it('renders danger color by default', function () {
    $html = Blade::render('<x-aura::indicator>X</x-aura::indicator>');

    expect($html)->toContain('bg-aura-danger-500');
});

it('renders primary color', function () {
    $html = Blade::render('<x-aura::indicator color="primary">X</x-aura::indicator>');

    expect($html)->toContain('bg-aura-primary-500');
});

it('renders success color', function () {
    $html = Blade::render('<x-aura::indicator color="success">X</x-aura::indicator>');

    expect($html)->toContain('bg-aura-success-500');
});

it('renders top-right by default', function () {
    $html = Blade::render('<x-aura::indicator>X</x-aura::indicator>');

    expect($html)->toContain('top-0 right-0');
});

it('renders top-left position', function () {
    $html = Blade::render('<x-aura::indicator position="top-left">X</x-aura::indicator>');

    expect($html)->toContain('top-0 left-0');
});

it('renders bottom-right position', function () {
    $html = Blade::render('<x-aura::indicator position="bottom-right">X</x-aura::indicator>');

    expect($html)->toContain('bottom-0 right-0');
});

it('renders a label', function () {
    $html = Blade::render('<x-aura::indicator label="5">X</x-aura::indicator>');

    expect($html)->toContain('5');
});

it('renders ping animation', function () {
    $html = Blade::render('<x-aura::indicator ping>X</x-aura::indicator>');

    expect($html)->toContain('aura-animate-ping');
});

it('renders without ping by default', function () {
    $html = Blade::render('<x-aura::indicator>X</x-aura::indicator>');

    expect($html)->not->toContain('aura-animate-ping');
});
