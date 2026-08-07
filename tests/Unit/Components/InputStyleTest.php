<?php

use BlueStarSystem\AuraUI\Support\InputStyle;
use Illuminate\Support\Facades\Blade;

/**
 * `.aura-input` is a hook with no CSS behind it. Every component that borrowed
 * the class name and nothing else rendered a borderless, transparent box 20
 * pixels tall — a date picker that read as a line of text.
 */
it('gives a field a border, a background and padding', function () {
    $classes = InputStyle::classes();

    expect($classes)
        ->toContain('border')
        ->toContain('bg-aura-surface-100')
        ->toContain('py-2.5')
        ->toContain('aura-input');
});

it('writes each size out rather than interpolating it', function () {
    // Tailwind reads source files as text: a class built from a variable
    // produces no rule at all, which is how this family of bugs starts.
    expect(InputStyle::classes('sm'))->toContain('py-1.5')->toContain('aura-input-sm');
    expect(InputStyle::classes('lg'))->toContain('py-3.5')->toContain('aura-input-lg');
    expect(InputStyle::classes('nonsense'))->toContain('py-2.5');
});

it('adds the state hooks the stylesheet targets', function () {
    expect(InputStyle::classes('md', true))->toContain('aura-input-error');
    expect(InputStyle::classes('md', false, true))->toContain('aura-input-disabled');
    expect(InputStyle::classes())->not->toContain('aura-input-error');
});

it('draws every component that takes typed input as a real field', function (string $blade) {
    $html = Blade::render($blade);

    expect($html)
        ->toContain('border-aura-surface-500')
        ->toContain('px-3.5');
})->with([
    '<x-aura::input label="Name" />',
    '<x-aura::date-picker label="When" />',
    '<x-aura::time-picker label="At" />',
    '<x-aura::autocomplete label="Search" :options="[\'One\']" />',
]);
