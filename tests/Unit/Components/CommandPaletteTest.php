<?php

use Illuminate\Support\Facades\Blade;

it('renders command palette container', function () {
    $html = Blade::render('<x-aura::command-palette>content</x-aura::command-palette>');

    expect($html)
        ->toContain('aura-command-palette')
        ->toContain('x-data');
});

it('sets z-index from CSS variable', function () {
    $html = Blade::render('<x-aura::command-palette>c</x-aura::command-palette>');

    expect($html)->toContain('z-index');
});

it('listens for Cmd+K shortcut', function () {
    $html = Blade::render('<x-aura::command-palette>c</x-aura::command-palette>');

    expect($html)
        ->toContain('meta.k')
        ->toContain('ctrl.k');
});

it('renders search input with placeholder', function () {
    $html = Blade::render('<x-aura::command-palette>c</x-aura::command-palette>');

    expect($html)
        ->toContain('aura-command-input')
        ->toContain('Search commands...');
});

it('renders custom placeholder', function () {
    $html = Blade::render('<x-aura::command-palette placeholder="Find...">c</x-aura::command-palette>');

    expect($html)->toContain('Find...');
});

it('renders ESC kbd hint', function () {
    $html = Blade::render('<x-aura::command-palette>c</x-aura::command-palette>');

    expect($html)->toContain('ESC');
});

it('renders footer with keyboard hints', function () {
    $html = Blade::render('<x-aura::command-palette>c</x-aura::command-palette>');

    expect($html)
        ->toContain('aura-command-footer')
        ->toContain('navigate')
        ->toContain('select')
        ->toContain('close');
});

it('renders empty state text', function () {
    $html = Blade::render('<x-aura::command-palette>c</x-aura::command-palette>');

    expect($html)
        ->toContain('aura-command-empty')
        ->toContain('No results found.');
});

it('renders custom empty text', function () {
    $html = Blade::render('<x-aura::command-palette emptyText="Nothing here">c</x-aura::command-palette>');

    expect($html)->toContain('Nothing here');
});

it('uses teleport to body', function () {
    $html = Blade::render('<x-aura::command-palette>c</x-aura::command-palette>');

    expect($html)->toContain('x-teleport="body"');
});

it('renders command group', function () {
    $html = Blade::render('<x-aura::command-palette><x-aura::command-palette.group heading="Actions">items</x-aura::command-palette.group></x-aura::command-palette>');

    expect($html)
        ->toContain('aura-command-group')
        ->toContain('aura-command-group-heading')
        ->toContain('Actions');
});

it('renders command item', function () {
    $html = Blade::render('<x-aura::command-palette><x-aura::command-palette.item value="Save" icon="check" /></x-aura::command-palette>');

    expect($html)
        ->toContain('aura-command-item')
        ->toContain('data-command-item')
        ->toContain('Save');
});

it('renders item icon', function () {
    $html = Blade::render('<x-aura::command-palette><x-aura::command-palette.item value="Test" icon="home" /></x-aura::command-palette>');

    expect($html)
        ->toContain('aura-command-item-icon')
        ->toContain('<svg');
});

it('renders item description', function () {
    $html = Blade::render('<x-aura::command-palette><x-aura::command-palette.item value="Test" description="Do something" /></x-aura::command-palette>');

    expect($html)
        ->toContain('aura-command-item-description')
        ->toContain('Do something');
});

it('renders item shortcut', function () {
    $html = Blade::render('<x-aura::command-palette><x-aura::command-palette.item value="Save" shortcut="Cmd+S" /></x-aura::command-palette>');

    expect($html)
        ->toContain('aura-command-item-shortcut')
        ->toContain('Cmd+S');
});

it('dispatches aura:command event on click', function () {
    $html = Blade::render('<x-aura::command-palette><x-aura::command-palette.item value="Test" /></x-aura::command-palette>');

    expect($html)->toContain('aura:command');
});

it('has keyboard navigation', function () {
    $html = Blade::render('<x-aura::command-palette>c</x-aura::command-palette>');

    expect($html)
        ->toContain('arrow-up')
        ->toContain('arrow-down')
        ->toContain('navigate(');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::command-palette id="cmd">c</x-aura::command-palette>');

    expect($html)->toContain('id="cmd"');
});
