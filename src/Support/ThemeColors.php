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
 * Runs as a single character-by-character scan, tracking comment /
 * single-quote / double-quote / url() state while it counts braces *and*
 * accumulates each declaration. Declaration extraction used to be a second,
 * separate step -- a regex thrown at the whole block's raw text once the
 * closing brace was found -- and every defect found in this file after the
 * scan itself was already correct lived in that seam: the regex had no idea
 * a `}`, a `;`, or a declaration-shaped fragment could legitimately be
 * sitting inside a quoted value or a url() token rather than being real
 * structure. Recording each declaration *as the scan proceeds*, in the same
 * pass that already knows exactly what is a quote, a comment, a url() token
 * and a genuinely structural brace or semicolon, removes that seam rather
 * than hardening the regex against the next input shaped like it.
 *
 * The invariant this file exists to uphold: if the CSS contains an @theme
 * block and that block was not read cleanly to completion -- for any
 * reason, including ones not yet discovered -- the result must be
 * `unreadable = true`, never a falsely reassuring empty colour list. At the
 * end of the scan, `$mode !== 'normal'` fires whenever *anything* -- a
 * comment, a quoted string, a url() token, or a future construct this
 * scanner does not yet know about -- was left open at end of file,
 * independent of brace depth. That is a deliberately broad backstop for the
 * next unanticipated input, on top of (not instead of) the specific
 * quote/comment/url handling below.
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
     * ends, or a comment/string/url() token left open at end of file.
     * Deliberately distinct from "no @theme block" and "@theme block with
     * no Aura colours" -- both of those are legitimate states where Aura's
     * defaults are genuinely still in effect. This one is not: the file was
     * not actually read, so nothing about it should be asserted.
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
        $declaration = '';  // the current, not-yet-terminated declaration's text

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
                        $declaration .= $ch.$next;
                    }
                    $i += 2;

                    continue;
                }

                if ($themeDepth > 0) {
                    $declaration .= $ch;
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
                    $declaration .= $ch.$next;
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
                    $declaration .= $ch;
                }

                $i++;

                continue;
            }

            // An unquoted url(...) token: per the CSS syntax spec, a `}`,
            // `;`, or any other character inside it is just data, not
            // structure. Tolerates whitespace and comments between "url"
            // and "(" (both legal CSS). A quoted url("...") is left alone
            // here so the very next relevant character hits the ordinary
            // quote branch above and is handled as a normal string, closing
            // paren included -- the common url("data:...;base64,...") case
            // needs no special casing at all this way.
            if (($ch === 'u' || $ch === 'U') && ! ($i > 0 && self::isIdentChar($css[$i - 1]))) {
                // Left word-boundary check: without it, "notaurl(" matches
                // at its embedded "url(", the same way "@theme-custom" would
                // wrongly match "@theme" without the boundary check below.
                $afterParen = self::urlTokenParenEnd($css, $i, $length);

                if ($afterParen !== null) {
                    $afterParenChar = $afterParen < $length ? $css[$afterParen] : '';

                    if ($afterParenChar !== "'" && $afterParenChar !== '"') {
                        if ($themeDepth > 0) {
                            $declaration .= substr($css, $i, $afterParen - $i);
                        }

                        $i = $afterParen;
                        $mode = 'url';

                        continue;
                    }
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
                $declaration = '';
                $i++;

                continue;
            }

            if ($themeDepth > 0) {
                if ($ch === '{') {
                    // Opens a nested at-rule (e.g. @media inside @theme).
                    // Whatever was accumulated before it is a selector, not
                    // a declaration -- discard rather than let it corrupt
                    // the next real declaration inside the nested block.
                    $themeDepth++;
                    $declaration = '';
                } elseif ($ch === '}') {
                    // CSS allows the last declaration in a block to omit its
                    // trailing semicolon before the closing brace -- flush
                    // whatever is pending before adjusting depth, or a
                    // semicolon-less top-level declaration is silently lost.
                    // Gated to depth 1 for the same reason the `;` branch
                    // below is: this closing brace might belong to a nested
                    // at-rule, whose own trailing declaration is not a
                    // top-level theme override either.
                    if ($themeDepth === 1) {
                        self::recordDeclaration($colors, $declaration);
                    }
                    $themeDepth--;
                    $declaration = '';
                } elseif ($ch === ';') {
                    // A semicolon reached in normal mode, inside the theme
                    // block, terminates a real declaration -- but only a
                    // depth-1 (top-level) one counts as a theme override.
                    // A declaration inside a nested at-rule (e.g. @media)
                    // only applies conditionally, under that at-rule, and
                    // recording it unconditionally would let a passing
                    // conditional value mask a failing unconditional one --
                    // exactly the state this file exists to prevent.
                    if ($themeDepth === 1) {
                        self::recordDeclaration($colors, $declaration);
                    }
                    $declaration = '';
                } else {
                    $declaration .= $ch;
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

    /**
     * If $css, at offset $i, is a case-insensitive "url" identifier that --
     * once any whitespace and complete comments between it and the opening
     * parenthesis are skipped -- is followed by "(", returns the offset
     * immediately after that "(". Returns null when "url" is not actually
     * followed by "(" (just an ordinary identifier, not a url() token), or
     * when a comment in between never closes -- this does not guess through
     * an unterminated comment either; the ordinary comment-mode handling
     * reaches it on the next iteration and reports unreadable normally.
     */
    private static function urlTokenParenEnd(string $css, int $i, int $length): ?int
    {
        if (stripos($css, 'url', $i) !== $i) {
            return null;
        }

        $j = $i + 3;

        while ($j < $length) {
            $c = $css[$j];

            if ($c === ' ' || $c === "\t" || $c === "\n" || $c === "\r" || $c === "\f") {
                $j++;

                continue;
            }

            if ($c === '/' && $j + 1 < $length && $css[$j + 1] === '*') {
                $close = strpos($css, '*/', $j + 2);

                if ($close === false) {
                    return null;
                }

                $j = $close + 2;

                continue;
            }

            break;
        }

        return $j < $length && $css[$j] === '(' ? $j + 1 : null;
    }

    private static function isIdentChar(string $ch): bool
    {
        return $ch !== '' && preg_match('/[a-zA-Z0-9_-]/', $ch) === 1;
    }

    /**
     * Parses a single, already-isolated declaration -- the scan only calls
     * this with text that ran from one structural boundary to the next, so
     * there is no quote/url ambiguity left to resolve here, and no regex is
     * needed: a "--color-aura-*" declaration is fully described by "does the
     * trimmed text start with that prefix" and "where is the first colon".
     *
     * @param  array<string, string>  $colors
     */
    private static function recordDeclaration(array &$colors, string $declaration): void
    {
        $declaration = ltrim($declaration);

        if (stripos($declaration, '--color-aura-') !== 0) {
            return;
        }

        $rest = substr($declaration, strlen('--color-aura-'));
        $colon = strpos($rest, ':');

        if ($colon === false) {
            return;
        }

        $shade = strtolower(trim(substr($rest, 0, $colon)));
        $value = trim(substr($rest, $colon + 1));

        if ($shade === '' || $value === '') {
            return;
        }

        $colors[$shade] = $value;
    }
}
