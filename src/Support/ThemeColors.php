<?php

namespace BlueStarSystem\AuraUI\Support;

/**
 * Pull the Aura colour variables out of an app's Tailwind 4 @theme block.
 *
 * Deliberately not a CSS parser: it reads the one shape Aura documents, and
 * returns nothing rather than guessing when the file is not that shape. The
 * doctor turns "nothing" into a warning, never an error -- refusing to build
 * someone's app over CSS we failed to read would be worse than staying quiet.
 *
 * Runs as a single character-by-character scan rather than a couple of
 * regexes, because two earlier regex-based attempts each broke in a
 * different, real way:
 *
 * - A brace that is part of a quoted value (`--font-label: "weird } quote"`)
 *   is not a structural brace. A depth counter that does not track quote
 *   state closes the @theme block early there and silently drops every
 *   variable declared after it.
 * - Comments are not code, and an *unterminated* comment is not "no comment"
 *   -- it has to surface as "could not read this", not "parse whatever text
 *   follows as if it were live" and not "quietly say nothing happened".
 *
 * A single pass that tracks comment/single-quote/double-quote state while it
 * counts braces gets both right at once, where stripping comments first and
 * depth-counting the result separately cannot: a brace inside an
 * unterminated comment must not count either, and only a pass that already
 * knows it never found the closing `*``/` can report that honestly.
 */
final class ThemeColors
{
    /** @return array<string, string> */
    public static function parse(string $css): array
    {
        return self::scan($css)['colors'];
    }

    /**
     * True when the CSS contains an @theme block that could not be fully
     * read: an opening `{` with no matching closing brace before the file
     * ends, including when a nested, unterminated comment or quoted string
     * swallows what would have been the closing brace. Deliberately distinct
     * from "no @theme block" and "@theme block with no Aura colours" -- both
     * of those are legitimate states where Aura's defaults are genuinely
     * still in effect. This one is not: the file was not actually read, so
     * nothing about it should be asserted.
     */
    public static function hasUnreadableThemeBlock(string $css): bool
    {
        return self::scan($css)['unreadable'];
    }

    /**
     * @return array{colors: array<string, string>, unreadable: bool}
     */
    private static function scan(string $css): array
    {
        $length = strlen($css);
        $colors = [];

        $mode = 'normal';   // normal | comment | single | double
        $awaitingBrace = false;
        $themeDepth = 0;    // 0 = not currently inside an @theme block
        $buffer = '';

        $i = 0;

        while ($i < $length) {
            $ch = $css[$i];
            $next = $i + 1 < $length ? $css[$i + 1] : '';

            if ($mode === 'comment') {
                if ($ch === '*' && $next === '/') {
                    $mode = 'normal';
                    $i += 2;

                    continue;
                }

                $i++;

                continue;
            }

            if ($mode === 'single' || $mode === 'double') {
                if ($ch === '\\') {
                    if ($themeDepth > 0) {
                        $buffer .= $ch.$next;
                    }
                    $i += 2;

                    continue;
                }

                if ($themeDepth > 0) {
                    $buffer .= $ch;
                }

                if (($mode === 'single' && $ch === "'") || ($mode === 'double' && $ch === '"')) {
                    $mode = 'normal';
                }

                $i++;

                continue;
            }

            // $mode === 'normal' from here on.
            if ($ch === '/' && $next === '*') {
                $mode = 'comment';
                $i += 2;

                continue;
            }

            if ($ch === "'" || $ch === '"') {
                $mode = $ch === "'" ? 'single' : 'double';

                if ($themeDepth > 0) {
                    $buffer .= $ch;
                }

                $i++;

                continue;
            }

            if ($themeDepth === 0 && ! $awaitingBrace && $ch === '@' && stripos($css, '@theme', $i) === $i) {
                $awaitingBrace = true;
                $i += 6;   // strlen('@theme')

                continue;
            }

            if ($awaitingBrace && $ch === '{') {
                $awaitingBrace = false;
                $themeDepth = 1;
                $buffer = '';
                $i++;

                continue;
            }

            if ($themeDepth > 0) {
                if ($ch === '{') {
                    $themeDepth++;
                    $buffer .= $ch;
                } elseif ($ch === '}') {
                    $themeDepth--;

                    if ($themeDepth === 0) {
                        foreach (self::extractColors($buffer) as $shade => $value) {
                            $colors[$shade] = $value;
                        }

                        $buffer = '';
                    } else {
                        $buffer .= $ch;
                    }
                } else {
                    $buffer .= $ch;
                }
            }

            $i++;
        }

        // Reached the end of the file still expecting a brace (either the
        // block's opening one, or its closing one -- the latter also covers
        // an unterminated comment/quote that swallowed the real `}`): the
        // block was not fully read.
        $unreadable = $awaitingBrace || $themeDepth > 0;

        return ['colors' => $colors, 'unreadable' => $unreadable];
    }

    /** @return array<string, string> */
    private static function extractColors(string $block): array
    {
        $matched = @preg_match_all('/--color-aura-([a-z]+-[0-9]+)\s*:\s*([^;]+);/i', $block, $found, PREG_SET_ORDER);

        if ($matched === false) {
            return [];
        }

        $colors = [];

        foreach ($found as $match) {
            $colors[strtolower(trim($match[1]))] = trim($match[2]);
        }

        return $colors;
    }
}
