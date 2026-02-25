# Changelog

All notable changes to Aura UI will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
