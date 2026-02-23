<?php

use Illuminate\Support\Facades\Blade;

it('renders profile with name', function () {
    $html = Blade::render('<x-aura::profile name="John Doe" />');

    expect($html)
        ->toContain('aura-profile')
        ->toContain('aura-profile-name')
        ->toContain('John Doe');
});

it('renders subtitle', function () {
    $html = Blade::render('<x-aura::profile name="John Doe" subtitle="Developer" />');

    expect($html)
        ->toContain('aura-profile-subtitle')
        ->toContain('Developer');
});

it('renders avatar with initials', function () {
    $html = Blade::render('<x-aura::profile name="John Doe" />');

    expect($html)->toContain('JD');
});

it('renders as link when href provided', function () {
    $html = Blade::render('<x-aura::profile name="John" href="/profile" />');

    expect($html)
        ->toContain('<a')
        ->toContain('href="/profile"');
});

it('renders as div when no href', function () {
    $html = Blade::render('<x-aura::profile name="John" />');

    expect($html)->toContain('<div');
});

it('renders small size', function () {
    $html = Blade::render('<x-aura::profile name="John" size="sm" />');

    expect($html)->toContain('text-sm');
});

it('renders large size', function () {
    $html = Blade::render('<x-aura::profile name="John" size="lg" />');

    expect($html)->toContain('text-lg');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::profile name="John" id="prof" />');

    expect($html)->toContain('id="prof"');
});
