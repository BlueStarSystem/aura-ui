<?php

use BlueStarSystem\AuraUI\Support\Contrast;

/**
 * Every colour pair a component actually renders, with the shade the Blade
 * template really uses. When a template changes shade, this list changes with
 * it -- that is the point: the list is the contract.
 */
dataset('solid surfaces', [
    // [etichetta, sfondo, testo]
    'button primary' => ['#4f46e5', '#ffffff'],  // primary-600
    'button success' => ['#047857', '#ffffff'],  // success-700
    'button danger' => ['#dc2626', '#ffffff'],  // danger-600
    'button warning' => ['#f59e0b', '#0f172a'],  // warning-500 su surface-900
    'button secondary' => ['#f1f5f9', '#0f172a'],  // surface-100 su surface-900
    'badge primary' => ['#dbeafe', '#4338ca'],
    'badge success' => ['#d1fae5', '#047857'],
    'badge warning' => ['#fef3c7', '#b45309'],
    'badge danger' => ['#fee2e2', '#b91c1c'],
    'badge info' => ['#e0f2fe', '#0369a1'],
]);

it('renders every solid surface at WCAG AA or better', function (string $background, string $text) {
    expect(Contrast::ratio($background, $text))
        ->toBeGreaterThanOrEqual(Contrast::AA_NORMAL);
})->with('solid surfaces');
