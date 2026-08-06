<?php

/**
 * The August contrast pass corrected ~63 colour pairs and still left nine
 * components failing, because it checked the theme variables rather than what
 * a browser computes on the page. axe-core found them on 2026-08-06.
 *
 * This does not replace the browser sweep — it cannot see a value dimmed by
 * opacity or sitting on an unexpected background. It fixes the one thing that
 * is decidable from the palette alone: which shades may carry normal text.
 */
function auraRelativeLuminance(string $hex): float
{
    $hex = ltrim($hex, '#');
    $channels = [];

    foreach ([0, 2, 4] as $offset) {
        $v = hexdec(substr($hex, $offset, 2)) / 255;
        $channels[] = $v <= 0.03928 ? $v / 12.92 : (($v + 0.055) / 1.055) ** 2.4;
    }

    return 0.2126 * $channels[0] + 0.7152 * $channels[1] + 0.0722 * $channels[2];
}

function auraContrast(string $foreground, string $background): float
{
    $a = auraRelativeLuminance($foreground);
    $b = auraRelativeLuminance($background);

    return (max($a, $b) + 0.05) / (min($a, $b) + 0.05);
}

/**
 * @return array<string, string>
 */
function auraTokens(): array
{
    $css = file_get_contents(__DIR__.'/../../resources/css/aura.css');
    preg_match_all('/--color-aura-([a-z]+-\d+):\s*(#[0-9a-fA-F]{6});/', $css, $m, PREG_SET_ORDER);

    return collect($m)->mapWithKeys(fn ($x) => [$x[1] => $x[2]])->all();
}

it('keeps the shades used for muted text above 4.5:1 on every light background', function () {
    $tokens = auraTokens();

    // The backgrounds muted text actually sits on in these components.
    $backgrounds = ['surface-0', 'surface-50', 'surface-100'];

    foreach ($backgrounds as $bg) {
        $ratio = auraContrast($tokens['surface-600'], $tokens[$bg]);

        expect($ratio)->toBeGreaterThanOrEqual(
            4.5,
            "surface-600 on {$bg} is ".round($ratio, 2).':1 — muted text uses this shade throughout'
        );
    }
});

it('records which shades are too light for normal text', function () {
    $tokens = auraTokens();

    // Not a wish: a fact about the palette, kept here so the next person
    // reaching for surface-400 as a text colour sees why it is not one.
    foreach (['surface-300', 'surface-400'] as $tooLight) {
        expect(auraContrast($tokens[$tooLight], $tokens['surface-0']))->toBeLessThan(4.5);
    }

    // surface-500 clears white and surface-50, but not surface-100 (4.34:1),
    // which is why the fixes went to -600 rather than -500.
    expect(auraContrast($tokens['surface-500'], $tokens['surface-100']))->toBeLessThan(4.5);
});

it('keeps the accent shades used for text above 4.5:1 on white', function () {
    $tokens = auraTokens();

    foreach (['success-700', 'danger-600', 'warning-700', 'info-700'] as $token) {
        $ratio = auraContrast($tokens[$token], $tokens['surface-0']);

        expect($ratio)->toBeGreaterThanOrEqual(4.5, "{$token} is ".round($ratio, 2).':1 on white');
    }

    // success-600 is 3.30:1. It reads as the obvious "green text" and is not.
    expect(auraContrast($tokens['success-600'], $tokens['surface-0']))->toBeLessThan(4.5);
});
