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
 * regexes, tracking comment / single-quote / double-quote / url() state
 * while it counts braces. A depth counter that does not know about any of
 * those constructs miscounts a `}` that is legitimately just data (inside a
 * quoted value, an unterminated comment, or an unquoted `url(...)` token)
 * and either closes the @theme block too early -- silently dropping every
 * variable declared after it -- or never closes it at all.
 *
 * The invariant this file exists to uphold: if the CSS contains an @theme
 * block and that block was not read cleanly to completion -- for any
 * reason, including ones not yet discovered -- the result must be
 * `unreadable = true`, never a falsely reassuring empty colour list. Two
 * things enforce this by construction rather than by enumerating failure
 * cases: every value ever added to $colors passes through
 * extractColors(), whose own success/failure is folded into $unreadable
 * (see the PCRE-failure branch below); and, at the very end of the scan,
 * `$mode !== 'normal'` fires whenever *anything* -- a comment, a quoted
 * string, a url() token, or a future construct this scanner does not yet
 * know about -- was left open at end of file, regardless of brace depth.
 * That second check is deliberately broader than "the brace we expected
 * never arrived": it is the backstop for the next unanticipated input.
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
     * ends, a comment/string/url() token left open at end of file, or a
     * declaration extraction that itself failed (e.g. a PCRE backtrack
     * limit). Deliberately distinct from "no @theme block" and "@theme
     * block with no Aura colours" -- both of those are legitimate states
     * where Aura's defaults are genuinely still in effect. This one is not:
     * the file was not actually read, so nothing about it should be
     * asserted.
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
        $unreadable = false;

        $mode = 'normal';   // normal | comment | single | double | url
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

            if ($mode === 'single' || $mode === 'double' || $mode === 'url') {
                $closer = $mode === 'single' ? "'" : ($mode === 'double' ? '"' : ')');

                if ($ch === '\\') {
                    // CSS escaping applies inside an unquoted url() token
                    // too, so an escaped closing paren does not end it early.
                    if ($themeDepth > 0) {
                        $buffer .= $ch.$next;
                    }
                    $i += 2;

                    continue;
                }

                if ($themeDepth > 0) {
                    $buffer .= $ch;
                }

                if ($ch === $closer) {
                    $mode = 'normal';
                }

                $i++;

                continue;
            }

            // $mode === 'normal' from here on.

            // CSS allows a backslash to escape the next character anywhere,
            // not only inside quotes -- e.g. `a\}b` is the two characters
            // "a}b" as data, not a structural brace. Checked before anything
            // else so it takes priority over comment/quote/url detection too
            // (an escaped quote character must not open a string).
            if ($ch === '\\') {
                if ($themeDepth > 0) {
                    $buffer .= $ch.$next;
                }
                $i += 2;

                continue;
            }

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

            // An unquoted url(...) token: per the CSS syntax spec, a `}` (or
            // any other character) inside it is just data, not structure.
            // If the content is instead quoted (url("...")), that is not
            // this token form at all -- leave it alone here so the very next
            // iteration hits the ordinary quote branch above and handles it
            // as a normal quoted string, closing paren included.
            if (($ch === 'u' || $ch === 'U') && stripos($css, 'url(', $i) === $i) {
                $afterParen = $i + 4 < $length ? $css[$i + 4] : '';

                if ($afterParen !== "'" && $afterParen !== '"') {
                    if ($themeDepth > 0) {
                        $buffer .= substr($css, $i, 4);
                    }
                    $i += 4;
                    $mode = 'url';

                    continue;
                }
            }

            if ($themeDepth === 0 && ! $awaitingBrace && $ch === '@' && stripos($css, '@theme', $i) === $i) {
                // Word-boundary check: "@theme-custom" is a different,
                // hypothetical at-rule that merely starts with the same six
                // characters and must not be mistaken for "@theme".
                $boundary = $i + 6 < $length ? $css[$i + 6] : '';

                if ($boundary === '' || ! self::isIdentChar($boundary)) {
                    $awaitingBrace = true;
                    $i += 6;   // strlen('@theme')

                    continue;
                }
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
                        $extracted = self::extractColors($buffer);

                        foreach ($extracted['colors'] as $shade => $value) {
                            $colors[$shade] = $value;
                        }

                        if (! $extracted['ok']) {
                            $unreadable = true;
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

        // The invariant this whole scan exists to uphold: a block that was
        // not read cleanly to completion must never present as "nothing
        // found". $awaitingBrace / $themeDepth > 0 cover "the brace we
        // expected never arrived". `$mode !== 'normal'` is the broader
        // backstop -- it fires whenever a comment, quoted string, or url()
        // token (or a future construct not yet known to this scanner) was
        // left open at end of file, independent of brace depth, so the next
        // unanticipated input fails safe instead of reassuring.
        $unreadable = $unreadable || $awaitingBrace || $themeDepth > 0 || $mode !== 'normal';

        return ['colors' => $colors, 'unreadable' => $unreadable];
    }

    private static function isIdentChar(string $ch): bool
    {
        return $ch !== '' && preg_match('/[a-zA-Z0-9_-]/', $ch) === 1;
    }

    /** @return array{colors: array<string, string>, ok: bool} */
    private static function extractColors(string $block): array
    {
        $matched = @preg_match_all('/--color-aura-([a-z]+-[0-9]+)\s*:\s*([^;]+);/i', $block, $found, PREG_SET_ORDER);

        if ($matched === false || preg_last_error() !== PREG_NO_ERROR) {
            return ['colors' => [], 'ok' => false];
        }

        $colors = [];

        foreach ($found as $match) {
            $colors[strtolower(trim($match[1]))] = trim($match[2]);
        }

        return ['colors' => $colors, 'ok' => true];
    }
}
