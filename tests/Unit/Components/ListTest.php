<?php

use Illuminate\Support\Facades\Blade;

it('renders a list', function () {
    $html = Blade::render('<x-aura::list><x-aura::list.item>Item 1</x-aura::list.item></x-aura::list>');

    expect($html)
        ->toContain('aura-list')
        ->toContain('aura-list-item')
        ->toContain('Item 1');
});

it('renders as ul element', function () {
    $html = Blade::render('<x-aura::list><x-aura::list.item>A</x-aura::list.item></x-aura::list>');

    expect($html)->toContain('<ul');
});

it('renders list item as li element', function () {
    $html = Blade::render('<x-aura::list.item>Test</x-aura::list.item>');

    expect($html)->toContain('<li');
});

it('renders divided variant', function () {
    $html = Blade::render('<x-aura::list divided><x-aura::list.item>A</x-aura::list.item></x-aura::list>');

    expect($html)->toContain('divide-y');
});

it('renders bordered variant', function () {
    $html = Blade::render('<x-aura::list variant="bordered"><x-aura::list.item>A</x-aura::list.item></x-aura::list>');

    expect($html)->toContain('border');
});

it('renders list item content slot', function () {
    $html = Blade::render('<x-aura::list.item>My content</x-aura::list.item>');

    expect($html)
        ->toContain('aura-list-item-content')
        ->toContain('My content');
});

it('merges custom attributes on list', function () {
    $html = Blade::render('<x-aura::list class="my-list"><x-aura::list.item>A</x-aura::list.item></x-aura::list>');

    expect($html)->toContain('my-list');
});

it('merges custom attributes on list item', function () {
    $html = Blade::render('<x-aura::list.item class="special">B</x-aura::list.item>');

    expect($html)->toContain('special');
});
