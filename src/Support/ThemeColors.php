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
 * Two things a naive implementation gets wrong, both fixed here:
 *
 * - CSS comments are not code. `/* --color-aura-primary-600: #ff0000; *\/`
 *   inside a @theme block must never be read as a live override -- the
 *   browser never applies it, so reporting it would flag a colour that
 *   cannot possibly be a contrast problem. Comments are stripped before
 *   anything else runs.
 * - @theme blocks are scanned by counting braces, not by a lazy regex to the
 *   first `}`. A nested at-rule (e.g. a `@media` block inside `@theme`, which
 *   Tailwind 4 allows) has its own `{`/`}` pair; a regex that stops at the
 *   first `}` truncates the block there and silently drops every variable
 *   that follows it in the file.
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
     * read -- most commonly an opening `{` with no matching closing brace
     * before the file ends (a truncated or otherwise malformed file). This
     * is deliberately distinct from "no @theme block" and "@theme block with
     * no Aura colours": both of those are legitimate states where Aura's
     * defaults are genuinely still in effect. This one is not -- the file
     * was not actually read, so nothing about it should be asserted.
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
        $css = self::stripComments($css);

        $colors = [];
        $unreadable = false;
        $length = strlen($css);
        $offset = 0;

        while (($start = stripos($css, '@theme', $offset)) !== false) {
            $openBrace = strpos($css, '{', $start);

            if ($openBrace === false) {
                // "@theme" with no block at all left in the file -- nothing
                // more can be scanned after it either.
                $unreadable = true;

                break;
            }

            $depth = 1;
            $i = $openBrace + 1;

            while ($i < $length && $depth > 0) {
                if ($css[$i] === '{') {
                    $depth++;
                } elseif ($css[$i] === '}') {
                    $depth--;
                }

                $i++;
            }

            if ($depth !== 0) {
                // Opened but never closed before the file ended.
                $unreadable = true;

                break;
            }

            $block = substr($css, $openBrace + 1, $i - 1 - ($openBrace + 1));

            $matched = @preg_match_all('/--color-aura-([a-z]+-[0-9]+)\s*:\s*([^;]+);/i', $block, $found, PREG_SET_ORDER);

            if ($matched !== false) {
                foreach ($found as $match) {
                    $colors[strtolower(trim($match[1]))] = trim($match[2]);
                }
            }

            $offset = $i;
        }

        return ['colors' => $colors, 'unreadable' => $unreadable];
    }

    /**
     * Blanks out /* ... *\/ comments so nothing inside one is ever mistaken
     * for a live declaration or a structural brace.
     */
    private static function stripComments(string $css): string
    {
        return preg_replace('#/\*.*?\*/#s', ' ', $css) ?? $css;
    }
}
