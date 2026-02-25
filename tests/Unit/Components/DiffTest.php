<?php

use Illuminate\Support\Facades\Blade;

it('renders a diff component', function () {
    $html = Blade::render('
        <x-aura::diff>
            <x-slot:before>Old text</x-slot:before>
            <x-slot:after>New text</x-slot:after>
        </x-aura::diff>
    ');

    expect($html)
        ->toContain('aura-diff')
        ->toContain('aura-diff-before')
        ->toContain('aura-diff-after')
        ->toContain('Old text')
        ->toContain('New text');
});

it('renders before label', function () {
    $html = Blade::render('
        <x-aura::diff>
            <x-slot:before>A</x-slot:before>
            <x-slot:after>B</x-slot:after>
        </x-aura::diff>
    ');

    expect($html)->toContain('Before');
});

it('renders after label', function () {
    $html = Blade::render('
        <x-aura::diff>
            <x-slot:before>A</x-slot:before>
            <x-slot:after>B</x-slot:after>
        </x-aura::diff>
    ');

    expect($html)->toContain('After');
});

it('renders side-by-side by default', function () {
    $html = Blade::render('
        <x-aura::diff>
            <x-slot:before>A</x-slot:before>
            <x-slot:after>B</x-slot:after>
        </x-aura::diff>
    ');

    expect($html)->toContain('md:flex-row');
});

it('renders stacked layout', function () {
    $html = Blade::render('
        <x-aura::diff layout="stacked">
            <x-slot:before>A</x-slot:before>
            <x-slot:after>B</x-slot:after>
        </x-aura::diff>
    ');

    expect($html)
        ->toContain('flex-col')
        ->not->toContain('md:flex-row');
});

it('renders color coding', function () {
    $html = Blade::render('
        <x-aura::diff>
            <x-slot:before>A</x-slot:before>
            <x-slot:after>B</x-slot:after>
        </x-aura::diff>
    ');

    expect($html)
        ->toContain('text-aura-danger-500')
        ->toContain('text-aura-success-500');
});

it('merges custom attributes', function () {
    $html = Blade::render('
        <x-aura::diff id="my-diff">
            <x-slot:before>A</x-slot:before>
            <x-slot:after>B</x-slot:after>
        </x-aura::diff>
    ');

    expect($html)->toContain('id="my-diff"');
});
