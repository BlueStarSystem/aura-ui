<?php

use Illuminate\Support\Facades\Blade;

it('renders stepper with steps', function () {
    $html = Blade::render('
        <x-aura::stepper :active="2">
            <x-aura::stepper.step label="First" />
            <x-aura::stepper.step label="Second" />
            <x-aura::stepper.step label="Third" />
        </x-aura::stepper>
    ');

    expect($html)->toContain('aura-stepper');
    expect($html)->toContain('First');
    expect($html)->toContain('Second');
    expect($html)->toContain('Third');
});

it('renders horizontal orientation by default', function () {
    $html = Blade::render('
        <x-aura::stepper :active="1">
            <x-aura::stepper.step label="Step 1" />
        </x-aura::stepper>
    ');

    expect($html)->toContain('aura-stepper--horizontal');
});

it('renders vertical orientation', function () {
    $html = Blade::render('
        <x-aura::stepper :active="1" orientation="vertical">
            <x-aura::stepper.step label="Step 1" />
        </x-aura::stepper>
    ');

    expect($html)->toContain('aura-stepper--vertical');
});

it('renders step with icon', function () {
    $html = Blade::render('
        <x-aura::stepper :active="1">
            <x-aura::stepper.step label="Account" icon="heroicon-o-user" />
        </x-aura::stepper>
    ');

    expect($html)->toContain('aura-stepper__step');
    expect($html)->toContain('Account');
});

it('passes custom attributes', function () {
    $html = Blade::render('
        <x-aura::stepper :active="1" id="my-stepper">
            <x-aura::stepper.step label="One" />
        </x-aura::stepper>
    ');

    expect($html)->toContain('id="my-stepper"');
});
