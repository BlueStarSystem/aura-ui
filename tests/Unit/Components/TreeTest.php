<?php

use Illuminate\Support\Facades\Blade;

it('renders tree container', function () {
    $html = Blade::render('<x-aura::tree :items="$items" />', [
        'items' => [['label' => 'Root']],
    ]);

    expect($html)
        ->toContain('aura-tree')
        ->toContain('x-data')
        ->toContain('role="tree"');
});

it('renders tree nodes', function () {
    $html = Blade::render('<x-aura::tree :items="$items" />', [
        'items' => [['label' => 'Item 1'], ['label' => 'Item 2']],
    ]);

    expect($html)
        ->toContain('Item 1')
        ->toContain('Item 2')
        ->toContain('aura-tree-node');
});

it('renders node labels', function () {
    $html = Blade::render('<x-aura::tree :items="$items" />', [
        'items' => [['label' => 'My Node']],
    ]);

    expect($html)
        ->toContain('aura-tree-node-label')
        ->toContain('My Node');
});

it('renders nested children', function () {
    $html = Blade::render('<x-aura::tree :items="$items" />', [
        'items' => [['label' => 'Parent', 'children' => [['label' => 'Child']]]],
    ]);

    expect($html)
        ->toContain('Parent')
        ->toContain('Child')
        ->toContain('aura-tree-children');
});

it('renders toggle button for nodes with children', function () {
    $html = Blade::render('<x-aura::tree :items="$items" />', [
        'items' => [['label' => 'Parent', 'children' => [['label' => 'Child']]]],
    ]);

    expect($html)->toContain('aura-tree-node-toggle');
});

it('renders spacer for leaf nodes', function () {
    $html = Blade::render('<x-aura::tree :items="$items" />', [
        'items' => [['label' => 'Leaf']],
    ]);

    expect($html)->toContain('aura-tree-node-spacer');
});

it('renders node icons', function () {
    $html = Blade::render('<x-aura::tree :items="$items" />', [
        'items' => [['label' => 'Folder', 'icon' => 'folder']],
    ]);

    expect($html)
        ->toContain('aura-tree-node-icon')
        ->toContain('<svg');
});

it('renders connector lines', function () {
    $html = Blade::render('<x-aura::tree :items="$items" />', [
        'items' => [['label' => 'Root']],
    ]);

    expect($html)->toContain('aura-tree-connectors');
});

it('hides connectors when disabled', function () {
    $html = Blade::render('<x-aura::tree :items="$items" :connectors="false" />', [
        'items' => [['label' => 'Root']],
    ]);

    expect($html)->not->toContain('aura-tree-connectors');
});

it('supports selectable mode', function () {
    $html = Blade::render('<x-aura::tree :items="$items" :selectable="true" />', [
        'items' => [['label' => 'Root']],
    ]);

    expect($html)->toContain('selectable: true');
});

it('supports expand all mode', function () {
    $html = Blade::render('<x-aura::tree :items="$items" :expandAll="true" />', [
        'items' => [['label' => 'Root']],
    ]);

    expect($html)->toContain('expandAll: true');
});

it('uses custom label key', function () {
    $html = Blade::render('<x-aura::tree :items="$items" labelKey="name" />', [
        'items' => [['name' => 'Custom']],
    ]);

    expect($html)->toContain('Custom');
});

it('renders treeitem role', function () {
    $html = Blade::render('<x-aura::tree :items="$items" />', [
        'items' => [['label' => 'Root']],
    ]);

    expect($html)->toContain('role="treeitem"');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::tree :items="$items" id="file-tree" />', [
        'items' => [['label' => 'Root']],
    ]);

    expect($html)->toContain('id="file-tree"');
});
