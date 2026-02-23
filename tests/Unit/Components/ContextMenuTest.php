<?php

use Illuminate\Support\Facades\Blade;

it('renders context menu trigger', function () {
    $html = Blade::render('<x-aura::context-menu><div>Right click me</div></x-aura::context-menu>');

    expect($html)
        ->toContain('aura-context-menu-trigger')
        ->toContain('x-data')
        ->toContain('Right click me');
});

it('listens for contextmenu event', function () {
    $html = Blade::render('<x-aura::context-menu><div>c</div></x-aura::context-menu>');

    expect($html)->toContain('@contextmenu.prevent');
});

it('renders menu dropdown', function () {
    $html = Blade::render('<x-aura::context-menu><div>c</div></x-aura::context-menu>');

    expect($html)
        ->toContain('aura-context-menu')
        ->toContain('role="menu"');
});

it('renders with default width', function () {
    $html = Blade::render('<x-aura::context-menu><div>c</div></x-aura::context-menu>');

    expect($html)->toContain('width: 200px');
});

it('renders with custom width', function () {
    $html = Blade::render('<x-aura::context-menu width="300px"><div>c</div></x-aura::context-menu>');

    expect($html)->toContain('width: 300px');
});

it('closes on click outside', function () {
    $html = Blade::render('<x-aura::context-menu><div>c</div></x-aura::context-menu>');

    expect($html)->toContain('@click.outside');
});

it('closes on escape', function () {
    $html = Blade::render('<x-aura::context-menu><div>c</div></x-aura::context-menu>');

    expect($html)->toContain('keydown.escape');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::context-menu id="ctx"><div>c</div></x-aura::context-menu>');

    expect($html)->toContain('id="ctx"');
});
