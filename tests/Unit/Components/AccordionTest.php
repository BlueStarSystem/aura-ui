<?php

use Illuminate\Support\Facades\Blade;

it('renders accordion container', function () {
    $html = Blade::render('<x-aura::accordion>content</x-aura::accordion>');

    expect($html)
        ->toContain('aura-accordion')
        ->toContain('x-data');
});

it('renders bordered by default', function () {
    $html = Blade::render('<x-aura::accordion>c</x-aura::accordion>');

    expect($html)->toContain('aura-accordion-bordered');
});

it('renders without border', function () {
    $html = Blade::render('<x-aura::accordion :bordered="false">c</x-aura::accordion>');

    expect($html)->not->toContain('aura-accordion-bordered');
});

it('sets multiple mode', function () {
    $html = Blade::render('<x-aura::accordion :multiple="true">c</x-aura::accordion>');

    expect($html)->toContain('multiple: true');
});

it('defaults to single mode', function () {
    $html = Blade::render('<x-aura::accordion>c</x-aura::accordion>');

    expect($html)->toContain('multiple: false');
});

it('renders accordion item with title', function () {
    $html = Blade::render('<x-aura::accordion><x-aura::accordion.item title="Section 1">Body</x-aura::accordion.item></x-aura::accordion>');

    expect($html)
        ->toContain('aura-accordion-item')
        ->toContain('Section 1')
        ->toContain('Body');
});

it('renders trigger button', function () {
    $html = Blade::render('<x-aura::accordion><x-aura::accordion.item title="Test">Body</x-aura::accordion.item></x-aura::accordion>');

    expect($html)
        ->toContain('aura-accordion-trigger')
        ->toContain('aria-expanded');
});

it('renders chevron icon', function () {
    $html = Blade::render('<x-aura::accordion><x-aura::accordion.item title="Test">Body</x-aura::accordion.item></x-aura::accordion>');

    expect($html)->toContain('aura-accordion-chevron');
});

it('renders item with icon', function () {
    $html = Blade::render('<x-aura::accordion><x-aura::accordion.item title="Test" icon="home">Body</x-aura::accordion.item></x-aura::accordion>');

    expect($html)->toContain('<svg');
});

it('renders disabled item', function () {
    $html = Blade::render('<x-aura::accordion><x-aura::accordion.item title="Test" :disabled="true">Body</x-aura::accordion.item></x-aura::accordion>');

    expect($html)->toContain('disabled');
});

it('renders content with x-show', function () {
    $html = Blade::render('<x-aura::accordion><x-aura::accordion.item title="Test">Body</x-aura::accordion.item></x-aura::accordion>');

    expect($html)
        ->toContain('x-show')
        ->toContain('x-collapse')
        ->toContain('aura-accordion-content');
});

it('sets default open via x-init', function () {
    $html = Blade::render('<x-aura::accordion><x-aura::accordion.item title="Test" :open="true">Body</x-aura::accordion.item></x-aura::accordion>');

    expect($html)->toContain('x-init');
});

it('merges custom attributes on accordion', function () {
    $html = Blade::render('<x-aura::accordion id="acc">c</x-aura::accordion>');

    expect($html)->toContain('id="acc"');
});
