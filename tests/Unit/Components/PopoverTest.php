<?php

use Illuminate\Support\Facades\Blade;

it('renders popover wrapper', function () {
    $html = Blade::render('<x-aura::popover><button>Click</button></x-aura::popover>');

    expect($html)
        ->toContain('aura-popover-wrapper')
        ->toContain('x-data');
});

it('renders trigger element', function () {
    $html = Blade::render('<x-aura::popover><button>Trigger</button></x-aura::popover>');

    expect($html)
        ->toContain('aura-popover-trigger')
        ->toContain('Trigger');
});

it('renders popover content area', function () {
    $html = Blade::render('<x-aura::popover><button>T</button></x-aura::popover>');

    expect($html)->toContain('aura-popover');
});

it('renders bottom position by default', function () {
    $html = Blade::render('<x-aura::popover><button>T</button></x-aura::popover>');

    expect($html)->toContain('top-full');
});

it('renders top position', function () {
    $html = Blade::render('<x-aura::popover position="top"><button>T</button></x-aura::popover>');

    expect($html)->toContain('bottom-full');
});

it('renders left position', function () {
    $html = Blade::render('<x-aura::popover position="left"><button>T</button></x-aura::popover>');

    expect($html)->toContain('right-full');
});

it('renders right position', function () {
    $html = Blade::render('<x-aura::popover position="right"><button>T</button></x-aura::popover>');

    expect($html)->toContain('left-full');
});

it('renders with custom width', function () {
    $html = Blade::render('<x-aura::popover width="400px"><button>T</button></x-aura::popover>');

    expect($html)->toContain('width: 400px');
});

it('closes on click outside by default', function () {
    $html = Blade::render('<x-aura::popover><button>T</button></x-aura::popover>');

    expect($html)->toContain('@click.outside');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::popover id="pop"><button>T</button></x-aura::popover>');

    expect($html)->toContain('id="pop"');
});
