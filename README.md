# Aura UI

**"Vibrant Depth" UI component library for Laravel 12 + Livewire 4 + Alpine.js + Tailwind CSS 4.**

Aura UI provides 54 production-ready Blade components with a cohesive design system featuring gradients, glow effects, micro-animations, glass morphism, and full dark mode support.

## Requirements

- PHP 8.3+
- Laravel 12
- Livewire 3.6+ (for DataTable traits)
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
| Tabs | `<x-aura::tabs>` | Default, pills, bordered, vertical |
| Accordion | `<x-aura::accordion>` | Multiple mode, bordered |
| Steps | `<x-aura::steps>` | Horizontal/vertical, sizes |
| Sidebar | `<x-aura::sidebar>` | Collapsible, brand, sections, items |

### Data Display
| Component | Usage | Description |
|-----------|-------|-------------|
| Empty State | `<x-aura::empty-state>` | Icon, title, description, actions |
| Stats Card | `<x-aura::stats-card>` | Value, change, icon |
| Description List | `<x-aura::description-list>` | Label/value pairs |

### Forms (Advanced)
| Component | Usage | Description |
|-----------|-------|-------------|
| Date Picker | `<x-aura::date-picker>` | Date/datetime, range, locale |
| Time Picker | `<x-aura::time-picker>` | Time selection, step |
| File Upload | `<x-aura::file-upload>` | Drag-drop, preview, progress |
| Autocomplete | `<x-aura::autocomplete>` | Search, multiple, create new |
| Tags Input | `<x-aura::tags-input>` | Suggestions, max, removable |
| Color Picker | `<x-aura::color-picker>` | Hex/RGB, swatches |
| Slider | `<x-aura::slider>` | Min/max, step, range mode |
| OTP Input | `<x-aura::otp-input>` | Fixed length, auto-focus |
| Editor | `<x-aura::editor>` | Rich text, customizable toolbar |
| Form Layout | `<x-aura::form>` | Sections, grid, actions |

### Interactive
| Component | Usage | Description |
|-----------|-------|-------------|
| Command Palette | `<x-aura::command-palette>` | Cmd+K, groups, fuzzy search |
| Confirmation Dialog | `<x-aura::confirmation-dialog>` | Title, confirm/cancel |
| Toasts | `<x-aura::toasts>` | 6 positions, auto-dismiss |

### Visualization
| Component | Usage | Description |
|-----------|-------|-------------|
| Chart | `<x-aura::chart>` | Chart.js wrapper, 6 types |
| Calendar | `<x-aura::calendar>` | Month/week/day, events |
| Kanban | `<x-aura::kanban>` | Columns, cards, drag-drop |
| Tree View | `<x-aura::tree>` | Nested items, selectable |

## DataTable (Livewire)

Aura UI includes a powerful DataTable system with 5 Livewire traits:

```php
use BlueStarSystem\AuraUI\Traits\WithAuraDataTable;
use BlueStarSystem\AuraUI\Traits\WithAuraFilters;
use BlueStarSystem\AuraUI\Traits\WithAuraBulkActions;
use BlueStarSystem\AuraUI\DataTable\Column;

class UserList extends Component
{
    use WithAuraDataTable, WithAuraFilters, WithAuraBulkActions;

    public function columns(): array
    {
        return [
            Column::make('name', 'Name')->sortable()->searchable(),
            Column::make('email', 'Email')->searchable(),
            Column::make('created_at', 'Joined')->date('M d, Y')->sortable(),
            Column::make('status', 'Status')
                ->filterable(['active' => 'Active', 'inactive' => 'Inactive']),
        ];
    }

    public function query(): Builder
    {
        return User::query();
    }
}
```

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
