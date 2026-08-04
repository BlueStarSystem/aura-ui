<?php

use BlueStarSystem\AuraUI\Support\Contrast;

/**
 * Every colour pair a component actually renders, with the shade the Blade
 * template really uses. When a template changes shade, this list changes with
 * it -- that is the point: the list is the contract.
 */
dataset('solid surfaces', [
    // [etichetta, sfondo, testo]
    'button primary' => ['#4f46e5', '#ffffff'],  // primary-600
    'button success' => ['#047857', '#ffffff'],  // success-700
    'button danger' => ['#dc2626', '#ffffff'],  // danger-600
    'button warning' => ['#f59e0b', '#0f172a'],  // warning-500 su surface-900
    'button secondary' => ['#f1f5f9', '#0f172a'],  // surface-100 su surface-900
    'badge primary' => ['#dbeafe', '#4338ca'],
    'badge success' => ['#d1fae5', '#047857'],
    'badge warning' => ['#fef3c7', '#b45309'],
    'badge danger' => ['#fee2e2', '#b91c1c'],
    'badge info' => ['#e0f2fe', '#0369a1'],
    'badge secondary' => ['#e2e8f0', '#334155'],  // surface-200 / surface-700
    'indicator info' => ['#0369a1', '#ffffff'],       // info-700
    'indicator warning' => ['#b45309', '#ffffff'],    // warning-700
    'indicator secondary' => ['#64748b', '#ffffff'],  // surface-500

    // Task 6c: alert.blade.php's -800 text classes referenced a shade that doesn't
    // exist (palettes stop at 700), so the utility never compiled and the text
    // rendered in an inherited colour. Fixed to -700, which does exist.
    'alert info' => ['#f0f9ff', '#0369a1'],        // info-50 / info-700
    'alert success' => ['#ecfdf5', '#047857'],     // success-50 / success-700
    'alert warning' => ['#fffbeb', '#b45309'],     // warning-50 / warning-700
    'alert danger' => ['#fef2f2', '#b91c1c'],      // danger-50 / danger-700

    // Task 6c: surface-400 text darkened to surface-600 on these affix/footer/kbd labels.
    'command-palette footer' => ['#f8fafc', '#475569'],  // surface-50 / surface-600
    'command-palette kbd' => ['#f1f5f9', '#475569'],     // surface-100 / surface-600
    'input affix' => ['#e2e8f0', '#475569'],             // surface-200 / surface-600

    // Task 6c: outline button text darkened one step (600 -> 700).
    'button outline success' => ['#ffffff', '#047857'],  // success-700
    'button outline warning' => ['#ffffff', '#b45309'],  // warning-700

    // Task 6c: Class D gradients, judged by their lightest stop vs white.
    'avatar gradient primary (lightest)' => ['#ffffff', '#4338ca'],
    'avatar gradient success (lightest)' => ['#ffffff', '#047857'],
    'avatar gradient warning (lightest)' => ['#ffffff', '#b45309'],
    'avatar gradient danger (lightest)' => ['#ffffff', '#b91c1c'],
    'avatar gradient info (lightest)' => ['#ffffff', '#0369a1'],
    'avatar gradient purple (lightest)' => ['#ffffff', '#7e22ce'],
    'avatar gradient pink (lightest)' => ['#ffffff', '#be185d'],
    'avatar gradient teal (lightest)' => ['#ffffff', '#0f766e'],
    'avatar gradient orange (lightest)' => ['#ffffff', '#c2410c'],
    'avatar gradient indigo (lightest)' => ['#ffffff', '#4f46e5'],
    'progress gradient secondary (lightest)' => ['#ffffff', '#0e7490'],
    'progress gradient success (lightest)' => ['#ffffff', '#047857'],
    'progress gradient warning (lightest)' => ['#ffffff', '#b45309'],
    'progress gradient danger (lightest)' => ['#ffffff', '#b91c1c'],
    'progress gradient primary default (lightest)' => ['#ffffff', '#4338ca'],
    'button gradient variant (lightest)' => ['#ffffff', '#6d28d9'],

    // Task 6e: calendar.blade.php's event-pill fallback used primary-500 against
    // its own white event text, a marginal pre-existing fail (4.47) the original
    // census table missed. Fixed to primary-600 (unredefined by .dark, so this
    // single value also fixes the dark-mode pairing below).
    'calendar event pill' => ['#4f46e5', '#ffffff'],  // primary-600
]);

it('renders every solid surface at WCAG AA or better', function (string $background, string $text) {
    expect(Contrast::ratio($background, $text))
        ->toBeGreaterThanOrEqual(Contrast::AA_NORMAL);
})->with('solid surfaces');

/**
 * Non-text UI (icon fills, progress-bar tracks): WCAG 2.1 SC 1.4.11 asks for
 * 3:1 against the adjacent colour, not the 4.5:1 that applies to text. Kept
 * as a separate dataset/assertion on purpose -- folding these into the solid
 * surfaces dataset above would silently assert the wrong threshold.
 */
dataset('non-text UI surfaces', [
    // [etichetta, sfondo/adiacente, elemento]
    'fab success fill vs white icon' => ['#047857', '#ffffff'],
    'toasts bar success vs track' => ['#047857', '#f1f5f9'],
    'toasts bar warning vs track' => ['#b45309', '#f1f5f9'],
    'toasts bar info vs track' => ['#0369a1', '#f1f5f9'],
    'progress solid secondary vs track' => ['#0e7490', '#e2e8f0'],
    'progress solid success vs track' => ['#047857', '#e2e8f0'],
    'progress solid warning vs track' => ['#b45309', '#e2e8f0'],
    'empty-state icon tint vs surface-100' => ['#f1f5f9', '#475569'],

    // Task 6e: same -500 -> -700 fix as the "solid surfaces" toggle rows above,
    // but these knobs are icon-only (no text), so they belong to the 3:1 dataset.
    'toggle success knob vs track' => ['#047857', '#ffffff'],   // success-700
    'toggle secondary knob vs track' => ['#0e7490', '#ffffff'], // secondary-700

    // Task 6e ratified fix: fab.blade.php's `secondary` variant (bg-aura-surface-600,
    // icon-only) was not in the original census. Light passes unchanged (7.58); the
    // dark-mode pairing (surface-600 inverts light under `.dark`) is in the dark
    // dataset below, alongside its ratified `dark:text-aura-surface-0` fix.
    'fab secondary fill vs white icon' => ['#475569', '#ffffff'],
]);

it('renders every non-text UI surface at WCAG AA large-text/UI threshold or better', function (string $adjacent, string $element) {
    expect(Contrast::ratio($adjacent, $element))
        ->toBeGreaterThanOrEqual(Contrast::AA_LARGE);
})->with('non-text UI surfaces');

/**
 * Task 6d regression: Task 6c darkened toast/progress bar fills to -700 to win
 * contrast against a LIGHT track. Under `.dark`, dark-mode.css darkens the track
 * too (surface-100 -> #334155, surface-200 -> #475569) and the -700 fill nearly
 * vanished into it (toast success 4.08 -> 1.89, progress warning 3.53 -> 1.51).
 * The fix adds a `dark:bg-aura-<hue>-300` variant to every bar fill. This dataset
 * asserts the resulting DARK-theme pairs against the DARK track colours -- do not
 * confuse it with the light-theme "non-text UI surfaces" dataset above.
 */
dataset('dark non-text UI surfaces', [
    // [etichetta, sfondo/adiacente (dark track), elemento (dark fill, -300)]
    'toasts bar success vs dark track' => ['#334155', '#6ee7b7'],
    'toasts bar danger vs dark track' => ['#334155', '#fca5a5'],
    'toasts bar warning vs dark track' => ['#334155', '#fcd34d'],
    'toasts bar info vs dark track' => ['#334155', '#7dd3fc'],
    'progress solid secondary vs dark track' => ['#475569', '#67e8f9'],
    'progress solid success vs dark track' => ['#475569', '#6ee7b7'],
    'progress solid warning vs dark track' => ['#475569', '#fcd34d'],
    'progress solid danger vs dark track' => ['#475569', '#fca5a5'],
    'progress solid primary default vs dark track' => ['#475569', '#93c5fd'],

    // Task 6e: fab.blade.php's `default`/`danger` icon fills used the bare -500
    // accent, which dark-mode.css redefines *brighter* for the glow effect --
    // exactly wrong against a white icon. Given a `dark:` variant pinned to the
    // unredefined -600 shade.
    'fab default(primary) fill vs white icon dark' => ['#4f46e5', '#ffffff'],  // primary-600
    'fab danger fill vs white icon dark' => ['#dc2626', '#ffffff'],            // danger-600

    // Task 6e: same -500-glows-brighter trap in residual.css's checkbox/radio
    // checkmarks and the toggle "primary"/"danger" knobs. Given a `.dark` rule
    // pinned to the unredefined -600 shade (checkbox/radio keep border-color in
    // sync; see residual.css).
    'checkbox checked vs white check dark' => ['#4f46e5', '#ffffff'],  // primary-600
    'radio checked vs white dot dark' => ['#4f46e5', '#ffffff'],       // primary-600
    'toggle primary knob vs track dark' => ['#4f46e5', '#ffffff'],     // primary-600
    'toggle danger knob vs track dark' => ['#dc2626', '#ffffff'],      // danger-600

    // Task 6e: toggle "success"/"secondary" knobs were fixed to -700 at the base
    // rule (no `dark:` needed -- -700 is unredefined by .dark), so the dark-theme
    // pairing is identical to the light one. Asserted here too so a future
    // `dark:` override that only fixes one theme cannot slip past unnoticed.
    'toggle success knob vs track dark' => ['#047857', '#ffffff'],   // success-700
    'toggle secondary knob vs track dark' => ['#0e7490', '#ffffff'], // secondary-700

    // Task 6e ratified fix: fab.blade.php's `secondary` variant pairs an
    // always-white icon with a `surface-*` background, which INVERTS under
    // `.dark` (surface-600 #475569 light -> #cbd5e1 dark, i.e. light-on-light
    // without a fix). Ratified fix inverts the icon with it: `dark:text-aura-surface-0`.
    // See the light-theme row of the same name in "non-text UI surfaces" above.
    'fab secondary fill vs white icon dark' => ['#cbd5e1', '#0f172a'],
]);

it('renders every dark non-text UI surface at WCAG AA large-text/UI threshold or better', function (string $adjacent, string $element) {
    expect(Contrast::ratio($adjacent, $element))
        ->toBeGreaterThanOrEqual(Contrast::AA_LARGE);
})->with('dark non-text UI surfaces');

/**
 * Task 6e: dark-mode text-on-solid pairs (4.5:1), mirroring the light-theme
 * "solid surfaces" dataset above. dark-mode.css only redefines the `surface`
 * scale (which inverts) and the `-500` accents (which get brighter); every
 * other accent shade keeps its light value, which is the trap several of
 * these rows hit -- an unqualified `text-aura-<hue>-600/700` class rendered
 * fine in light mode and failed once the page background flipped dark.
 */
dataset('dark solid surfaces', [
    // [etichetta, sfondo, testo]

    // button.blade.php solid `warning`: warning-500 glows brighter under .dark
    // (#fbbf24) while the light-mode text (surface-900, which flips light too)
    // collapsed to 1.60. Given its own dark variant: bg warning-700, text white.
    'button warning solid dark' => ['#b45309', '#ffffff'],

    // button.blade.php outline text: bg is the page (surface-0, dark #0f172a);
    // the unqualified `text-aura-<hue>-600/700` class kept its light value and
    // nearly vanished into the dark page. Given a `dark:text-aura-<hue>-400`.
    'button outline primary dark' => ['#0f172a', '#60a5fa'],  // primary-400
    'button outline success dark' => ['#0f172a', '#34d399'],  // success-400
    'button outline warning dark' => ['#0f172a', '#fbbf24'],  // warning-400
    'button outline danger dark' => ['#0f172a', '#f87171'],   // danger-400

    // calendar.blade.php event pill: fixed at the base rule (primary-600,
    // unredefined by .dark), so this pairing is identical to the light row
    // above -- asserted here too per the "both themes" rule.
    'calendar event pill dark' => ['#4f46e5', '#ffffff'],

    // indicator.blade.php ratified fix: badge `secondary` pairs literal white
    // text with a `surface-*` background, which inverts under `.dark`
    // (surface-500 #64748b light -> #94a3b8 dark). Ratified fix inverts the
    // text with it: `dark:text-aura-surface-0` (surface-0 dark = #0f172a).
    'indicator secondary dark' => ['#94a3b8', '#0f172a'],
]);

it('renders every dark solid surface at WCAG AA or better', function (string $background, string $text) {
    expect(Contrast::ratio($background, $text))
        ->toBeGreaterThanOrEqual(Contrast::AA_NORMAL);
})->with('dark solid surfaces');
