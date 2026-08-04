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

it('does not let a nested at-rule truncate the @theme block early, and does not let its conditional override mask the real one', function () {
    $css = <<<'CSS'
    @theme {
        --color-aura-primary-500: #111111;
        @media (prefers-color-scheme: dark) {
            --color-aura-primary-500: #222222;
        }
        --color-aura-success-700: #333333;
    }
    CSS;

    // Recording is gated to depth 1 (see the "gate recording to depth 1"
    // fixes below): a declaration inside a nested at-rule only applies
    // conditionally, under that at-rule, so it must not silently overwrite
    // the unconditional top-level value -- previously it did, which could
    // mask a genuinely failing top-level colour behind a passing
    // conditional one. success-700, declared after the nested block closes,
    // proves the block was not truncated early either.
    expect(ThemeColors::parse($css))->toBe([
        'primary-500' => '#111111',
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

it('tolerates whitespace between "url" and "(", so a stray brace inside it still cannot hide a real override', function () {
    $css = '@theme { --color-aura-primary-600: url  (http://x.com/img}?y=1); --color-aura-danger-600: #ff0000; }';

    expect(ThemeColors::parse($css))->toBe([
        'primary-600' => 'url  (http://x.com/img}?y=1)',
        'danger-600' => '#ff0000',
    ])->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeFalse();
});

it('tolerates a comment between "url" and "(" too', function () {
    $css = '@theme { --color-aura-primary-600: url/* wat */(http://x.com/img}?y=1); --color-aura-danger-600: #ff0000; }';

    // The comment is still recognised for the purpose of *finding* the url()
    // token (its stray `}` does not truncate the block), but the raw text
    // between "url" and "(" is not itself stripped from the captured value
    // -- only genuine comment *content*, i.e. what would appear between "("
    // and ")", is data this scanner strips elsewhere. What matters here is
    // that danger-600 is not lost.
    expect(ThemeColors::parse($css))->toBe([
        'primary-600' => 'url/* wat */(http://x.com/img}?y=1)',
        'danger-600' => '#ff0000',
    ])->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeFalse();
});

it('does not let a declaration-shaped fragment inside a quoted value spoof a real declaration', function () {
    $css = '@theme { --color-aura-danger-600: #ff0000; --color-aura-primary-600: "junk;--color-aura-danger-600: #00ff00;more"; }';

    expect(ThemeColors::parse($css))->toBe([
        'danger-600' => '#ff0000',
        'primary-600' => '"junk;--color-aura-danger-600: #00ff00;more"',
    ])->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeFalse();
});

it('keeps the full value of a url() containing a semicolon, such as a base64 data URI', function () {
    $css = '@theme { --color-aura-primary-600: url("data:image/png;base64,AAAA//8="); }';

    expect(ThemeColors::parse($css))->toBe([
        'primary-600' => 'url("data:image/png;base64,AAAA//8=")',
    ])->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeFalse();
});

it('flushes the last declaration before a closing brace even without a trailing semicolon', function () {
    $css = '@theme { --color-aura-primary-600: #7dd3fc }';   // legal CSS, no trailing ";"

    expect(ThemeColors::parse($css))->toBe([
        'primary-600' => '#7dd3fc',
    ])->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeFalse();
});

it('does not treat "url(" embedded inside a longer identifier as a url() token', function () {
    // Without a left word-boundary check, "notaurl(" matches at its "url(",
    // and everything up to the *next* unescaped ")" -- including the real
    // override and the ";" that should terminate it -- is swallowed as
    // opaque url content. The override must not disappear because of that;
    // it is still captured here (with the stray, unmatched ")" from
    // "notaurl(" trailing its value, since that paren is not itself
    // structural to this scanner) -- what matters is it is not lost.
    $css = '@theme { --x: notaurl(void; --color-aura-primary-600: #7dd3fc); }';

    expect(ThemeColors::parse($css))->toBe([
        'primary-600' => '#7dd3fc)',
    ])->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeFalse();
});

it('does not let a declaration inside a nested at-rule mask a real top-level one, nested before top', function () {
    $css = '@theme { @media (min-width:0) { --color-aura-primary-600: #000000; } --color-aura-primary-600: #7dd3fc; }';

    expect(ThemeColors::parse($css))->toBe([
        'primary-600' => '#7dd3fc',
    ])->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeFalse();
});

it('does not let a declaration inside a nested at-rule mask a real top-level one, nested after top', function () {
    $css = '@theme { --color-aura-primary-600: #7dd3fc; @media (min-width:0) { --color-aura-primary-600: #000000; } }';

    expect(ThemeColors::parse($css))->toBe([
        'primary-600' => '#7dd3fc',
    ])->and(ThemeColors::hasUnreadableThemeBlock($css))->toBeFalse();
});

// A prior revision of this scanner ran a whole-block regex
// (`--color-aura-...` via preg_match_all) once a block's closing brace was
// found, and a test here proved a PCRE failure (e.g. pcre.backtrack_limit=1)
// degraded to "unreadable" rather than a silent []. That whole-buffer regex
// has since been deleted -- declarations are now recorded live, character
// by character, inside scan() itself (see recordDeclaration(), which uses
// plain string operations, not a regex) specifically to close the seam
// where a regex could misread a quote/url/semicolon boundary it did not
// understand. With no regex left anywhere in the declaration-extraction
// path, that specific PCRE-failure scenario can no longer occur, and the
// test asserting it was removed rather than edited to pass some other way.
// isIdentChar()'s single-character regex is the one PCRE call remaining in
// this file; it did not fail under pcre.backtrack_limit=1 when this was
// verified (matching a lone character against `[a-zA-Z0-9_-]` needs no
// backtracking), so it does not stand in for the deleted test's scenario.

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
