<?php

use Illuminate\Support\Facades\Blade;

it('renders sidebar container', function () {
    $html = Blade::render('<x-aura::sidebar>content</x-aura::sidebar>');

    expect($html)
        ->toContain('aura-sidebar')
        ->toContain('x-data')
        ->toContain('<aside');
});

it('renders collapse toggle by default', function () {
    $html = Blade::render('<x-aura::sidebar>c</x-aura::sidebar>');

    expect($html)->toContain('aura-sidebar-toggle');
});

it('hides toggle when not collapsible', function () {
    $html = Blade::render('<x-aura::sidebar :collapsible="false">c</x-aura::sidebar>');

    expect($html)->not->toContain('aura-sidebar-toggle');
});

it('starts collapsed when prop is true', function () {
    $html = Blade::render('<x-aura::sidebar :collapsed="true">c</x-aura::sidebar>');

    expect($html)->toContain('collapsed: true');
});

it('starts expanded by default', function () {
    $html = Blade::render('<x-aura::sidebar>c</x-aura::sidebar>');

    expect($html)->toContain('collapsed: false');
});

it('sets custom width', function () {
    $html = Blade::render('<x-aura::sidebar width="300px">c</x-aura::sidebar>');

    expect($html)->toContain('300px');
});

it('renders brand component', function () {
    $html = Blade::render('<x-aura::sidebar><x-aura::sidebar.brand>Logo</x-aura::sidebar.brand></x-aura::sidebar>');

    expect($html)
        ->toContain('aura-sidebar-brand')
        ->toContain('Logo');
});

it('renders brand with href', function () {
    $html = Blade::render('<x-aura::sidebar><x-aura::sidebar.brand href="/home">Logo</x-aura::sidebar.brand></x-aura::sidebar>');

    expect($html)->toContain('href="/home"');
});

it('renders section with label', function () {
    $html = Blade::render('<x-aura::sidebar><x-aura::sidebar.section label="Main">items</x-aura::sidebar.section></x-aura::sidebar>');

    expect($html)
        ->toContain('aura-sidebar-section')
        ->toContain('Main');
});

it('renders item with icon and label', function () {
    $html = Blade::render('<x-aura::sidebar><x-aura::sidebar.item icon="home" label="Dashboard" href="/dash" /></x-aura::sidebar>');

    expect($html)
        ->toContain('aura-sidebar-item')
        ->toContain('Dashboard')
        ->toContain('href="/dash"')
        ->toContain('<svg');
});

it('renders active item', function () {
    $html = Blade::render('<x-aura::sidebar><x-aura::sidebar.item label="Active" :active="true" /></x-aura::sidebar>');

    expect($html)->toContain('aura-sidebar-item-active');
});

it('renders item badge', function () {
    $html = Blade::render('<x-aura::sidebar><x-aura::sidebar.item label="Mail" badge="3" /></x-aura::sidebar>');

    expect($html)->toContain('3');
});

it('renders expandable item with chevron', function () {
    $html = Blade::render('<x-aura::sidebar><x-aura::sidebar.item label="Settings" :expandable="true">sub</x-aura::sidebar.item></x-aura::sidebar>');

    expect($html)
        ->toContain('aura-sidebar-item-arrow')
        ->toContain('aura-sidebar-subitems');
});

it('renders sub-item', function () {
    $html = Blade::render('<x-aura::sidebar><x-aura::sidebar.sub-item label="Profile" href="/profile" /></x-aura::sidebar>');

    expect($html)
        ->toContain('aura-sidebar-subitem')
        ->toContain('Profile')
        ->toContain('href="/profile"');
});

it('renders active sub-item', function () {
    $html = Blade::render('<x-aura::sidebar><x-aura::sidebar.sub-item label="Profile" href="/profile" :active="true" /></x-aura::sidebar>');

    expect($html)->toContain('aura-sidebar-subitem-active');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::sidebar id="main-sidebar">c</x-aura::sidebar>');

    expect($html)->toContain('id="main-sidebar"');
});
