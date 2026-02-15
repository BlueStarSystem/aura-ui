<?php

use Illuminate\Support\Facades\Blade;

it('renders with default props', function () {
    $html = Blade::render('<x-aura::alert>Message here</x-aura::alert>');

    expect($html)
        ->toContain('aura-alert')
        ->toContain('aura-alert-info')
        ->toContain('role="alert"')
        ->toContain('Message here');
});

it('renders all variants', function (string $variant) {
    $html = Blade::render("<x-aura::alert variant=\"{$variant}\">Test</x-aura::alert>");

    expect($html)->toContain("aura-alert-{$variant}");
})->with(['info', 'success', 'warning', 'danger']);

it('renders with bordered class by default', function () {
    $html = Blade::render('<x-aura::alert>Test</x-aura::alert>');

    expect($html)->toContain('aura-alert-bordered');
});

it('renders without border when bordered is false', function () {
    $html = Blade::render('<x-aura::alert :bordered="false">Test</x-aura::alert>');

    expect($html)->not->toContain('aura-alert-bordered');
});

it('renders default icon per variant', function () {
    $html = Blade::render('<x-aura::alert variant="success">Test</x-aura::alert>');

    expect($html)->toContain('aura-alert-icon');
});

it('renders dismissible button with alpine', function () {
    $html = Blade::render('<x-aura::alert dismissible>Test</x-aura::alert>');

    expect($html)
        ->toContain('aura-alert-dismiss')
        ->toContain('x-data')
        ->toContain('x-show');
});

it('renders title slot', function () {
    $html = Blade::render('
        <x-aura::alert>
            <x-slot:title>Important</x-slot:title>
            Body text
        </x-aura::alert>
    ');

    expect($html)
        ->toContain('aura-alert-title')
        ->toContain('Important');
});
