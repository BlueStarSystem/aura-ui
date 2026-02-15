# Aura UI

**"Vibrant Depth" UI component library for Laravel 12 + Livewire 4 + Alpine.js + Tailwind CSS 4.**

Aura UI provides 26 production-ready Blade components with a cohesive design system featuring gradients, glow effects, micro-animations, glass morphism, and full dark mode support.

**Looking for advanced components?** Check out [Aura UI Pro](https://aura-ui.com) for DataTable, charts, calendar, kanban, advanced forms, and more.

## Requirements

- PHP 8.3+
- Laravel 12
- Tailwind CSS 4

## Installation

```bash
composer require bluestarsystem/aura-ui
```

Publish config and CSS:

```bash
php artisan aura:install
```

Or publish individually:

```bash
# Config only
php artisan vendor:publish --tag=aura-ui-config

# CSS only
php artisan vendor:publish --tag=aura-ui-css

# Views (for customization)
php artisan vendor:publish --tag=aura-ui-views
```

Import the CSS in your app:

```css
/* resources/css/app.css */
@import "vendor/aura-ui/aura.css";
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

### Primitives
| Component | Usage | Description |
|-----------|-------|-------------|
| Button | `<x-aura::button>` | 6 variants, 5 sizes, outline, gradient, loading state |
| Input | `<x-aura::input>` | Label, hint, error, prefix/suffix, clearable |
| Textarea | `<x-aura::textarea>` | Auto-resize, character count |
| Select | `<x-aura::select>` | Native select with custom styling |
| Checkbox | `<x-aura::checkbox>` | Animated check, label, description |
| Radio | `<x-aura::radio>` | Grouped via `<x-aura::radio-group>` |
| Toggle | `<x-aura::toggle>` | Switch with sizes and colors |
| Icon | `<x-aura::icon>` | Heroicons integration |

### Feedback
| Component | Usage | Description |
|-----------|-------|-------------|
| Badge | `<x-aura::badge>` | 6 variants, dot, outline, pill, removable |
| Alert | `<x-aura::alert>` | 4 variants, dismissible, icon, title |
| Spinner | `<x-aura::spinner>` | Border and gradient styles, 3 sizes |
| Skeleton | `<x-aura::skeleton>` | Text, title, circle, avatar, button, image |
| Progress | `<x-aura::progress>` | 5 colors, striped, animated, label |

### Layout
| Component | Usage | Description |
|-----------|-------|-------------|
| Card | `<x-aura::card>` | Header/body/footer slots, glass, hover |
| Modal | `<x-aura::modal>` | Overlay, slide-over, glass, sizes |
| Dropdown | `<x-aura::dropdown>` | Items, separators, keyboard nav |
| Tooltip | `<x-aura::tooltip>` | Positions, delay |
| Avatar | `<x-aura::avatar>` | Sizes, status, initials, group |

### Navigation
| Component | Usage | Description |
|-----------|-------|-------------|
| Breadcrumbs | `<x-aura::breadcrumbs>` | Items array, responsive |
| Pagination | `<x-aura::pagination>` | Laravel paginator, per-page |

### Data Display
| Component | Usage | Description |
|-----------|-------|-------------|
| Empty State | `<x-aura::empty-state>` | Icon, title, description, actions |
| Stats Card | `<x-aura::stats-card>` | Value, change, icon |
| Description List | `<x-aura::description-list>` | Label/value pairs |

### Form Layout
| Component | Usage | Description |
|-----------|-------|-------------|
| Form | `<x-aura::form>` | Sections, grid, actions |

## Aura UI Pro

Unlock 19 additional components and a powerful DataTable system with [Aura UI Pro](https://aura-ui.com):

- **Advanced Forms**: Date picker, time picker, file upload, autocomplete, tags input, color picker, slider, OTP input, rich text editor
- **Navigation**: Tabs, accordion, steps wizard, sidebar
- **Interactive**: Command palette (Cmd+K), confirmation dialog, toast notifications
- **Visualization**: Charts (Chart.js), calendar, kanban board, tree view
- **DataTable**: 5 Livewire traits, column builder, bulk actions, filters, inline editing

## Design System

Aura UI's "Vibrant Depth" design system is built on CSS custom properties:

- **Colors**: 6 semantic palettes (primary, secondary, success, warning, danger, info) + surface scale
- **Shadows**: 6 elevation levels + colored glow effects for focus states
- **Animations**: 14 keyframes with spring easing curves
- **Glass morphism**: 3 intensity levels (subtle, standard, strong)
- **Typography**: Inter (sans) + JetBrains Mono (mono)
- **Border radius**: 6-step scale from 6px to 9999px

### Dark Mode

All components support dark mode via the `.dark` class on `<html>`:

```html
<html class="dark">
```

Colors, shadows, and glows automatically adapt.

### Customization

Override CSS custom properties to theme Aura UI:

```css
:root {
    --aura-primary-500: #8b5cf6; /* Change primary to violet */
    --aura-radius-md: 12px;      /* Rounder corners */
}
```

## Playground

Visit `/aura/playground` in your app to see all components live. Toggle in config:

```php
// config/aura-ui.php
'playground' => [
    'enabled' => env('AURA_PLAYGROUND', true),
],
```

## Testing

```bash
cd packages/bluestarsystem/aura-ui
php vendor/bin/pest
```

## License

MIT License. See [LICENSE](LICENSE) for details.

## Credits

- [Juri Montico](https://bluestarsystem.it) — BlueStarSystem
