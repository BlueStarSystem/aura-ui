<?php

use Illuminate\Support\Facades\Blade;

it('renders horizontal separator by default', function () {
    $html = Blade::render('<x-aura::separator />');

    expect($html)
        ->toContain('aura-separator')
        ->toContain('border-t');
});

it('renders vertical separator', function () {
    $html = Blade::render('<x-aura::separator orientation="vertical" />');

    expect($html)
        ->toContain('aura-separator')
        ->toContain('border-l');
});

it('renders with label', function () {
    $html = Blade::render('<x-aura::separator label="OR" />');

    expect($html)
        ->toContain('aura-separator-labeled')
        ->toContain('aura-separator-label')
        ->toContain('OR');
});

it('renders default variant (solid)', function () {
    $html = Blade::render('<x-aura::separator />');

    expect($html)->toContain('border-solid');
});

it('renders dashed variant', function () {
    $html = Blade::render('<x-aura::separator variant="dashed" />');

    expect($html)->toContain('border-dashed');
});

it('renders dotted variant', function () {
    $html = Blade::render('<x-aura::separator variant="dotted" />');

    expect($html)->toContain('border-dotted');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::separator id="sep" />');

    expect($html)->toContain('id="sep"');
});
