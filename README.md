# Aura UI

[![Latest Version](https://img.shields.io/packagist/v/bluestarsystem/aura-ui.svg?style=flat-square)](https://packagist.org/packages/bluestarsystem/aura-ui)
[![Downloads](https://img.shields.io/packagist/dt/bluestarsystem/aura-ui.svg?style=flat-square)](https://packagist.org/packages/bluestarsystem/aura-ui)
[![License](https://img.shields.io/packagist/l/bluestarsystem/aura-ui.svg?style=flat-square)](LICENSE)
[![Tests](https://github.com/BlueStarSystem/aura-ui/actions/workflows/tests.yml/badge.svg)](https://github.com/BlueStarSystem/aura-ui/actions/workflows/tests.yml)
[![PHP](https://img.shields.io/badge/php-8.3%2B-8892BF?style=flat-square)]()
[![Laravel](https://img.shields.io/badge/laravel-12%20%7C%2013-FF2D20?style=flat-square)]()
[![Tailwind CSS](https://img.shields.io/badge/tailwind-4-38BDF8?style=flat-square)]()

**"Vibrant Depth" UI component library for Laravel 12/13 + Livewire 3/4 + Alpine.js + Tailwind CSS 4.**

Aura UI ships **127 production-ready Blade components under the MIT licence** — no account, no
licence key, no paid tier required to use them. They share one design system: gradients, glow,
micro-animations, glass morphism and full dark mode. Where most libraries go flat and minimal,
Aura deliberately goes the other way, while staying professional.

**[Browse every component →](https://aura-ui.com/components)** · machine-readable index at
[`/r/registry.json`](https://aura-ui.com/r/registry.json)

Date picker, time picker, file upload, autocomplete, multiselect, calendar, command palette,
QR code, the editor, a Chart.js-backed chart, and European business fields such as the IBAN
field and the currency input — all in the free package.

## Why Aura

- **Breadth, free.** Most libraries put the interesting components behind a licence. Here the
  calendar, the command palette, the date picker and a chart component (line, bar, pie,
  doughnut, area) are MIT.
- **Own the code.** `php artisan aura:add button` copies the component source into your app.
  Keep Aura as a dependency or walk away with the files — your choice, no lock-in.
- **Accessibility is tested, not claimed.** 111 colour pairs are checked against the WCAG
  contrast thresholds in CI, and `php artisan aura:doctor --a11y` runs the same checks against
  *your* Blade templates.
- **Built to be read by AI assistants.** Every docs page is available as raw Markdown by
  appending `.md` to its URL, indexed in [llms.txt](https://aura-ui.com/llms.txt), plus an MCP
  server so your assistant can look up real component APIs instead of inventing them.
- **1,233 tests** in this package (measured 2026-08-09).

## Requirements

- PHP 8.3+
- Laravel 12 or 13
- Tailwind CSS 4

Livewire is optional — the components are anonymous Blade components and work without it.

## Installation

```bash
composer require bluestarsystem/aura-ui
php artisan aura:install
```

Import the CSS in your app:

```css
/* resources/css/app.css */
@import "vendor/aura-ui/aura.css";
```

Publish individually if you prefer:

```bash
php artisan vendor:publish --tag=aura-ui-config
php artisan vendor:publish --tag=aura-ui-css
php artisan vendor:publish --tag=aura-ui-views
```

## Quick Start

```blade
{{-- Button --}}
<x-aura::button variant="primary" size="lg">Save Changes</x-aura::button>

{{-- Input with label and error --}}
<x-aura::input label="Email" type="email" wire:model="email" error="{{ $errors->first('email') }}" />

{{-- Card with header --}}
<x-aura::card shadow="lg">
    <x-slot:header>
        <x-aura::card.title>Dashboard</x-aura::card.title>
    </x-slot:header>
    Your content here.
</x-aura::card>

{{-- Modal --}}
<x-aura::modal name="confirm-delete" max-width="sm">
    <p>Are you sure?</p>
</x-aura::modal>

{{-- Alert --}}
<x-aura::alert variant="success" dismissible>Operation completed.</x-aura::alert>
```

## Components

The full catalogue, with live previews and props for every component, is at
**[aura-ui.com/components](https://aura-ui.com/components)**.

It is deliberately not duplicated here: a list in a README goes stale the moment a component is
added, and this one did — it advertised a third of what was actually in the box.

Each page is also available as Markdown for humans and machines alike, e.g.
[`/docs/components/button.md`](https://aura-ui.com/docs/components/button.md).

## Own the code

```bash
php artisan aura:init                 # prepare the destination and publish the CSS
php artisan aura:add button card      # copy the source into your project
php artisan aura:add table --dry-run  # see what it would write first
```

Copied components are yours: edit them freely, and drop the dependency if you want to.

## Accessibility

```bash
php artisan aura:doctor          # setup and component-usage problems
php artisan aura:doctor --a11y   # plus the accessibility checks, on your own views
```

Components target WCAG 2.1 AA. Contrast is enforced in CI over 111 colour pairs, in light and
dark mode, so a theme change cannot quietly push text below the minimum.

## Design System

Built on CSS custom properties:

- **Colors**: 6 semantic palettes (primary, secondary, success, warning, danger, info) + surface scale
- **Shadows**: 6 elevation levels + coloured glow effects for focus states
- **Animations**: 14 keyframes with spring easing curves
- **Glass morphism**: 3 intensity levels (subtle, standard, strong)
- **Typography**: Inter (sans) + JetBrains Mono (mono)
- **Border radius**: 6-step scale from 6px to 9999px

### Dark Mode

Add `.dark` to `<html>`; colours, shadows and glows adapt on their own.

```html
<html class="dark">
```

### Theming

```css
:root {
    --aura-primary-500: #8b5cf6; /* Change primary to violet */
    --aura-radius-md: 12px;      /* Rounder corners */
}
```

Full guide: [Theming](https://aura-ui.com/docs/theming) · [Dark Mode](https://aura-ui.com/docs/dark-mode).

### Translations

Ships with English and Italian strings; publish `aura-ui-lang` to add your own.

## Playground

Visit `/aura/playground` in your app to browse every component live:

```php
// config/aura-ui.php
'playground' => [
    'enabled' => env('AURA_PLAYGROUND', true),
],
```

## Aura UI Pro

[Aura UI Pro](https://aura-ui.com/pricing) adds **52 components** on top of the free 127, aimed
at admin panels and data-heavy screens:

- **DataTable**: 6 Livewire traits — column builder, filters, bulk actions, inline editing, row details
- **Application shells**: app shell, sidebar, dock, steps wizard, resizable split panes
- **Data-heavy**: kanban board, tree, scheduler, carousel
- **Messaging**: chat bubble, mail message, composer
- **Advanced inputs**: colour picker, date range picker, OTP input, tags input, rich text
  editor, and the VAT / Italian fiscal code field
- **Charts**: area, bar, mixed, gauge, sparkline and stat charts

Building on Filament instead? [Aura Filament](https://aura-ui.com/filament) brings the same
design language to Filament v4/v5 with 8 presets.

Which components are free and which are Pro is always answered by
[`/r/registry.json`](https://aura-ui.com/r/registry.json), never by this file.

## Testing

```bash
composer install
vendor/bin/pest
```

## Links

- [Documentation](https://aura-ui.com) — full docs, live previews, playground
- [All components](https://aura-ui.com/components) · [llms.txt](https://aura-ui.com/llms.txt) for AI assistants
- [Changelog](CHANGELOG.md)

## License

MIT License. See [LICENSE](LICENSE) for details.

## Credits

- [Juri Montico](https://bluestarsystem.it) — BlueStarSystem
