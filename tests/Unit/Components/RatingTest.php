<?php

use Illuminate\Support\Facades\Blade;

it('renders a rating component', function () {
    $html = Blade::render('<x-aura::rating />');

    expect($html)
        ->toContain('aura-rating')
        ->toContain('aura-rating-star')
        ->toContain('role="radiogroup"');
});

it('renders 5 stars by default', function () {
    $html = Blade::render('<x-aura::rating />');

    expect(substr_count($html, 'aura-rating-star'))->toBe(5);
});

it('renders custom max stars', function () {
    $html = Blade::render('<x-aura::rating :max="3" />');

    expect(substr_count($html, 'aura-rating-star'))->toBe(3);
});

it('renders small size', function () {
    $html = Blade::render('<x-aura::rating size="sm" />');

    expect($html)->toContain('h-4 w-4');
});

it('renders large size', function () {
    $html = Blade::render('<x-aura::rating size="lg" />');

    expect($html)->toContain('h-7 w-7');
});

it('renders readonly mode', function () {
    $html = Blade::render('<x-aura::rating readonly />');

    expect($html)->toContain('cursor-default');
});

it('renders interactive mode by default', function () {
    $html = Blade::render('<x-aura::rating />');

    expect($html)->toContain('cursor-pointer');
});

it('renders primary color', function () {
    $html = Blade::render('<x-aura::rating color="primary" />');

    expect($html)->toContain('text-aura-primary-500');
});

it('renders danger color', function () {
    $html = Blade::render('<x-aura::rating color="danger" />');

    expect($html)->toContain('text-aura-danger-500');
});

it('renders aria labels', function () {
    $html = Blade::render('<x-aura::rating :max="3" />');

    expect($html)
        ->toContain('Rate 1 of 3')
        ->toContain('Rate 2 of 3')
        ->toContain('Rate 3 of 3');
});
