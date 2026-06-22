<?php

namespace BlueStarSystem\AuraUI\Support;

use InvalidArgumentException;

/**
 * Generate an 11-shade OKLCH palette from a single base color.
 * Algorithm-identical to aura-filament's generator (golden-tested) so themes
 * exported for Filament match what the panel renders.
 */
final class PaletteGenerator
{
    /** @var array<string, float> shade => target OKLCH lightness (0..1) */
    private const SHADE_LIGHTNESS = [
        '50' => 0.975, '100' => 0.94, '200' => 0.88, '300' => 0.80, '400' => 0.70,
        '500' => 0.60, '600' => 0.51, '700' => 0.42, '800' => 0.34, '900' => 0.27, '950' => 0.20,
    ];

    /** @return array<string, string> */
    public static function fromHex(string $hex): array
    {
        [$r, $g, $b] = self::hexToRgb($hex);
        [, $c, $h] = self::rgbToOklch($r, $g, $b);

        $palette = [];
        foreach (self::SHADE_LIGHTNESS as $shade => $targetL) {
            $shadeChroma = round($c * self::chromaScaleFor($targetL), 4);
            $palette[$shade] = sprintf('oklch(%.3f %.4f %.3f)', $targetL, $shadeChroma, $h);
        }

        return $palette;
    }

    private static function chromaScaleFor(float $lightness): float
    {
        $distance = abs($lightness - 0.55);
        $scale = 1.0 - 0.55 * ($distance / 0.55);

        return max(0.3, $scale);
    }

    /** @return array{0:int,1:int,2:int} */
    public static function hexToRgb(string $hex): array
    {
        $hex = ltrim(trim($hex), '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        if (strlen($hex) !== 6 || ! ctype_xdigit($hex)) {
            throw new InvalidArgumentException("Invalid HEX color: {$hex}");
        }

        return [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
    }

    /** @return array{0:float,1:float,2:float} */
    public static function rgbToOklch(int $r, int $g, int $b): array
    {
        $toLinear = fn (int $v) => ($v / 255) <= 0.04045
            ? ($v / 255) / 12.92
            : pow((($v / 255) + 0.055) / 1.055, 2.4);

        $lr = $toLinear($r);
        $lg = $toLinear($g);
        $lb = $toLinear($b);

        $l1 = 0.4122214708 * $lr + 0.5363325363 * $lg + 0.0514459929 * $lb;
        $l2 = 0.2119034982 * $lr + 0.6806995451 * $lg + 0.1073969566 * $lb;
        $l3 = 0.0883024619 * $lr + 0.2817188376 * $lg + 0.6299787005 * $lb;

        $l_ = $l1 > 0 ? pow($l1, 1 / 3) : -pow(-$l1, 1 / 3);
        $m_ = $l2 > 0 ? pow($l2, 1 / 3) : -pow(-$l2, 1 / 3);
        $s_ = $l3 > 0 ? pow($l3, 1 / 3) : -pow(-$l3, 1 / 3);

        $L = 0.2104542553 * $l_ + 0.7936177850 * $m_ - 0.0040720468 * $s_;
        $a = 1.9779984951 * $l_ - 2.4285922050 * $m_ + 0.4505937099 * $s_;
        $b2 = 0.0259040371 * $l_ + 0.7827717662 * $m_ - 0.8086757660 * $s_;

        $C = sqrt($a * $a + $b2 * $b2);
        $h = rad2deg(atan2($b2, $a));
        if ($h < 0) {
            $h += 360;
        }

        return [$L, $C, $h];
    }

    /** @param array<string,string> $palette @return array<string,float> */
    public static function contrastVsWhite(array $palette): array
    {
        $out = [];
        foreach ($palette as $shade => $oklch) {
            if (preg_match('/oklch\(([0-9.]+)\s/', $oklch, $m)) {
                $L = (float) $m[1];
                $out[$shade] = round((1.0 + 0.05) / ($L + 0.05), 2);
            }
        }

        return $out;
    }

    /** Inverse: OKLCH -> sRGB hex (for importing a pasted theme). */
    public static function oklchToHex(float $L, float $C, float $h): string
    {
        $a = $C * cos(deg2rad($h));
        $b = $C * sin(deg2rad($h));

        $l_ = $L + 0.3963377774 * $a + 0.2158037573 * $b;
        $m_ = $L - 0.1055613458 * $a - 0.0638541728 * $b;
        $s_ = $L - 0.0894841775 * $a - 1.2914855480 * $b;

        $l3 = $l_ ** 3;
        $m3 = $m_ ** 3;
        $s3 = $s_ ** 3;

        $lr = 4.0767416621 * $l3 - 3.3077115913 * $m3 + 0.2309699292 * $s3;
        $lg = -1.2684380046 * $l3 + 2.6097574011 * $m3 - 0.3413193965 * $s3;
        $lb = -0.0041960863 * $l3 - 0.7034186147 * $m3 + 1.7076147010 * $s3;

        $toSrgb = function (float $v): int {
            $v = $v <= 0.0031308 ? 12.92 * $v : 1.055 * ($v ** (1 / 2.4)) - 0.055;

            return max(0, min(255, (int) round($v * 255)));
        };

        return sprintf('#%02x%02x%02x', $toSrgb($lr), $toSrgb($lg), $toSrgb($lb));
    }
}
