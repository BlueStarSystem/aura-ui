<?php

use Illuminate\Support\Facades\Blade;

it('renders h2 by default', function () {
    $html = Blade::render('<x-aura::heading>Title</x-aura::heading>');

    expect($html)
        ->toContain('<h2')
        ->toContain('aura-heading')
        ->toContain('Title');
});

it('renders correct heading level', function () {
    $html = Blade::render('<x-aura::heading :level="3">Sub</x-aura::heading>');

    expect($html)->toContain('<h3');
});

it('renders h1', function () {
    $html = Blade::render('<x-aura::heading :level="1">Main</x-aura::heading>');

    expect($html)
        ->toContain('<h1')
        ->toContain('text-2xl');
});

it('renders custom size override', function () {
    $html = Blade::render('<x-aura::heading :level="4" size="xl">Big</x-aura::heading>');

    expect($html)
        ->toContain('<h4')
        ->toContain('text-xl');
});

it('applies tracking-tight', function () {
    $html = Blade::render('<x-aura::heading>T</x-aura::heading>');

    expect($html)->toContain('tracking-tight');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::heading id="title">T</x-aura::heading>');

    expect($html)->toContain('id="title"');
});
