<?php

use Illuminate\Support\Facades\Blade;

it('renders field with label', function () {
    $html = Blade::render('<x-aura::field label="Email"><input /></x-aura::field>');

    expect($html)
        ->toContain('aura-field')
        ->toContain('aura-label')
        ->toContain('Email');
});

it('renders for attribute on label', function () {
    $html = Blade::render('<x-aura::field label="Email" for="email"><input /></x-aura::field>');

    expect($html)->toContain('for="email"');
});

it('renders required indicator', function () {
    $html = Blade::render('<x-aura::field label="Email" :required="true"><input /></x-aura::field>');

    expect($html)
        ->toContain('aura-field-required')
        ->toContain('*');
});

it('renders hint text', function () {
    $html = Blade::render('<x-aura::field hint="Enter your email"><input /></x-aura::field>');

    expect($html)
        ->toContain('aura-input-hint')
        ->toContain('Enter your email');
});

it('renders error text', function () {
    $html = Blade::render('<x-aura::field error="Required"><input /></x-aura::field>');

    expect($html)
        ->toContain('aura-input-error-text')
        ->toContain('Required')
        ->toContain('aura-has-error');
});

it('renders error instead of hint when both present', function () {
    $html = Blade::render('<x-aura::field error="Err" hint="Help"><input /></x-aura::field>');

    expect($html)
        ->toContain('Err')
        ->not->toContain('Help');
});

it('renders slot content', function () {
    $html = Blade::render('<x-aura::field label="Name"><span>custom</span></x-aura::field>');

    expect($html)->toContain('custom');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::field id="field"><input /></x-aura::field>');

    expect($html)->toContain('id="field"');
});
