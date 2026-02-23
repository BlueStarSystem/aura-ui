<?php

use Illuminate\Support\Facades\Blade;

it('renders header with title', function () {
    $html = Blade::render('<x-aura::header title="Dashboard" />');

    expect($html)
        ->toContain('aura-header')
        ->toContain('aura-header-title')
        ->toContain('Dashboard');
});

it('renders description', function () {
    $html = Blade::render('<x-aura::header title="Dashboard" description="Welcome back" />');

    expect($html)
        ->toContain('aura-header-description')
        ->toContain('Welcome back');
});

it('does not render description when not provided', function () {
    $html = Blade::render('<x-aura::header title="Test" />');

    expect($html)->not->toContain('aura-header-description');
});

it('renders default md size', function () {
    $html = Blade::render('<x-aura::header title="Test" />');

    expect($html)->toContain('text-xl');
});

it('renders small size', function () {
    $html = Blade::render('<x-aura::header title="Test" size="sm" />');

    expect($html)->toContain('text-lg');
});

it('renders large size', function () {
    $html = Blade::render('<x-aura::header title="Test" size="lg" />');

    expect($html)->toContain('text-2xl');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::header title="T" id="hdr" />');

    expect($html)->toContain('id="hdr"');
});
