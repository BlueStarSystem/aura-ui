<?php

use Illuminate\Support\Facades\Blade;

it('renders the pricing-cards block with multiple plan cards', function () {
    $html = Blade::render('<x-aura::blocks.pricing-cards />');
    expect($html)->toContain('aura-card')->toContain('grid')->toContain('aura-btn');
});

it('renders the testimonials-grid block with avatars', function () {
    $html = Blade::render('<x-aura::blocks.testimonials-grid />');
    expect($html)->toContain('aura-card')->toContain('grid');
});

it('renders the faq-accordion block with an accordion', function () {
    $html = Blade::render('<x-aura::blocks.faq-accordion />');
    expect($html)->toContain('aura-accordion');
});

it('renders the auth-login block with email and password inputs', function () {
    $html = Blade::render('<x-aura::blocks.auth-login />');
    expect($html)->toContain('type="email"')->toContain('type="password"')->toContain('aura-btn');
});
