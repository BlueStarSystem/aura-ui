# Changelog

All notable changes to Aura UI will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
