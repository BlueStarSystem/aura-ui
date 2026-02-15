<?php

use Illuminate\Support\Facades\Blade;

it('renders with default props', function () {
    $html = Blade::render('<x-aura::input />');

    expect($html)
        ->toContain('aura-input')
        ->toContain('aura-input-md')
        ->toContain('type="text"');
});

it('renders with label', function () {
    $html = Blade::render('<x-aura::input label="Email" />');

    expect($html)
        ->toContain('aura-label')
        ->toContain('Email');
});

it('renders with hint text', function () {
    $html = Blade::render('<x-aura::input hint="Enter your email" />');

    expect($html)
        ->toContain('aura-input-hint')
        ->toContain('Enter your email');
});

it('renders error state', function () {
    $html = Blade::render('<x-aura::input error="This field is required" />');

    expect($html)
        ->toContain('aura-input-error')
        ->toContain('aura-input-error-text')
        ->toContain('This field is required');
});

it('renders error instead of hint when both present', function () {
    $html = Blade::render('<x-aura::input hint="Help text" error="Error text" />');

    expect($html)
        ->toContain('Error text')
        ->not->toContain('Help text');
});

it('renders with placeholder', function () {
    $html = Blade::render('<x-aura::input placeholder="Type here..." />');

    expect($html)->toContain('placeholder="Type here..."');
});

it('renders different types', function (string $type) {
    $html = Blade::render("<x-aura::input type=\"{$type}\" />");

    expect($html)->toContain("type=\"{$type}\"");
})->with(['text', 'email', 'password', 'number', 'tel', 'url']);

it('renders different sizes', function (string $size) {
    $html = Blade::render("<x-aura::input size=\"{$size}\" />");

    expect($html)->toContain("aura-input-{$size}");
})->with(['sm', 'md', 'lg']);

it('renders as disabled', function () {
    $html = Blade::render('<x-aura::input disabled />');

    expect($html)->toContain('disabled');
});

it('renders as readonly', function () {
    $html = Blade::render('<x-aura::input readonly />');

    expect($html)->toContain('readonly');
});

it('renders prefix icon', function () {
    $html = Blade::render('<x-aura::input prefix-icon="search" />');

    expect($html)
        ->toContain('aura-input-prefix')
        ->toContain('aura-input-has-prefix');
});

it('renders suffix text', function () {
    $html = Blade::render('<x-aura::input suffix="EUR" />');

    expect($html)
        ->toContain('aura-input-suffix')
        ->toContain('EUR');
});
