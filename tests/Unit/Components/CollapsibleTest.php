<?php

use Illuminate\Support\Facades\Blade;

it('renders a collapsible', function () {
    $html = Blade::render('<x-aura::collapsible>Content</x-aura::collapsible>');

    expect($html)
        ->toContain('aura-collapsible')
        ->toContain('aura-collapsible-content')
        ->toContain('Content');
});

it('renders closed by default', function () {
    $html = Blade::render('<x-aura::collapsible>Content</x-aura::collapsible>');

    expect($html)->toContain("open: false");
});

it('renders open when prop set', function () {
    $html = Blade::render('<x-aura::collapsible open>Content</x-aura::collapsible>');

    expect($html)->toContain("open: true");
});

it('renders trigger slot', function () {
    $html = Blade::render('
        <x-aura::collapsible>
            <x-slot:trigger>Click Me</x-slot:trigger>
            Body
        </x-aura::collapsible>
    ');

    expect($html)
        ->toContain('aura-collapsible-trigger')
        ->toContain('Click Me')
        ->toContain('cursor-pointer');
});

it('uses x-show for content', function () {
    $html = Blade::render('<x-aura::collapsible>Content</x-aura::collapsible>');

    expect($html)->toContain('x-show="open"');
});

it('uses x-cloak on content', function () {
    $html = Blade::render('<x-aura::collapsible>Content</x-aura::collapsible>');

    expect($html)->toContain('x-cloak');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::collapsible id="faq-1">Q&A</x-aura::collapsible>');

    expect($html)->toContain('id="faq-1"');
});
