# Aura UI — Claude Code Context

## Overview
UI Component Library for Laravel 12 + Livewire 4 + Alpine.js + Tailwind CSS 4.
Package: `bluestarsystem/aura-ui`, Namespace: `BlueStarSystem\AuraUI`.

## Design Language
"Vibrant Depth" — gradients, glow effects, micro-animations, glass morphism.
All theming via CSS custom properties (`--aura-*`).

## Architecture
- Anonymous Blade components: `<x-aura::button>`, `<x-aura::input>`, etc.
- Prefix: `aura` (configurable in `config/aura-ui.php`)
- CSS: `resources/css/aura.css` imports base + utilities + components
- Playground: `/aura/playground` (toggle via config)

## Key Directories
- `resources/views/components/` — 76 Blade component files
- `resources/css/` — Design system CSS (variables, shadows, animations, glass, components)
- `src/Traits/` — 5 Livewire traits (DataTable, Filters, BulkActions, InlineEdit, Form)
- `src/DataTable/` — Column builder, BulkAction builder, 5 Filter classes
- `tests/` — Pest v3 tests

## Commands
```bash
php artisan aura:install          # Publish config + CSS
php vendor/bin/pest               # Run tests (target: 523 passed)
php vendor/bin/pest --parallel    # Parallel test execution
```

## Free/Pro Split (Planned)
- Free (~25 components): primitives, feedback, layout, navigation, basic data
- Pro (~29 components): advanced forms, DataTable + traits, command palette, charts, calendar, kanban
- Pro requires Free as dependency
- Gate via Composer auth (no runtime checks)

## Conventions
- CSS classes: `.aura-{component}-{modifier}` (e.g., `.aura-btn-primary`)
- Dark mode: `.dark` class on parent, all components adapt
- All form inputs support `wire:model`
- Alpine.js for client-side interactivity (no external JS libs except Chart.js/Tiptap)
