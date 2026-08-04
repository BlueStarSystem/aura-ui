<?php

use BlueStarSystem\AuraUI\Support\Contrast;

it('computes the published WCAG ratio for known colours', function (string $a, string $b, float $expected) {
    expect(Contrast::ratio($a, $b))->toBeWithin($expected, 0.02);
})->with([
    ['#6366f1', '#ffffff', 4.47],   // indigo-500 su bianco
    ['#10b981', '#ffffff', 2.54],   // emerald-500 su bianco
    ['#ef4444', '#ffffff', 3.76],   // red-500 su bianco
    ['#4f46e5', '#ffffff', 6.29],   // indigo-600 su bianco
    ['#000000', '#ffffff', 21.0],   // estremo
    ['#ffffff', '#ffffff', 1.0],    // identici
]);

it('is symmetric', function () {
    expect(Contrast::ratio('#6366f1', '#ffffff'))
        ->toBe(Contrast::ratio('#ffffff', '#6366f1'));
});

it('expands three-digit hex', function () {
    expect(Contrast::ratio('#fff', '#000'))->toBeWithin(21.0, 0.02);
});

it('accepts oklch input', function () {
    // oklch(0.6 0 0) è un grigio: il ratio col bianco deve stare fra 1 e 21
    expect(Contrast::ratio('oklch(0.600 0.0000 0.000)', '#ffffff'))
        ->toBeGreaterThan(1.0)
        ->toBeLessThan(21.0);
});

it('applies the right AA threshold for normal and large text', function () {
    expect(Contrast::passesAA('#6366f1', '#ffffff'))->toBeFalse()          // 4.47 < 4.5
        ->and(Contrast::passesAA('#6366f1', '#ffffff', largeText: true))->toBeTrue();  // 4.47 >= 3.0
});

it('rejects unparseable colours', function () {
    Contrast::ratio('not-a-colour', '#fff');
})->throws(InvalidArgumentException::class);
