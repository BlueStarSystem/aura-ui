<?php

namespace BlueStarSystem\AuraUI\Support;

/**
 * Pull the Aura colour variables out of an app's Tailwind 4 @theme block.
 *
 * Deliberately not a CSS parser: it reads the one shape Aura documents, and
 * returns nothing rather than guessing when the file is not that shape. The
 * doctor turns "nothing" into a warning, never an error -- refusing to build
 * someone's app over CSS we failed to read would be worse than staying quiet.
 */
final class ThemeColors
{
    /** @return array<string, string> */
    public static function parse(string $css): array
    {
        $matched = @preg_match_all('/@theme[^{]*\{(.*?)\}/s', $css, $blocks);

        if ($matched === false || $matched === 0) {
            return [];
        }

        $colors = [];

        foreach ($blocks[1] ?? [] as $block) {
            preg_match_all('/--color-aura-([a-z]+-[0-9]+)\s*:\s*([^;]+);/i', $block, $found, PREG_SET_ORDER);

            foreach ($found as $match) {
                $colors[strtolower(trim($match[1]))] = trim($match[2]);
            }
        }

        return $colors;
    }
}
