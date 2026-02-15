<?php

use Illuminate\Support\Facades\Blade;

it('renders kanban container', function () {
    $html = Blade::render('<x-aura::kanban>content</x-aura::kanban>');

    expect($html)
        ->toContain('aura-kanban')
        ->toContain('x-data')
        ->toContain('aura-kanban-board');
});

it('has drag and drop methods', function () {
    $html = Blade::render('<x-aura::kanban>c</x-aura::kanban>');

    expect($html)
        ->toContain('onDragStart')
        ->toContain('onDragEnd')
        ->toContain('onDragOver')
        ->toContain('onDrop');
});

it('dispatches kanban-moved event', function () {
    $html = Blade::render('<x-aura::kanban>c</x-aura::kanban>');

    expect($html)->toContain('aura:kanban-moved');
});

it('renders column', function () {
    $html = Blade::render('<x-aura::kanban><x-aura::kanban.column title="To Do" columnId="todo">cards</x-aura::kanban.column></x-aura::kanban>');

    expect($html)
        ->toContain('aura-kanban-column')
        ->toContain('To Do')
        ->toContain('aura-kanban-column-header');
});

it('renders column with color dot', function () {
    $html = Blade::render('<x-aura::kanban><x-aura::kanban.column title="Test" columnId="t" color="#ef4444">c</x-aura::kanban.column></x-aura::kanban>');

    expect($html)
        ->toContain('aura-kanban-column-dot')
        ->toContain('#ef4444');
});

it('renders column count', function () {
    $html = Blade::render('<x-aura::kanban><x-aura::kanban.column title="Test" columnId="t" :count="5">c</x-aura::kanban.column></x-aura::kanban>');

    expect($html)
        ->toContain('aura-kanban-column-count')
        ->toContain('5');
});

it('does not render count when null', function () {
    $html = Blade::render('<x-aura::kanban><x-aura::kanban.column title="Test" columnId="t">c</x-aura::kanban.column></x-aura::kanban>');

    expect($html)->not->toContain('aura-kanban-column-count');
});

it('renders column body', function () {
    $html = Blade::render('<x-aura::kanban><x-aura::kanban.column title="T" columnId="t">body content</x-aura::kanban.column></x-aura::kanban>');

    expect($html)
        ->toContain('aura-kanban-column-body')
        ->toContain('body content');
});

it('column has drag event listeners', function () {
    $html = Blade::render('<x-aura::kanban><x-aura::kanban.column title="T" columnId="t">c</x-aura::kanban.column></x-aura::kanban>');

    expect($html)
        ->toContain('@dragover')
        ->toContain('@drop');
});

it('renders card', function () {
    $html = Blade::render('<x-aura::kanban><x-aura::kanban.card cardId="1" columnId="todo">Card content</x-aura::kanban.card></x-aura::kanban>');

    expect($html)
        ->toContain('aura-kanban-card')
        ->toContain('Card content');
});

it('renders draggable card by default', function () {
    $html = Blade::render('<x-aura::kanban><x-aura::kanban.card cardId="1" columnId="todo">C</x-aura::kanban.card></x-aura::kanban>');

    expect($html)
        ->toContain('draggable="true"')
        ->toContain('@dragstart');
});

it('renders non-draggable card', function () {
    $html = Blade::render('<x-aura::kanban><x-aura::kanban.card cardId="1" columnId="todo" :draggable="false">C</x-aura::kanban.card></x-aura::kanban>');

    expect($html)->not->toContain('draggable="true"');
});

it('merges custom attributes on kanban', function () {
    $html = Blade::render('<x-aura::kanban id="board">c</x-aura::kanban>');

    expect($html)->toContain('id="board"');
});

it('merges custom attributes on card', function () {
    $html = Blade::render('<x-aura::kanban><x-aura::kanban.card cardId="1" columnId="t" class="custom">C</x-aura::kanban.card></x-aura::kanban>');

    expect($html)->toContain('custom');
});
