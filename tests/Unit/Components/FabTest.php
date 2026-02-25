<?php

use Illuminate\Support\Facades\Blade;

it('renders a fab button', function () {
    $html = Blade::render('<x-aura::fab />');

    expect($html)
        ->toContain('aura-fab')
        ->toContain('aura-fab-button');
});

it('renders bottom-right by default', function () {
    $html = Blade::render('<x-aura::fab />');

    expect($html)->toContain('bottom-6 right-6');
});

it('renders bottom-left position', function () {
    $html = Blade::render('<x-aura::fab position="bottom-left" />');

    expect($html)->toContain('bottom-6 left-6');
});

it('renders top-right position', function () {
    $html = Blade::render('<x-aura::fab position="top-right" />');

    expect($html)->toContain('top-6 right-6');
});

it('renders default primary color', function () {
    $html = Blade::render('<x-aura::fab />');

    expect($html)->toContain('bg-aura-primary-500');
});

it('renders success color', function () {
    $html = Blade::render('<x-aura::fab color="success" />');

    expect($html)->toContain('bg-aura-success-500');
});

it('renders medium size by default', function () {
    $html = Blade::render('<x-aura::fab />');

    expect($html)->toContain('h-12 w-12');
});

it('renders small size', function () {
    $html = Blade::render('<x-aura::fab size="sm" />');

    expect($html)->toContain('h-10 w-10');
});

it('renders large size', function () {
    $html = Blade::render('<x-aura::fab size="lg" />');

    expect($html)->toContain('h-16 w-16');
});

it('renders plus icon by default', function () {
    $html = Blade::render('<x-aura::fab />');

    expect($html)->toContain('<svg');
});

it('renders fixed positioning', function () {
    $html = Blade::render('<x-aura::fab />');

    expect($html)->toContain('fixed');
});
