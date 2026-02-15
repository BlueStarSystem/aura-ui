<?php

use Illuminate\Support\Facades\Blade;

it('renders nav with aria label', function () {
    $html = Blade::render('<x-aura::breadcrumbs :items="$items" />', [
        'items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Page']],
    ]);

    expect($html)
        ->toContain('aura-breadcrumbs')
        ->toContain('aria-label="Breadcrumbs"')
        ->toContain('<nav');
});

it('renders items as list', function () {
    $html = Blade::render('<x-aura::breadcrumbs :items="$items" />', [
        'items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Products', 'href' => '/products'], ['label' => 'Detail']],
    ]);

    expect($html)
        ->toContain('Home')
        ->toContain('Products')
        ->toContain('Detail');
});

it('marks last item as current', function () {
    $html = Blade::render('<x-aura::breadcrumbs :items="$items" />', [
        'items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Current']],
    ]);

    expect($html)
        ->toContain('aura-breadcrumbs-current')
        ->toContain('aria-current="page"');
});

it('renders links for non-current items', function () {
    $html = Blade::render('<x-aura::breadcrumbs :items="$items" />', [
        'items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Current']],
    ]);

    expect($html)
        ->toContain('aura-breadcrumbs-link')
        ->toContain('href="/"');
});

it('renders chevron separator by default', function () {
    $html = Blade::render('<x-aura::breadcrumbs :items="$items" />', [
        'items' => [['label' => 'A', 'href' => '/'], ['label' => 'B']],
    ]);

    expect($html)->toContain('aura-breadcrumbs-separator');
});

it('renders slash separator', function () {
    $html = Blade::render('<x-aura::breadcrumbs :items="$items" separator="slash" />', [
        'items' => [['label' => 'A', 'href' => '/'], ['label' => 'B']],
    ]);

    expect($html)->toContain('/');
});

it('renders dot separator', function () {
    $html = Blade::render('<x-aura::breadcrumbs :items="$items" separator="dot" />', [
        'items' => [['label' => 'A', 'href' => '/'], ['label' => 'B']],
    ]);

    expect($html)->toContain('·');
});

it('renders icon when provided', function () {
    $html = Blade::render('<x-aura::breadcrumbs :items="$items" />', [
        'items' => [['label' => 'Home', 'href' => '/', 'icon' => 'home'], ['label' => 'Page']],
    ]);

    expect($html)->toContain('<svg');
});

it('renders empty when no items', function () {
    $html = Blade::render('<x-aura::breadcrumbs :items="$items" />', [
        'items' => [],
    ]);

    expect($html)->toContain('aura-breadcrumbs');
});

it('does not show separator for single item', function () {
    $html = Blade::render('<x-aura::breadcrumbs :items="$items" />', [
        'items' => [['label' => 'Home']],
    ]);

    expect($html)->not->toContain('aura-breadcrumbs-separator');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::breadcrumbs :items="$items" id="bc" />', [
        'items' => [['label' => 'Home']],
    ]);

    expect($html)->toContain('id="bc"');
});
