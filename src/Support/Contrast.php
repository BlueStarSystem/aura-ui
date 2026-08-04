<?php

namespace BlueStarSystem\AuraUI\Support;

use InvalidArgumentException;

/**
 * WCAG 2.1 relative luminance and contrast ratios.
 *
 * Kept separate from PaletteGenerator on purpose: PaletteGenerator works in
 * OKLCH, whose L is *perceptual* lightness, and WCAG's relative luminance is
 * not the same quantity. Conflating the two is precisely the bug this class
 * replaces -- the old PaletteGenerator::contrastVsWhite() fed OKLCH L into the
 * WCAG formula and reported ratios far below the truth.
 */
final class Contrast
{
    public const AA_NORMAL = 4.5;

    public const AA_LARGE = 3.0;

    public static function ratio(string $a, string $b): float
    {
        $la = self::relativeLuminance($a);
        $lb = self::relativeLuminance($b);

        [$lighter, $darker] = $la > $lb ? [$la, $lb] : [$lb, $la];

        return round(($lighter + 0.05) / ($darker + 0.05), 2);
    }

    public static function passesAA(string $a, string $b, bool $largeText = false): bool
    {
        return self::ratio($a, $b) >= ($largeText ? self::AA_LARGE : self::AA_NORMAL);
    }

    /**
     * WCAG 2.1 relative luminance from sRGB, after undoing gamma encoding.
     */
    public static function relativeLuminance(string $color): float
    {
        [$r, $g, $b] = self::toRgb($color);

        $linear = static function (int $channel): float {
            $v = $channel / 255;

            return $v <= 0.04045 ? $v / 12.92 : (($v + 0.055) / 1.055) ** 2.4;
        };

        return 0.2126 * $linear($r) + 0.7152 * $linear($g) + 0.0722 * $linear($b);
    }

    /** @return array{0:int,1:int,2:int} */
    private static function toRgb(string $color): array
    {
        $color = trim($color);

        if (preg_match('/^oklch\(\s*([0-9.]+)\s+([0-9.]+)\s+([0-9.]+)\s*\)$/i', $color, $m) === 1) {
            return PaletteGenerator::hexToRgb(
                PaletteGenerator::oklchToHex((float) $m[1], (float) $m[2], (float) $m[3])
            );
        }

        if (preg_match('/^#?[0-9a-f]{3}$|^#?[0-9a-f]{6}$/i', $color) === 1) {
            return PaletteGenerator::hexToRgb($color);
        }

        throw new InvalidArgumentException("Unrecognised colour: {$color}");
    }
}
