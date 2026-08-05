<?php

use BlueStarSystem\AuraUI\Support\Contrast;
use Illuminate\Support\Facades\Blade;

/**
 * ColorContrastTest.php asserts colour ARITHMETIC ("this hex pair clears
 * 4.5:1") but nothing ties those hex pairs to what a component actually
 * renders -- reverting a Blade file to a failing shade would leave that
 * suite green, because the datasets are hand-copied hex, not the live class.
 *
 * This file closes that gap for a subset of components: it renders the real
 * Blade markup, extracts the *light-mode* `bg-aura-*`/`text-aura-*` (or
 * literal `text-white`) classes from the HTML with a regex, resolves them
 * through the same palette table as `resources/css/aura.css`, and only then
 * runs them through `Contrast::ratio()`. If a component is edited back to a
 * shade that fails AA, the resolved hex changes and this test fails -- no
 * hand-maintained hex list to forget to update.
 *
 * Coverage is deliberately partial, stated honestly:
 *  - Covers: button (solid primary/success/warning/danger), badge (all six
 *    variants), alert (all four variants), indicator (all five colors).
 *  - Does NOT cover: outline/gradient button variants, dark mode (`.dark`
 *    overrides), non-text UI (borders/icons, the 3:1 dataset), or any
 *    component outside these four -- notably not the Pro package. Extending
 *    it means adding a row to the dataset below; the extraction/resolution
 *    logic is generic.
 */
const AURA_TEST_PALETTE = [
    'primary' => ['50' => 'eef6ff', '100' => 'dbeafe', '200' => 'bfdbfe', '300' => '93c5fd', '400' => '60a5fa', '500' => '6366f1', '600' => '4f46e5', '700' => '4338ca', '800' => '3730a3', '900' => '312e81', '950' => '1e1b4b'],
    'secondary' => ['50' => 'ecfeff', '100' => 'cffafe', '200' => 'a5f3fc', '300' => '67e8f9', '400' => '22d3ee', '500' => '06b6d4', '600' => '0891b2', '700' => '0e7490', '800' => '155e75', '900' => '164e63'],
    'success' => ['50' => 'ecfdf5', '100' => 'd1fae5', '200' => 'a7f3d0', '300' => '6ee7b7', '400' => '34d399', '500' => '10b981', '600' => '059669', '700' => '047857', '800' => '065f46', '900' => '064e3b'],
    'warning' => ['50' => 'fffbeb', '100' => 'fef3c7', '200' => 'fde68a', '300' => 'fcd34d', '400' => 'fbbf24', '500' => 'f59e0b', '600' => 'd97706', '700' => 'b45309', '800' => '92400e', '900' => '78350f'],
    'danger' => ['50' => 'fef2f2', '100' => 'fee2e2', '200' => 'fecaca', '300' => 'fca5a5', '400' => 'f87171', '500' => 'ef4444', '600' => 'dc2626', '700' => 'b91c1c', '800' => '991b1b', '900' => '7f1d1d'],
    'info' => ['50' => 'f0f9ff', '100' => 'e0f2fe', '200' => 'bae6fd', '300' => '7dd3fc', '400' => '38bdf8', '500' => '0ea5e9', '600' => '0284c7', '700' => '0369a1', '800' => '075985', '900' => '0c4a6e'],
    'surface' => ['0' => 'ffffff', '50' => 'f8fafc', '100' => 'f1f5f9', '200' => 'e2e8f0', '300' => 'cbd5e1', '400' => '94a3b8', '500' => '64748b', '600' => '475569', '700' => '334155', '800' => '1e293b', '900' => '0f172a'],
];

/**
 * Finds the first LIGHT-mode (not `dark:`-prefixed) `{prefix}-aura-<hue>-<shade>`
 * class in the rendered HTML and resolves it to a hex colour via the palette
 * table above. Returns null if no such class is present.
 */
function auraExtractColor(string $html, string $prefix): ?string
{
    if (preg_match('/(?<!dark:)\b'.preg_quote($prefix, '/').'-aura-([a-z]+)-(\d+)\b/', $html, $m) !== 1) {
        return null;
    }

    [, $hue, $shade] = $m;

    if (! isset(AURA_TEST_PALETTE[$hue][$shade])) {
        throw new RuntimeException("Rendered class {$prefix}-aura-{$hue}-{$shade} has no entry in the test palette table -- update AURA_TEST_PALETTE.");
    }

    return '#'.AURA_TEST_PALETTE[$hue][$shade];
}

dataset('rendered solid surfaces', [
    'button primary solid' => ['<x-aura::button variant="primary">Test</x-aura::button>'],
    'button success solid' => ['<x-aura::button variant="success">Test</x-aura::button>'],
    'button warning solid' => ['<x-aura::button variant="warning">Test</x-aura::button>'],
    'button danger solid' => ['<x-aura::button variant="danger">Test</x-aura::button>'],
    'badge primary' => ['<x-aura::badge variant="primary">Test</x-aura::badge>'],
    'badge secondary' => ['<x-aura::badge variant="secondary">Test</x-aura::badge>'],
    'badge success' => ['<x-aura::badge variant="success">Test</x-aura::badge>'],
    'badge warning' => ['<x-aura::badge variant="warning">Test</x-aura::badge>'],
    'badge danger' => ['<x-aura::badge variant="danger">Test</x-aura::badge>'],
    'badge info' => ['<x-aura::badge variant="info">Test</x-aura::badge>'],
    'alert info' => ['<x-aura::alert variant="info">Test</x-aura::alert>'],
    'alert success' => ['<x-aura::alert variant="success">Test</x-aura::alert>'],
    'alert warning' => ['<x-aura::alert variant="warning">Test</x-aura::alert>'],
    'alert danger' => ['<x-aura::alert variant="danger">Test</x-aura::alert>'],
    'indicator primary' => ['<x-aura::indicator color="primary" label="1"><span>x</span></x-aura::indicator>'],
    'indicator success' => ['<x-aura::indicator color="success" label="1"><span>x</span></x-aura::indicator>'],
    'indicator warning' => ['<x-aura::indicator color="warning" label="1"><span>x</span></x-aura::indicator>'],
    'indicator info' => ['<x-aura::indicator color="info" label="1"><span>x</span></x-aura::indicator>'],
    'indicator secondary' => ['<x-aura::indicator color="secondary" label="1"><span>x</span></x-aura::indicator>'],
    'indicator danger (default)' => ['<x-aura::indicator label="1"><span>x</span></x-aura::indicator>'],
]);

it('renders solid-surface components whose light-mode colour classes still clear WCAG AA', function (string $markup) {
    $html = Blade::render($markup);

    $background = auraExtractColor($html, 'bg');
    expect($background)->not->toBeNull("no light-mode bg-aura-* class found in: {$html}");

    $foreground = auraExtractColor($html, 'text');
    if ($foreground === null) {
        expect(str_contains($html, 'text-white'))
            ->toBeTrue("no light-mode text-aura-* class and no literal text-white in: {$html}");
        $foreground = '#ffffff';
    }

    expect(Contrast::ratio($background, $foreground))
        ->toBeGreaterThanOrEqual(Contrast::AA_NORMAL);
})->with('rendered solid surfaces');
