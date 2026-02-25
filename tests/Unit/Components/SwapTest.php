<?php

use Illuminate\Support\Facades\Blade;

it('renders a swap component', function () {
    $html = Blade::render('
        <x-aura::swap>
            <x-slot:on>ON</x-slot:on>
            <x-slot:off>OFF</x-slot:off>
        </x-aura::swap>
    ');

    expect($html)
        ->toContain('aura-swap')
        ->toContain('aura-swap-on')
        ->toContain('aura-swap-off')
        ->toContain('ON')
        ->toContain('OFF');
});

it('renders inactive by default', function () {
    $html = Blade::render('
        <x-aura::swap>
            <x-slot:on>ON</x-slot:on>
            <x-slot:off>OFF</x-slot:off>
        </x-aura::swap>
    ');

    expect($html)->toContain('swapped: false');
});

it('renders active when prop set', function () {
    $html = Blade::render('
        <x-aura::swap active>
            <x-slot:on>ON</x-slot:on>
            <x-slot:off>OFF</x-slot:off>
        </x-aura::swap>
    ');

    expect($html)->toContain('swapped: true');
});

it('renders as switch role', function () {
    $html = Blade::render('
        <x-aura::swap>
            <x-slot:on>A</x-slot:on>
            <x-slot:off>B</x-slot:off>
        </x-aura::swap>
    ');

    expect($html)->toContain('role="switch"');
});

it('renders with click handler', function () {
    $html = Blade::render('
        <x-aura::swap>
            <x-slot:on>A</x-slot:on>
            <x-slot:off>B</x-slot:off>
        </x-aura::swap>
    ');

    expect($html)->toContain('swapped = !swapped');
});

it('merges custom attributes', function () {
    $html = Blade::render('
        <x-aura::swap class="my-swap">
            <x-slot:on>A</x-slot:on>
            <x-slot:off>B</x-slot:off>
        </x-aura::swap>
    ');

    expect($html)->toContain('my-swap');
});
