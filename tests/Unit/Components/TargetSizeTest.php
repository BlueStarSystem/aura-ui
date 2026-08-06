<?php

use Illuminate\Support\Facades\Blade;

/**
 * WCAG 2.2 SC 2.5.8 Target Size (Minimum): a pointer target must be at least
 * 24x24 CSS px.
 *
 * The clear and remove buttons were 16 or 20 px — a 12 px icon with 2 or 4 px
 * of padding. min-w-6/min-h-6 grows the hit area without changing the icon, so
 * nothing looks different and everything is easier to hit.
 */
it('gives every clear and remove control a 24px minimum box', function (string $markup) {
    expect(Blade::render($markup))->toContain('min-w-6 min-h-6');
})->with([
    'multiselect' => '<x-aura::multiselect name="x" :options="[\'a\' => \'A\']" />',
    'tags' => '<x-aura::tags name="x" />',
    'date-picker' => '<x-aura::date-picker name="d" clearable value="2026-08-06" />',
    'autocomplete' => '<x-aura::autocomplete name="a" :options="[\'x\']" clearable value="x" />',
    'time-picker' => '<x-aura::time-picker name="t" clearable value="09:00" />',
]);

it('leaves the icon the size it was', function () {
    // The target grew, not the drawing: a 24px chevron would look wrong.
    expect(Blade::render('<x-aura::tags name="x" />'))
        ->toContain('width="12"');
});

it('gives a sticky navbar the scroll padding its height needs', function () {
    // SC 2.4.11: without it, tabbing to an element near the top scrolls it
    // under the bar — focused, and invisible.
    expect(Blade::render('<x-aura::navbar sticky>x</x-aura::navbar>'))
        ->toContain('aura-navbar-sticky');

    expect(Blade::render('<x-aura::navbar>x</x-aura::navbar>'))
        ->not->toContain('aura-navbar-sticky');
});
