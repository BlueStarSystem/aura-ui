<?php

use Illuminate\Support\Facades\Blade;

/**
 * WCAG 2.2 — 2.5.8 Target Size (Minimum). axe files this criterion under
 * `incomplete` almost every time, so for months we had no verdict on it at
 * all. Measuring the playground in a browser produced one; these keep the
 * answers from drifting back.
 */
it('gives the slider a track you can see and a box you can hit', function () {
    // Painting the gradient on the input itself made the pointer target
    // exactly as tall as the line: six pixels.
    $css = file_get_contents(__DIR__.'/../../../resources/css/aura.css');

    expect($css)
        ->toContain('height: 24px')
        ->toContain('::-webkit-slider-runnable-track')
        ->toContain('::-moz-range-track');
});

it('leaves room for a finger in the fields that hold chips', function (string $blade) {
    expect(Blade::render($blade))->toContain('min-h-6');
})->with([
    '<x-aura::tags label="Skills" />',
    '<x-aura::multiselect label="Pick" :options="[\'a\' => \'A\']" searchable />',
]);

it('lets a click anywhere in the tag box land in the field', function () {
    // A 42px box holding a 24px input is only that box if clicking its padding
    // puts the caret in the field.
    $html = Blade::render('<x-aura::tags label="Skills" />');

    expect($html)
        ->toContain('$refs.field?.focus()')
        ->toContain('x-ref="field"');
});
