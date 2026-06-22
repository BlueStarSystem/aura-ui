<?php

use BlueStarSystem\AuraUI\Support\PaletteGenerator;

it('generates the canonical OKLCH scale for the Aura primary', function () {
    expect(PaletteGenerator::fromHex('#6366f1'))->toBe([
        '50'  => 'oklch(0.975 0.1173 277.117)',
        '100' => 'oklch(0.940 0.1245 277.117)',
        '200' => 'oklch(0.880 0.1367 277.117)',
        '300' => 'oklch(0.800 0.1530 277.117)',
        '400' => 'oklch(0.700 0.1734 277.117)',
        '500' => 'oklch(0.600 0.1939 277.117)',
        '600' => 'oklch(0.510 0.1959 277.117)',
        '700' => 'oklch(0.420 0.1775 277.117)',
        '800' => 'oklch(0.340 0.1612 277.117)',
        '900' => 'oklch(0.270 0.1469 277.117)',
        '950' => 'oklch(0.200 0.1326 277.117)',
    ]);
});

it('matches the Aura danger and surface golden scales', function () {
    expect(PaletteGenerator::fromHex('#ef4444')['500'])->toBe('oklch(0.600 0.1975 25.331)')
        ->and(PaletteGenerator::fromHex('#64748b')['500'])->toBe('oklch(0.600 0.0387 257.417)');
});

it('accepts shorthand hex and rejects invalid', function () {
    expect(PaletteGenerator::fromHex('#fff')['500'])->toStartWith('oklch(')
        ->and(fn () => PaletteGenerator::fromHex('zzz'))->toThrow(InvalidArgumentException::class);
});

it('round-trips a base color through oklchToHex within tolerance', function () {
    [$l, $c, $h] = PaletteGenerator::rgbToOklch(99, 102, 241); // #6366f1
    $hex = PaletteGenerator::oklchToHex($l, $c, $h);
    [$r, $g, $b] = PaletteGenerator::hexToRgb($hex);
    expect(abs($r - 99))->toBeLessThanOrEqual(2)
        ->and(abs($g - 102))->toBeLessThanOrEqual(2)
        ->and(abs($b - 241))->toBeLessThanOrEqual(2);
});
