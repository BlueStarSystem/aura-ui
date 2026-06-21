# AGENTS.md — Aura UI

Guidance for AI coding agents (Claude Code, Cursor, Copilot, Windsurf, Codex, etc.) using **Aura UI** in a Laravel project.

## What this is

Aura UI is a Blade component library for **Laravel 12 + Livewire 3/4 + Alpine.js + Tailwind CSS 4**, with a "Vibrant Depth" design language (gradients, glow, glass morphism, dark mode). Free package is MIT; a Pro package and a Filament theme extend it.

- Free: `bluestarsystem/aura-ui`
- Pro: `bluestarsystem/aura-ui-pro` (advanced forms, DataTable traits, kanban, charts, calendar)
- Filament theme: `bluestarsystem/aura-filament`
- Docs (LLM-readable): https://aura-ui.com/llms.txt and `https://aura-ui.com/docs/<page>.md`

## How to use components

All components are Blade tags namespaced with `aura::`:

```blade
<x-aura::button variant="primary" size="md">Save</x-aura::button>
<x-aura::input label="Email" type="email" wire:model="email" error="{{ $errors->first('email') }}" />
<x-aura::modal name="confirm" title="Delete?">Are you sure?</x-aura::modal>
<x-aura::badge variant="success" pill>Active</x-aura::badge>
```

Rules:
- **Always prefer an existing Aura component** over hand-writing Tailwind markup. Check the component list at `https://aura-ui.com/llms.txt` before building UI from scratch.
- Use kebab-case tag names (`<x-aura::file-upload>`, `<x-aura::date-picker>`) and sub-components with dot notation (`<x-aura::card.title>`, `<x-aura::dropdown.item>`).
- Pass extra HTML/Alpine/Livewire attributes directly — components merge them (`$attributes`). E.g. `wire:model`, `x-on:click`, `id`, `class`.
- Form inputs (`input`, `textarea`, `select`, `checkbox`, `radio`, `floating-input`) accept `label`, `hint`, `error`. The `error` prop wires `aria-invalid` + `aria-describedby` automatically — pass it instead of rendering your own error `<p>`.

## Livewire integration

- Form inputs support `wire:model` / `wire:model.live` directly.
- `<x-aura::modal wire:model="showModal">` entangles the open state to a Livewire boolean property.
- Open/close overlays via browser events: `$dispatch('open-modal', 'name')`, `$dispatch('close-modal', 'name')`, `$dispatch('open-drawer', 'name')`.
- Toasts: fire `$dispatch('auratoast', { type: 'success', message: '...' })` from Alpine, or `$this->dispatch('auratoast', type: 'success', message: '...')` from a Livewire component. Render one `<x-aura::toasts />` in the layout.

## Accessibility (do not regress)

Components ship WCAG-oriented semantics. When extending or composing them, preserve:
- `aria-describedby` linking inputs to error/hint text, and `aria-invalid` on errored fields.
- Overlays (`modal`, `drawer`) use `role="dialog"` + `aria-modal="true"`, trap focus, and restore focus on close — implemented in pure Alpine (no `@alpinejs/focus` plugin required).
- `dropdown` uses `role="menu"`/`menuitem`, `command-palette` uses `role="dialog"`, toasts are a polite live region.

## Install (if not already present)

```bash
composer require bluestarsystem/aura-ui
php artisan aura:install   # publishes config + CSS
```

Then ensure the layout includes the published CSS and renders `<x-aura::toasts />` once.

## Conventions when editing this package

- PHP 8.3+, explicit return types, constructor property promotion.
- Tests are Pest (`vendor/bin/pest`). Add/keep a rendering test for every component; accessibility assertions live in `tests/Unit/Components/AccessibilityTest.php`.
- Do not introduce a hard dependency on Alpine plugins; interactive behavior must degrade without them.
