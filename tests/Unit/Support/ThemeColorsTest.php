<?php

use BlueStarSystem\AuraUI\Support\ThemeColors;

it('extracts aura colour variables from a @theme block', function () {
    $css = <<<'CSS'
    @import "tailwindcss";
    @theme {
        --color-aura-primary-500: #ff0000;
        --color-aura-primary-600: oklch(0.51 0.2 264);
        --font-sans: Inter, sans-serif;
    }
    CSS;

    expect(ThemeColors::parse($css))->toBe([
        'primary-500' => '#ff0000',
        'primary-600' => 'oklch(0.51 0.2 264)',
    ]);
});

it('returns nothing when there is no @theme block', function () {
    expect(ThemeColors::parse('@import "tailwindcss";'))->toBe([]);
});

it('returns nothing for an empty @theme block', function () {
    expect(ThemeColors::parse('@theme { }'))->toBe([]);
});

it('does not throw on malformed css', function () {
    expect(ThemeColors::parse('@theme { --color-aura-primary-500: '))->toBe([]);
});

it('reads more than one @theme block', function () {
    $css = '@theme { --color-aura-primary-500: #111111; } @theme { --color-aura-danger-500: #222222; }';

    expect(ThemeColors::parse($css))->toBe([
        'primary-500' => '#111111',
        'danger-500' => '#222222',
    ]);
});

it('extracts rgb() values verbatim, since Contrast will reject them explicitly rather than misreading them', function () {
    $css = '@theme { --color-aura-primary-500: rgb(99 102 241); }';

    expect(ThemeColors::parse($css))->toBe([
        'primary-500' => 'rgb(99 102 241)',
    ]);
});

it('never throws on arbitrary garbage input', function () {
    expect(ThemeColors::parse("\0\0not css at all {{{ @theme"))->toBe([]);
});
