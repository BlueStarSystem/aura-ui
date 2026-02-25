<?php

use Illuminate\Support\Facades\Blade;

it('renders a radial progress', function () {
    $html = Blade::render('<x-aura::radial-progress :value="75" />');

    expect($html)
        ->toContain('aura-radial-progress')
        ->toContain('role="progressbar"')
        ->toContain('aria-valuenow="75"');
});

it('renders default label with percentage', function () {
    $html = Blade::render('<x-aura::radial-progress :value="42" />');

    expect($html)->toContain('42%');
});

it('renders custom slot content instead of percentage', function () {
    $html = Blade::render('<x-aura::radial-progress :value="90">A+</x-aura::radial-progress>');

    expect($html)->toContain('A+');
});

it('hides label when showLabel is false', function () {
    $html = Blade::render('<x-aura::radial-progress :value="50" :showLabel="false" />');

    expect($html)->not->toContain('50%');
});

it('renders SVG circle', function () {
    $html = Blade::render('<x-aura::radial-progress :value="50" />');

    expect($html)
        ->toContain('<svg')
        ->toContain('<circle');
});

it('renders primary color by default', function () {
    $html = Blade::render('<x-aura::radial-progress :value="50" />');

    expect($html)->toContain('text-aura-primary-500');
});

it('renders success color', function () {
    $html = Blade::render('<x-aura::radial-progress :value="100" color="success" />');

    expect($html)->toContain('text-aura-success-500');
});

it('renders danger color', function () {
    $html = Blade::render('<x-aura::radial-progress :value="10" color="danger" />');

    expect($html)->toContain('text-aura-danger-500');
});

it('clamps value to 0-100 range', function () {
    $html = Blade::render('<x-aura::radial-progress :value="150" />');

    expect($html)->toContain('aria-valuenow="100"');
});

it('renders different sizes', function () {
    $sm = Blade::render('<x-aura::radial-progress :value="50" size="sm" />');
    $lg = Blade::render('<x-aura::radial-progress :value="50" size="lg" />');

    expect($sm)->toContain('width="48"');
    expect($lg)->toContain('width="96"');
});
