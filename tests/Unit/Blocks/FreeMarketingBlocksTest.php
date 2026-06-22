<?php

use Illuminate\Support\Facades\Blade;

it('renders the hero-split block with heading and buttons', function () {
    $html = Blade::render('<x-aura::blocks.hero-split />');
    expect($html)->toContain('<section')->toContain('<h1')->toContain('aura-btn');
});

it('renders the feature-grid block with a grid and cards', function () {
    $html = Blade::render('<x-aura::blocks.feature-grid />');
    expect($html)->toContain('<section')->toContain('grid')->toContain('aura-card');
});

it('renders the cta-simple block with a heading and a button', function () {
    $html = Blade::render('<x-aura::blocks.cta-simple />');
    expect($html)->toContain('<section')->toContain('aura-btn');
});

it('renders the stats-bar block with multiple stats', function () {
    $html = Blade::render('<x-aura::blocks.stats-bar />');
    expect($html)->toContain('<section')->toContain('grid');
});
