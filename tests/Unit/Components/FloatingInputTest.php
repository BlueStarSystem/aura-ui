<?php

use Illuminate\Support\Facades\Blade;

it('renders floating input with label', function () {
    $html = Blade::render('<x-aura::floating-input name="email" label="Email address" />');

    expect($html)->toContain('aura-floating-input');
    expect($html)->toContain('Email address');
    expect($html)->toContain('name="email"');
});

it('renders with type attribute', function () {
    $html = Blade::render('<x-aura::floating-input name="pwd" label="Password" type="password" />');

    expect($html)->toContain('type="password"');
});

it('renders with initial value', function () {
    $html = Blade::render('<x-aura::floating-input name="name" label="Name" value="John" />');

    expect($html)->toContain('John');
});

it('renders error state', function () {
    $html = Blade::render('<x-aura::floating-input name="email" label="Email" error="Invalid email" />');

    expect($html)->toContain('Invalid email');
    expect($html)->toContain('aura-floating-input--error');
});

it('renders disabled state', function () {
    $html = Blade::render('<x-aura::floating-input name="code" label="Code" :disabled="true" />');

    expect($html)->toContain('disabled');
});

it('renders required attribute', function () {
    $html = Blade::render('<x-aura::floating-input name="email" label="Email" :required="true" />');

    expect($html)->toContain('required');
});

it('passes custom attributes', function () {
    $html = Blade::render('<x-aura::floating-input name="test" label="Test" id="my-input" />');

    expect($html)->toContain('id="my-input"');
});
