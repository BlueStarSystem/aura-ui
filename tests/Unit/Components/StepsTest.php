<?php

use Illuminate\Support\Facades\Blade;

it('renders steps container', function () {
    $html = Blade::render('<x-aura::steps>content</x-aura::steps>');

    expect($html)
        ->toContain('aura-steps')
        ->toContain('x-data');
});

it('renders horizontal variant by default', function () {
    $html = Blade::render('<x-aura::steps>c</x-aura::steps>');

    expect($html)->toContain('aura-steps-horizontal');
});

it('renders vertical variant', function () {
    $html = Blade::render('<x-aura::steps variant="vertical">c</x-aura::steps>');

    expect($html)->toContain('aura-steps-vertical');
});

it('renders md size by default', function () {
    $html = Blade::render('<x-aura::steps>c</x-aura::steps>');

    expect($html)->toContain('aura-steps-md');
});

it('renders sm size', function () {
    $html = Blade::render('<x-aura::steps size="sm">c</x-aura::steps>');

    expect($html)->toContain('aura-steps-sm');
});

it('sets current step index', function () {
    $html = Blade::render('<x-aura::steps :current="2">c</x-aura::steps>');

    expect($html)->toContain('current: 2');
});

it('defaults to step 0', function () {
    $html = Blade::render('<x-aura::steps>c</x-aura::steps>');

    expect($html)->toContain('current: 0');
});

it('renders step item', function () {
    $html = Blade::render('<x-aura::steps><x-aura::steps.step :step="0" label="First" /></x-aura::steps>');

    expect($html)
        ->toContain('aura-steps-item')
        ->toContain('First');
});

it('renders step number', function () {
    $html = Blade::render('<x-aura::steps><x-aura::steps.step :step="0" label="First" /></x-aura::steps>');

    expect($html)->toContain('aura-steps-number');
});

it('renders step with icon instead of number', function () {
    $html = Blade::render('<x-aura::steps><x-aura::steps.step :step="0" label="First" icon="user" /></x-aura::steps>');

    expect($html)->toContain('<svg');
});

it('renders step description', function () {
    $html = Blade::render('<x-aura::steps><x-aura::steps.step :step="0" label="First" description="Step details" /></x-aura::steps>');

    expect($html)
        ->toContain('aura-steps-description')
        ->toContain('Step details');
});

it('renders check icon for completed steps', function () {
    $html = Blade::render('<x-aura::steps :current="1"><x-aura::steps.step :step="0" label="Done" /></x-aura::steps>');

    expect($html)->toContain('aura-steps-check');
});

it('has alpine bindings for step status', function () {
    $html = Blade::render('<x-aura::steps><x-aura::steps.step :step="0" label="Test" /></x-aura::steps>');

    expect($html)
        ->toContain('aura-steps-completed')
        ->toContain('aura-steps-active')
        ->toContain('aura-steps-pending');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::steps id="wizard">c</x-aura::steps>');

    expect($html)->toContain('id="wizard"');
});
