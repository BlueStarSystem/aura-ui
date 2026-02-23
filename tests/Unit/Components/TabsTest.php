<?php

use Illuminate\Support\Facades\Blade;

it('renders tabs container with default variant', function () {
    $html = Blade::render('<x-aura::tabs :tabs="$tabs">content</x-aura::tabs>', [
        'tabs' => [['name' => 'one', 'label' => 'Tab One']],
    ]);

    expect($html)
        ->toContain('aura-tabs')
        ->toContain('aura-tabs-default')
        ->toContain('x-data');
});

it('renders pills variant', function () {
    $html = Blade::render('<x-aura::tabs variant="pills" :tabs="$tabs">c</x-aura::tabs>', [
        'tabs' => [['name' => 'a', 'label' => 'A']],
    ]);

    expect($html)->toContain('aura-tabs-pills');
});

it('renders vertical variant', function () {
    $html = Blade::render('<x-aura::tabs variant="vertical" :tabs="$tabs">c</x-aura::tabs>', [
        'tabs' => [['name' => 'a', 'label' => 'A']],
    ]);

    expect($html)->toContain('aura-tabs-vertical');
});

it('renders bordered variant', function () {
    $html = Blade::render('<x-aura::tabs variant="bordered" :tabs="$tabs">c</x-aura::tabs>', [
        'tabs' => [['name' => 'a', 'label' => 'A']],
    ]);

    expect($html)->toContain('aura-tabs-bordered');
});

it('renders tab buttons with labels', function () {
    $html = Blade::render('<x-aura::tabs :tabs="$tabs">c</x-aura::tabs>', [
        'tabs' => [['name' => 'one', 'label' => 'First Tab'], ['name' => 'two', 'label' => 'Second Tab']],
    ]);

    expect($html)
        ->toContain('First Tab')
        ->toContain('Second Tab')
        ->toContain('role="tab"');
});

it('renders tablist role', function () {
    $html = Blade::render('<x-aura::tabs :tabs="$tabs">c</x-aura::tabs>', [
        'tabs' => [['name' => 'a', 'label' => 'A']],
    ]);

    expect($html)->toContain('role="tablist"');
});

it('sets default tab from prop', function () {
    $html = Blade::render('<x-aura::tabs :tabs="$tabs" defaultTab="two">c</x-aura::tabs>', [
        'tabs' => [['name' => 'one', 'label' => 'One'], ['name' => 'two', 'label' => 'Two']],
    ]);

    expect($html)->toContain("activeTab: 'two'");
});

it('defaults to first tab when no defaultTab', function () {
    $html = Blade::render('<x-aura::tabs :tabs="$tabs">c</x-aura::tabs>', [
        'tabs' => [['name' => 'first', 'label' => 'First'], ['name' => 'second', 'label' => 'Second']],
    ]);

    expect($html)->toContain("activeTab: 'first'");
});

it('renders tab icon when provided', function () {
    $html = Blade::render('<x-aura::tabs :tabs="$tabs">c</x-aura::tabs>', [
        'tabs' => [['name' => 'a', 'label' => 'A', 'icon' => 'home']],
    ]);

    expect($html)->toContain('<svg');
});

it('renders badge when provided', function () {
    $html = Blade::render('<x-aura::tabs :tabs="$tabs">c</x-aura::tabs>', [
        'tabs' => [['name' => 'a', 'label' => 'A', 'badge' => '5']],
    ]);

    expect($html)
        ->toContain('aura-tabs-badge')
        ->toContain('5');
});

it('renders disabled tab', function () {
    $html = Blade::render('<x-aura::tabs :tabs="$tabs">c</x-aura::tabs>', [
        'tabs' => [['name' => 'a', 'label' => 'A', 'disabled' => true]],
    ]);

    expect($html)->toContain('disabled');
});

it('renders tab panel with role', function () {
    $html = Blade::render('<x-aura::tabs :tabs="$tabs"><x-aura::tabs.tab name="one">Panel content</x-aura::tabs.tab></x-aura::tabs>', [
        'tabs' => [['name' => 'one', 'label' => 'One']],
    ]);

    expect($html)
        ->toContain('role="tabpanel"')
        ->toContain('Panel content')
        ->toContain('aura-tabs-panel');
});

it('panel uses x-show for visibility', function () {
    $html = Blade::render('<x-aura::tabs :tabs="$tabs"><x-aura::tabs.tab name="one">C</x-aura::tabs.tab></x-aura::tabs>', [
        'tabs' => [['name' => 'one', 'label' => 'One']],
    ]);

    expect($html)->toContain('x-show');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::tabs :tabs="$tabs" id="my-tabs">c</x-aura::tabs>', [
        'tabs' => [['name' => 'a', 'label' => 'A']],
    ]);

    expect($html)->toContain('id="my-tabs"');
});
