# Aura UI Pro — Pro Components

Package: `bluestarsystem/aura-ui-pro` (private, distributed through Satis only — never Packagist)
Requires: `bluestarsystem/aura-ui ^3.24.1`, PHP 8.3+, Laravel 12 or 13

**52 Blade components, 3 blocks and 6 Livewire traits**, listed as of 2026-08-23.

Whether a component is free or Pro is answered by
[`/r/registry.json`](https://aura-ui.com/r/registry.json), never by this file: components move
between tiers, and this list was wrong for six months because it was written by hand. The tables
below are generated from `aura-ui-pro/resources/aura-registry.json`:

```bash
jq -r 'to_entries | sort_by(.key)[] | select(.value.type=="component")
  | "| `\(.key)` | \(.value.files | map("`" + . + "`") | join(", ")) |"' resources/aura-registry.json
```

## Blade components (52)

| Component | Files |
|-----------|-------|
| `app-shell` | `app-shell.blade.php` |
| `area-chart` | `area-chart.blade.php` |
| `assistant-message` | `assistant-message.blade.php` |
| `attachment` | `attachment.blade.php` |
| `attachment-group` | `attachment-group.blade.php` |
| `bar-chart` | `bar-chart.blade.php` |
| `carousel` | `carousel.blade.php`, `carousel/slide.blade.php` |
| `chart-mixed` | `chart-mixed.blade.php` |
| `chat-bubble` | `chat-bubble.blade.php` |
| `chat-marker` | `chat-marker.blade.php` |
| `color-picker` | `color-picker.blade.php` |
| `composer` | `composer.blade.php` |
| `confirmation-dialog` | `confirmation-dialog.blade.php` |
| `date-range-picker` | `date-range-picker.blade.php` |
| `date-separator` | `date-separator.blade.php` |
| `dock` | `dock.blade.php`, `dock/item.blade.php` |
| `filter-builder` | `filter-builder.blade.php` |
| `gauge` | `gauge.blade.php` |
| `hover-card` | `hover-card.blade.php` |
| `image-compare` | `image-compare.blade.php` |
| `image-gallery` | `image-gallery.blade.php` |
| `kanban` | `kanban.blade.php`, `kanban/card.blade.php`, `kanban/column.blade.php` |
| `lightbox` | `lightbox.blade.php` |
| `mail-attachment` | `mail-attachment.blade.php` |
| `mail-message` | `mail-message.blade.php` |
| `mail-timeline` | `mail-timeline.blade.php` |
| `map` | `map.blade.php` |
| `message-typing` | `message-typing.blade.php` |
| `otp-input` | `otp-input.blade.php` |
| `pillbox` | `pillbox.blade.php` |
| `reaction` | `reaction.blade.php` |
| `reading-bookmark` | `reading-bookmark.blade.php` |
| `reading-meta` | `reading-meta.blade.php` |
| `reading-minimap` | `reading-minimap.blade.php` |
| `reading-progress` | `reading-progress.blade.php` |
| `reading-shell` | `reading-shell.blade.php` |
| `reading-spine` | `reading-spine.blade.php` |
| `reading-toc` | `reading-toc.blade.php` |
| `replay-button` | `replay-button.blade.php` |
| `resizable` | `resizable.blade.php` |
| `rich-text` | `rich-text.blade.php` |
| `scheduler` | `scheduler.blade.php` |
| `sidebar` | `sidebar.blade.php`, `sidebar/brand.blade.php`, `sidebar/item.blade.php`, `sidebar/section.blade.php`, `sidebar/sub-item.blade.php` |
| `sparkline` | `sparkline.blade.php` |
| `spotlight` | `spotlight.blade.php` |
| `stat-chart` | `stat-chart.blade.php` |
| `steps` | `steps.blade.php`, `steps/step.blade.php` |
| `stream` | `stream.blade.php` |
| `tags-input` | `tags-input.blade.php` |
| `tour` | `tour.blade.php` |
| `tree` | `tree.blade.php`, `tree/node.blade.php` |
| `vat-field` | `vat-field.blade.php` |

## Blocks (3)

Composed page sections, published with `php artisan aura:add <name>`.

| Block | Files |
|-------|-------|
| `dashboard-analytics` | `blocks/dashboard-analytics.blade.php` |
| `data-table-page` | `blocks/data-table-page.blade.php` |
| `settings-form` | `blocks/settings-form.blade.php` |

## PHP classes

### Livewire traits (`src/Traits/`)

| Trait | What it adds |
|-------|--------------|
| `WithAuraDataTable` | Search with debounce, multi-column sorting, per-page options, column visibility |
| `WithAuraFilters` | Declarative filters applied to the query, active-filter count, per-filter reset |
| `WithAuraBulkActions` | Row selection (page / all), authorisation hook, bulk action execution |
| `WithAuraInlineEdit` | Cell-level editing with an authorisation hook per record and column |
| `WithAuraRowDetails` | Expandable detail rows, single- or multi-expand, lazy content on first expand |
| `WithAuraForm` | Form field definitions, dirty tracking against captured values, error and success state |

### DataTable (`src/DataTable/`)

- `Column.php` — fluent column builder
- `BulkAction.php` — bulk action builder
- `Exporters/CsvExporter.php` — CSV export of the current query
- `Filters/Filter.php` — base filter, plus `SelectFilter`, `DateRangeFilter`, `BooleanFilter`, `TextFilter`

## CSS

One stylesheet, `resources/css/aura-pro.css`, imported after the free `aura.css`. Component styles
live in the components themselves; the only residual file is `components/sidebar-residual.css`.
