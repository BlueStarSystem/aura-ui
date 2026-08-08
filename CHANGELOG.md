# Changelog

All notable changes to Aura UI will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

Nothing yet.

## [3.26.0] - 2026-08-07

### Added
- `Support\VatNumber` and `Support\FiscalCode`: the European VAT check digit and the Italian
  fiscal code check letter, computed offline. They moved here from the Pro package so the
  Filament theme can use them without a second licence — the arithmetic is free, the fields that
  use it are not. The Pro classes still work and delegate here.

## [3.25.0] - 2026-08-07

### Added
- `button-group`, `combobox`, `menubar` and `qr-code`. The combobox carries the ARIA pattern in
  full: `aria-activedescendant`, and options that are options rather than buttons, so arrowing
  through the list is announced and Tab does not walk into the popup.
- `currency-input`, `phone-input`, `iban-field` and `signature-pad` — the fields a European form
  needs. Each posts a machine value rather than its own formatting, which is how `1.234,56`
  becomes `1.234` on the server and a thousand euro leave an invoice. The IBAN carries the
  ISO 13616 checksum and a matching `Rules\Iban` validation rule.
- The signature pad offers typing your name beside the canvas. Drawing a curve has no keyboard
  equivalent, so a canvas on its own is a WCAG 2.1.1 failure at Level A.

### Fixed
- `autocomplete` rendered its label without a `for` and its input without an `id`: the field's
  only accessible name was its placeholder, which disappears on the first keystroke. Its options
  were `<button role="option">`, which Tab walked into, and nothing announced the highlight.

## [3.24.1] - 2026-08-07

### Fixed
- `date-picker`, `time-picker` and `autocomplete` rendered as bare text: no border, no
  background, 20 pixels tall. They reused the `.aura-input` class name, which carries no CSS —
  every visible property of a field came from utilities written inside the input component.
  `Support\InputStyle` is now the one place that knows what a field looks like.
- The slider's pointer target was as tall as the line it draws — six pixels. The track stays 6px;
  the box you can hit is now 24, which is what WCAG 2.5.8 asks for.
- The fields that hold chips (`tags`, `multiselect`) were 20 pixels tall, and clicking the
  padding around them did nothing.

## [3.24.0] - 2026-08-06

### Added
- Display, marketing, layout and navigation components: `image`, `price`, `usage-meter`,
  `toggle-button`, `activity-row`, `action-bar`, `ticker`, `reveal`, `status-tiles` and the rest
  of the fourth breadth batch.

### Fixed
- `price` and `ticker` wrote numbers in Italian format for every reader. Both now follow the
  locale, so an American sees `1,234.50` and not `1.234,50`.

## [3.23.0] - 2026-08-06

### Added
- Add the seven primitives the catalogue was missing

## [3.22.2] - 2026-08-06

### Fixed
- Pick chip ink the browser can actually resolve, and follow the theme
- Stop the dark overrides undoing the inverted scale
- Make the collapsible trigger reachable from the keyboard
- Raise the muted text and success shades above 4.5:1

## [3.22.1] - 2026-08-06

### Fixed
- Give the critical controls an accessible name and a valid role

## [3.22.0] - 2026-08-06

### Added
- Let the command palette open without a keyboard

## [3.21.0] - 2026-08-06

### Added
- Close the remaining WCAG 2.2 gaps and three notification-centre defects

## [3.20.0] - 2026-08-06

### Added
- Derive a field id from wire:model before falling back to a random one

## [3.19.1] - 2026-08-06

### Fixed
- Let a colour through the CSS value guard

## [3.19.0] - 2026-08-06

### Added
- Add label, number-input, password-input and a two-handle range slider

## [3.18.4] - 2026-08-06

### Fixed
- Stop a value breaking out of the JavaScript string in an Alpine attribute

## [3.18.3] - 2026-08-06

### Fixed
- Guard the five older components that interpolate a prop into style

## [3.18.2] - 2026-08-06

### Fixed
- Connect a field's error message to the field, for a screen reader too

## [3.18.1] - 2026-08-06

### Fixed
- Stop link and the layout primitives passing through what Blade does not escape

## [3.18.0] - 2026-08-06

### Added
- Add fourteen layout, accessibility and typography primitives

## [3.17.0] - 2026-08-05

### Added
- Ship a standalone aura binary so a project needs no Aura dependency

## [3.16.4] - 2026-08-05

### Fixed
- Align the fab with the corrected button shades

## [3.16.3] - 2026-08-05

### Fixed
- Stop aura:doctor --a11y reporting the field pattern it recommends

## [3.16.2] - 2026-08-05

### Fixed
- Extend accent palettes to 900, fix flattened button hovers, add render-backed contrast test

## [3.16.1] - 2026-08-05

### Fixed
- Stop the base border color from neutralising variant borders, restore keyframes @layer wrapping

## [3.16.0] - 2026-08-04

### Added
- Make isIdentChar() non-ASCII-aware per the CSS Syntax spec
- Flush trailing declarations, gate nested overrides, fix url() boundary
- Extract theme declarations inside the scan, closing the regex seam
- Enforce the theme-scanner unreadable invariant, not just the three inputs
- Make theme-colour scanning quote/comment-aware and crash-proof aura:doctor
- Harden theme-colour parsing and contrast reads in aura:doctor --a11y
- Check the app's own theme colours for WCAG AA in aura:doctor --a11y
- Recognize wrapping <label> as satisfying aura:doctor --a11y field labels
- Fix three false positives in aura:doctor --a11y
- Add accessibility checks to aura:doctor behind --a11y

## [3.15.5] - 2026-08-04

### Fixed
- Fix editor.blade.php's missed resting border and hover-fade regressions
- Close outline-button resting border contrast gap (WCAG AA 3:1)
- Close remaining WCAG AA gaps -- form-control resting borders and toggle track boundary

## [3.15.4] - 2026-08-04

### Fixed
- WCAG AA dark-mode contrast on button, calendar, fab, indicator, checkbox/radio/toggle

## [3.15.3] - 2026-08-04

### Fixed
- Restore dark-mode visibility of toast and progress bars

## [3.15.2] - 2026-08-04

### Changed
- Maintenance release.

## [3.15.1] - 2026-08-04

### Fixed
- WCAG AA contrast on alert, affix/footer text, and free-package Class C/D surfaces
- Meet WCAG AA contrast on solid component surfaces
- Compute WCAG contrast from relative luminance, not OKLCH lightness

## [3.15.0] - 2026-08-03

### Added
- Add aura:doctor to catch silent setup and usage mistakes

## [3.16.5] - 2026-08-04

The form-control contrast work. Released across 3.16.0-3.16.5; the entries
below describe it as one change because that is how it is used.

### Fixed
- **Form controls had a resting boundary too faint to perceive (WCAG 2.1 SC 1.4.11, 3:1).**
  The idle border of `input`, `select`, `textarea`, `checkbox`, `radio`, `multiselect`, `tags`,
  `otp`, `floating-input`, `file-upload`'s dropzone, `pagination`'s per-page `<select>`,
  `date-picker`'s hour/minute fields, and `editor`'s outer boundary used `surface-200` or
  `surface-300` (1.48:1 or worse against a white page -- `editor` was the worst at 1.23:1).
  Moved to `surface-500`, the first shade that clears 3:1 in both light (4.76:1) and dark mode
  (6.96:1) without a `dark:` variant. **User-visible effect: every form field's outline is now
  noticeably darker/greyer at rest, not just on hover or focus.** Hover-only borders and
  non-form-control borders (cards, tabs, `kbd`) were left unchanged.
- **Hovering an idle field used to make its border fade, not darken.** Fixing the resting
  borders above (to `surface-500`) left several `hover:` borders unchanged and lighter than the
  new rest -- backwards. `input`, `select`, `textarea`, and `button`'s outline `secondary`
  variant now hover to `surface-600` (single class, self-inverts in dark mode, no `dark:`
  needed). The outline `success`/`warning` buttons and the checkbox/radio hover ring needed a
  theme-aware split instead: accent colours get *less* visible against a dark page as they get
  darker (the opposite of the surface scale), so a naive "one step darker" would have fixed
  light mode and broken dark mode. Both now hover to a darker shade in light and keep their
  original, already-correct brighter shade in dark via an explicit `dark:hover:` override.
  **User-visible effect: hovering any of these controls now visibly darkens the border, as
  before this task started, in both themes.**
- **`button`'s outline variants had the same problem.** An outline button has no fill, so its
  border is its entire boundary -- all five resting borders failed 3:1 (`-300` shades, 1.44:1
  to 1.90:1 against a white page). `primary`, `secondary`, and `danger` now use their `-500`
  shade (4.47:1 / 4.76:1 / 3.76:1); `success` and `warning` needed `-600` instead, since their
  `-500` still fails (2.54:1 / 3.53:1) -- `success-600` and `warning-600` clear at 3.77:1 and
  3.19:1. All five also clear in dark mode without a `dark:` variant. **User-visible effect:
  outline button borders are now visibly darker/more saturated at rest.**
- **The toggle's OFF track had no visible boundary at all** (a `surface-300` fill only, 1.48:1
  against a white page — its extent wasn't perceivable). Added a `surface-500` border to the
  track and compensated the knob's inset (`top-0.5`/`left-0.5` → `top-px`/`left-px`) so the new
  1px border doesn't shift the knob off-centre at any size (`sm`/`md`/`lg`). Geometry (outer
  track dimensions, knob travel distance) is unchanged; only a thin ring is now visible around
  the track.
- **Toast and progress bars were nearly invisible in dark mode (regression in v3.15.1/v3.15.2).**
  The previous release darkened the `toasts` progress bar and the `progress` component's solid
  and gradient fills to shade 700 (leaving `danger` at 500) so they would clear 3:1 contrast
  against their track *in light mode*. It did not account for how dark mode works in this
  library: `dark-mode.css` redefines the surface tokens inside `.dark`, so the same tracks also
  darken there (toast track `surface-100` -> `#334155`, progress track `surface-200` ->
  `#475569`), and the fixed `-700`/`-500` fill collapsed into the darkened track (e.g. toast
  `success` fell from 4.08:1 to 1.89:1, progress `warning` from 3.53:1 to 1.51:1). Fixed by
  giving every bar fill a `dark:bg-aura-<hue>-300` (and, for the gradient arm, `dark:from-`/
  `dark:to-aura-<hue>-300`) variant, verified at 3.99:1–7.18:1 against both dark tracks. The
  light-mode shade 700/500 fix from the previous release is unchanged; only a dark variant was
  added.
- Solid-background components now meet WCAG 2.1 AA contrast for white text: `primary` moves
  from shade 500 to 600, `success` to 700 and `danger` to 600 (at 500 they rendered white text
  at 4.47:1, 2.54:1 and 3.76:1 against the required 4.5:1). This affects the `button` solid
  variants, all six `indicator` colour variants (`primary`, `success`, `warning`, `info`,
  `secondary`, and the default danger), the `badge` `secondary` variant's light-mode text
  colour, the `calendar` today marker, the `date-picker` selected-day state and the active
  `pagination` page. The palette itself is unchanged; `warning` on `button` stays at 500
  because it uses dark text, and outline/ghost/link variants and `dark:` classes are
  unaffected.
- **`alert`'s light-mode text colour was not applied at all.** The `info`/`success`/`warning`/
  `danger` variants referenced `text-aura-{variant}-800`, a shade that does not exist in the
  palette (those hues stop at 700); Tailwind 4 silently emits no utility for an undefined
  token, so the text rendered in whatever colour it inherited instead. Changed to the existing
  `-700` shade, which also clears WCAG 2.1 AA (4.84:1–5.91:1 against each variant's `-50`
  background). Dark-mode classes were already correct and untouched.
- More solid surfaces darkened to reach 4.5:1 (text) or 3:1 (non-text UI/icon) against their
  background: `command-palette`'s footer and `kbd` hint text, `input`'s prefix/suffix affix
  text, the outline `button`'s `success`/`warning` text, the `success` `fab`, the `success`/
  `warning`/`info` bars in `toasts`, the `secondary`/`success`/`warning` solid and gradient
  bars in `progress`, and the icon tint in `empty-state` — all moved from shade 400/500/600 to
  600/700 as appropriate. `danger` variants that already passed were left alone.
- The `avatar` gradient colour variants (`residual.css`) and the `button` `gradient` prop
  variant were shifted two steps darker (e.g. 500→700/600→800) so their lightest stop clears
  4.5:1 against white, while staying gradients rather than flattening to a solid fill.
- **Dark-mode-only contrast failures**, found by re-checking the whole Class A/C set against
  `.dark`'s overrides (which invert the `surface` scale and brighten the `-500` accents, but
  leave every other accent shade at its light value). Fixed with either a `dark:` variant or,
  where the target shade is unredefined by `.dark`, a single base-rule change that fixes both
  themes at once: `button`'s solid `warning` and outline `primary`/`success`/`warning`/`danger`
  text; `calendar`'s default event-pill colour (also a marginal pre-existing light-mode fail,
  4.47:1, missed by the original census); `fab`'s `default`/`primary` and `danger` icon fills;
  the checked `checkbox`/`radio` fill and the `primary`/`danger` `toggle` knobs (`residual.css`);
  and the `success`/`secondary` `toggle` knobs (base-rule fix, both themes). Also fixed, per a
  controller decision covering two cases a shade swap cannot solve: `indicator`'s `secondary`
  badge and `fab`'s `secondary` button both pair invariant white text/icon with a `surface-*`
  background, which inverts under `.dark` by design; rather than pin a literal colour, the
  foreground now inverts with it via `dark:text-aura-surface-0`.

### Note
- This pass covers the free package's Class A/C/D contrast defects found in the 2026-08-04
  census, in both light and dark mode. Unchecked form-control borders and several
  runtime-coloured cases (`calendar`/`avatar` arbitrary colours, `dock`'s undefined RGB
  fallbacks) remain unverified; the library is not claimed fully WCAG AA compliant.

## [3.14.0] - 2026-07-02

### Added
- **Component labels are now translatable (i18n).** Hardcoded English UI strings across ~18 components (close, clear, remove, previous/next, pagination, loading, no options, toggle navigation, notifications, date-picker navigation, file-upload prompt, time-picker filter, rating) now resolve via the publishable `aura-ui::` translation namespace — English and Italian ship out of the box. Publish/customise with `php artisan vendor:publish --tag=aura-ui-lang`. (Calendar month/day names keep the existing `locale` prop.)

### Fixed
- The pagination navigation `aria-label` was hardcoded in Italian ("Navigazione pagine"); it now follows the application locale (English by default, Italian when the locale is `it`).

## [3.13.0] - 2026-06-23

### Added
- `aura:add` installs components from a **remote registry URL** (`php artisan aura:add https://host/r/<name>.json`) with HTTPS-only fetch, host allowlist + confirmation, schema validation and path sanitisation. aura-ui.com serves the installable shape at `/r/{name}.json`.

## [3.12.0] - 2026-06-22

### Added
- Free **Blocks** in the component registry (`type` field in `aura-registry.json`) — full-page sections installable via `aura:add`.

## [3.11.0] - 2026-06-22

### Added
- OKLCH **PaletteGenerator** (`fromHex`) powering Theme Studio, coherent with the Aura Filament palette.

## [3.10.0] - 2026-06-22

### Added
- **`aura:add` / `aura:init` own-the-code CLI** — copy a component's Blade source into your project (resolves dependencies, rewrites the namespace).

## [3.9.2] - 2026-06-22

### Fixed
- Hardened developer-controlled props interpolated into JS contexts (`Js::from` / casts) across components.

## [3.9.1] - 2026-06-22

### Fixed
- Hardened `wire:model` entangle (`Js::from`) and slider numeric props across components.

## [3.9.0] - 2026-06-22

### Added
- `<x-aura::multiselect>`, `<x-aura::tags>`, `<x-aura::otp>` and `<x-aura::slider>` (slider relocated from Pro to Free).
- `<x-aura::button>` `prefixIcon` / `suffixIcon` (preferred over the deprecated `icon` / `iconRight` aliases).

## [3.8.0] - 2026-06-21

### Added
- WCAG accessibility pass across components; `wire:model` works out of the box on the modal.

## [3.7.0] - 2026-04-26

### Added
- Laravel 13 compatibility (`illuminate/* ^12 || ^13`).

## [3.6.0] - 2026-04-17

### Added
- **Floating Label Input** component (Material Design animation).

## [3.5.0] - 2026-04-16

### Added
- **Notification Center** component with dropdown and badges.

## [3.4.0] - 2026-03-16

### Added
- Heroicon → Lucide icon name fallback mapping.

## [3.3.2] - 2026-03-03

### Added
- Component improvements: validation, accessibility, form handling.

## [3.3.1] - 2026-03-03

### Fixed
- Docs visual fixes: editor array toolbar, calendar i18n, swap grid overlay, toast events, animations.

## [3.2.0] - 2026-02-25

### Added
- **Drawer** component — slide-out panel from any edge with overlay, sizes, and footer slot
- **Timeline** component with item sub-component — vertical timeline with colored dots, icons, and dates
- **Rating** component — interactive star rating with hover, click, readonly mode, and color variants
- **Kbd** component — keyboard key display with mono font and sizes
- **Collapsible** component — show/hide content with trigger slot and Alpine.js transitions
- **Radial Progress** component — SVG circular progress with value, sizes, colors, and custom labels
- **Indicator** component — badge overlay for notification dots, counts, and ping animation
- **List** component with item sub-component — styled lists with divided, bordered, and icon support
- **Countdown** component — Alpine.js countdown timer with days/hours/min/sec display
- **Diff** component — side-by-side or stacked before/after comparison
- **Swap** component — Alpine.js toggle between two states with rotate/flip effects
- **FAB** component — floating action button with expandable actions menu

### Changed
- Free component count: 30 → 44 (14 new components)
- Test count: 450 → 555+ (105 new tests)

## [3.1.0] - 2026-02-25

### Added
- **Table** component with composable sub-components (head, body, row, header, cell) — striped, hoverable, bordered, compact variants
- **Container** component — max-width centered wrapper with responsive padding (sm/md/lg/xl/full)
- **Layout** component — flex wrapper for main + aside arrangement
- **Main** component — semantic `<main>` content area
- **Aside** component — sidebar with configurable width (sm/md/lg) and sticky option
- **Subheading** component — secondary descriptive text with size and tag props
- Table CSS styles in residual.css (striped, hoverable, bordered, compact + dark mode)

### Changed
- Free component count: 26 → 30 (4 new logical components + Table sub-components)
- Test count: 389 → 450 (42 new tests, 84 new assertions)

## [2.1.1] - 2026-02-22

### Added
- Publishable JS vendor assets (Alpine.js, Chart.js) via `aura-ui-assets` tag
- CDN fallback in playground when self-hosted JS files are unavailable

### Fixed
- Playground now loads Alpine.js and Chart.js reliably with local-first + CDN fallback

## [2.1.0] - 2026-02-17

### Fixed
- Livewire 4 compatibility (support `^3.6 || ^4.0`)
- Alpine.js 3 migration updates
- Internationalization: all strings now in English, locale prop available where needed
- Additional Tailwind CSS 4 refinements

## [2.0.0] - 2026-02-16

### Changed
- **BREAKING**: Tailwind CSS 4 is now required (uses `@theme` tokens and `@custom-variant`)
- Minimum Tailwind version bumped from v3 to v4

## [1.1.1] - 2026-02-16

### Fixed
- Added `@custom-variant dark` for class-based dark mode support in Tailwind CSS 4

## [1.1.0] - 2026-02-16

### Changed
- Migrated all 26 components and CSS to Tailwind CSS 4
- CSS now uses `@theme` tokens instead of legacy CSS custom properties
- Component styles updated for Tailwind 4 compatibility

## [1.0.2] - 2026-02-16

### Fixed
- Changed overflow from hidden to visible on card and avatar containers

## [1.0.1] - 2026-02-15

### Fixed
- Aligned modal CSS class names with Blade template
- Aligned checkbox and radio Blade templates with CSS class names

## [1.0.0] - 2026-02-15

### Changed
- Split into Free/Pro packages
- Free package now contains 26 components (primitives, feedback, layout, navigation, data display, form layout)
- Pro components moved to `bluestarsystem/aura-ui-pro` package

### Removed
- DataTable system (moved to Pro)
- Livewire traits (moved to Pro)
- Advanced form components (moved to Pro)
- Navigation components: tabs, accordion, steps, sidebar (moved to Pro)
- Interactive components: command palette, confirmation dialog, toasts (moved to Pro)
- Visualization components: chart, calendar, kanban, tree (moved to Pro)

## [0.1.2] - 2026-02-15

### Added
- Avatar auto-initials and color variants generated from name

## [0.1.1] - 2026-02-15

### Fixed
- Resolved CSS variable naming inconsistencies
- Fixed pagination alignment issues
- Fixed button alignment issues

## [0.1.0] - 2026-02-15

### Added
- Initial release of Aura UI component library
- "Vibrant Depth" design system with CSS custom properties
- 54 Blade components across 4 phases
- Dark mode support via `.dark` class
- Glass morphism utilities
- Multi-layered shadow system with glow effects
- 14 keyframe animations with spring easing
- DataTable with 5 Livewire traits
- Column builder with fluent API
- 5 filter types (Select, Text, Boolean, DateRange, base)
- Interactive playground at `/aura/playground`
- `php artisan aura:install` command
- Publishable config and CSS assets
- 523 tests
