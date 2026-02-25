<?php

use Illuminate\Support\Facades\Blade;

it('renders a countdown', function () {
    $html = Blade::render('<x-aura::countdown :seconds="3600" />');

    expect($html)
        ->toContain('aura-countdown')
        ->toContain('role="timer"');
});

it('renders with seconds prop', function () {
    $html = Blade::render('<x-aura::countdown :seconds="120" />');

    expect($html)->toContain('this.remaining = 120');
});

it('renders countdown segments', function () {
    $html = Blade::render('<x-aura::countdown :seconds="3600" />');

    expect($html)
        ->toContain('aura-countdown-segment')
        ->toContain('aura-countdown-sep');
});

it('renders default labels', function () {
    $html = Blade::render('<x-aura::countdown :seconds="3600" />');

    expect($html)
        ->toContain('hrs')
        ->toContain('min')
        ->toContain('sec');
});

it('hides labels when disabled', function () {
    $html = Blade::render('<x-aura::countdown :seconds="3600" :labels="false" />');

    expect($html)->not->toContain('hrs');
});

it('renders custom separator', function () {
    $html = Blade::render('<x-aura::countdown :seconds="3600" separator="-" />');

    expect($html)->toContain('-');
});

it('renders small size', function () {
    $html = Blade::render('<x-aura::countdown :seconds="60" size="sm" />');

    expect($html)->toContain('text-lg');
});

it('renders large size', function () {
    $html = Blade::render('<x-aura::countdown :seconds="60" size="lg" />');

    expect($html)->toContain('text-5xl');
});

it('dispatches countdown-finished event', function () {
    $html = Blade::render('<x-aura::countdown :seconds="60" />');

    expect($html)->toContain('countdown-finished');
});
