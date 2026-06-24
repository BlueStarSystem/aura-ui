# Changelog

All notable changes to Aura UI will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
