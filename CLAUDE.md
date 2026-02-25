# Aura UI — Claude Code Context

## Overview
Free UI Component Library for Laravel 12 + Livewire 4 + Alpine.js + Tailwind CSS 4.
Package: `bluestarsystem/aura-ui`, Namespace: `BlueStarSystem\AuraUI`.

## Architecture
- Anonymous Blade components: `<x-aura::button>`, `<x-aura::input>`, etc.
- Prefix: `aura` (configurable in `config/aura-ui.php`)
- CSS: `resources/css/aura.css` imports base + utilities + 21 component CSS files
- Playground: `/aura/playground` (toggle via config)
- **Free package**: 30 components (primitives, feedback, layout, navigation, data display, typography, form layout)
- **Pro package**: `bluestarsystem/aura-ui-pro` (separate repo, adds 19 components + DataTable + traits)

## Key Directories
- `resources/views/components/` — 46 Blade component files (Free only)
- `resources/css/` — Design system CSS (variables, shadows, animations, glass, 21 component CSS)
- `src/` — ServiceProvider + InstallCommand (no DataTable/Traits — those are in Pro)
- `tests/` — Pest v3 tests (Free components only)

## Commands
```bash
php artisan aura:install          # Publish config + CSS
php vendor/bin/pest               # Run tests
```

## Free/Pro Split
- Free (this package): 30 components — primitives, feedback, layout, navigation, data display, typography, form layout
- Pro (aura-ui-pro): 19 components — advanced forms, tabs/accordion/steps/sidebar, command palette, toasts, charts, calendar, kanban, tree, DataTable system (5 traits, Column, BulkAction, 5 Filters)
- Pro requires Free as dependency
- Both use same `aura` Blade prefix — transparent to the user
- Gate via Composer auth (no runtime checks)

## Conventions
- CSS classes: `.aura-{component}-{modifier}` (e.g., `.aura-btn-primary`)
- Dark mode: `.dark` class on parent, all components adapt
- All form inputs support `wire:model`
- Alpine.js for client-side interactivity
