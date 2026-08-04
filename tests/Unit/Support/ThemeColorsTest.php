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

it('ignores a colour override that is commented out', function () {
    $css = '@theme { /* --color-aura-primary-600: #ff0000; */ }';

    expect(ThemeColors::parse($css))->toBe([]);
});

it('reads a live override that sits next to a commented-out one in the same block', function () {
    $css = '@theme { /* --color-aura-danger-500: #000000; */ --color-aura-primary-600: #ff0000; }';

    expect(ThemeColors::parse($css))->toBe([
        'primary-600' => '#ff0000',
    ]);
});

it('does not let a nested at-rule truncate the @theme block early', function () {
    $css = <<<'CSS'
    @theme {
        --color-aura-primary-500: #111111;
        @media (prefers-color-scheme: dark) {
            --color-aura-primary-500: #222222;
        }
        --color-aura-success-700: #333333;
    }
    CSS;

    expect(ThemeColors::parse($css))->toBe([
        'primary-500' => '#222222',
        'success-700' => '#333333',
    ]);
});

it('is not fooled by a brace inside a comment', function () {
    $css = '@theme { /* a stray } brace */ --color-aura-primary-500: #111111; }';

    expect(ThemeColors::parse($css))->toBe([
        'primary-500' => '#111111',
    ]);
});

it('is not fooled by a brace inside a quoted value, and still reads the override that follows it', function () {
    $css = '@theme { --font-label: "weird } quote"; --color-aura-primary-600: #7dd3fc; }';

    expect(ThemeColors::parse($css))->toBe([
        'primary-600' => '#7dd3fc',
    ]);
});

it('is not fooled by a brace inside a single-quoted value either', function () {
    $css = "@theme { --font-label: 'weird } quote'; --color-aura-primary-600: #7dd3fc; }";

    expect(ThemeColors::parse($css))->toBe([
        'primary-600' => '#7dd3fc',
    ]);
});

it('treats an unterminated comment as unreadable rather than parsing its contents as a live override', function () {
    $css = '@theme { /* --color-aura-primary-600: #7dd3fc; }';

    expect(ThemeColors::parse($css))->toBe([])
        ->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeTrue();
});

it('treats an unterminated comment as unreadable even when it swallows a later, otherwise-live declaration', function () {
    $css = <<<'CSS'
    @theme {
        /* --color-aura-danger-600: #ff0000
        --color-aura-primary-600: #7dd3fc; }
    CSS;

    expect(ThemeColors::parse($css))->toBe([])
        ->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeTrue();
});

it('does not let an unquoted url() token with a stray brace truncate the block early', function () {
    $css = '@theme { --color-aura-primary-600: url(http://x.com/img}?y=1); --color-aura-danger-600: #7dd3fc; }';

    expect(ThemeColors::parse($css))->toBe([
        'primary-600' => 'url(http://x.com/img}?y=1)',
        'danger-600' => '#7dd3fc',
    ])->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeFalse();
});

it('treats an unterminated unquoted url() token as unreadable, exercising the generic end-of-file guard', function () {
    $css = '@theme { --color-aura-primary-600: url(http://x.com/no-closing-paren';

    expect(ThemeColors::parse($css))->toBe([])
        ->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeTrue();
});

it('honours a backslash escape outside quotes, so it does not truncate the block early', function () {
    $css = '@theme { --x: a\}b; --color-aura-primary-600: #4338ca; }';

    expect(ThemeColors::parse($css))->toBe([
        'primary-600' => '#4338ca',
    ])->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeFalse();
});

it('signals unreadable, rather than "no overrides", when the extraction regex itself fails (e.g. a PCRE backtrack limit)', function () {
    $original = ini_get('pcre.backtrack_limit');
    ini_set('pcre.backtrack_limit', 1);

    try {
        $css = '@theme { --color-aura-primary-600: #4338ca; }';

        expect(ThemeColors::parse($css))->toBe([])
            ->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeTrue();
    } finally {
        ini_set('pcre.backtrack_limit', $original);
    }
});

describe('hasUnreadableThemeBlock()', function () {
    it('is false when there is no @theme block at all', function () {
        expect(ThemeColors::hasUnreadableThemeBlock('@import "tailwindcss";'))->toBeFalse();
    });

    it('is false for a normal, fully-closed @theme block', function () {
        expect(ThemeColors::hasUnreadableThemeBlock('@theme { --color-aura-primary-500: #111111; }'))->toBeFalse();
    });

    it('is false for an empty @theme block', function () {
        expect(ThemeColors::hasUnreadableThemeBlock('@theme { }'))->toBeFalse();
    });

    it('is true when the @theme block is never closed', function () {
        expect(ThemeColors::hasUnreadableThemeBlock('@theme { --color-aura-primary-500: '))->toBeTrue();
    });

    it('is true when @theme has no opening brace left to scan', function () {
        expect(ThemeColors::hasUnreadableThemeBlock('@theme'))->toBeTrue();
    });

    it('is false when @theme only appears inside a comment', function () {
        expect(ThemeColors::hasUnreadableThemeBlock('/* @theme is a Tailwind 4 directive */'))->toBeFalse();
    });
});
