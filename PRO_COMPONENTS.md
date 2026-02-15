# Aura UI Pro — Pro Components

Package: `bluestarsystem/aura-ui-pro` (private, Satis)
Requires: `bluestarsystem/aura-ui ^1.0`

## Blade Components (19 components, 31 files)

### Forms (Advanced)
| Component | Files |
|-----------|-------|
| Date Picker | `date-picker.blade.php` |
| Time Picker | `time-picker.blade.php` |
| File Upload | `file-upload.blade.php` |
| Autocomplete | `autocomplete.blade.php` |
| Tags Input | `tags-input.blade.php` |
| Color Picker | `color-picker.blade.php` |
| Slider | `slider.blade.php` |
| OTP Input | `otp-input.blade.php` |
| Editor | `editor.blade.php` |

### Navigation (Advanced)
| Component | Files |
|-----------|-------|
| Tabs | `tabs.blade.php`, `tabs/tab.blade.php` |
| Accordion | `accordion.blade.php`, `accordion/item.blade.php` |
| Steps | `steps.blade.php`, `steps/step.blade.php` |
| Sidebar | `sidebar.blade.php`, `sidebar/brand.blade.php`, `sidebar/section.blade.php`, `sidebar/item.blade.php`, `sidebar/sub-item.blade.php` |

### Interactive
| Component | Files |
|-----------|-------|
| Command Palette | `command-palette.blade.php`, `command-palette/group.blade.php`, `command-palette/item.blade.php` |
| Confirmation Dialog | `confirmation-dialog.blade.php` |
| Toasts | `toasts.blade.php` |

### Visualization
| Component | Files |
|-----------|-------|
| Chart | `chart.blade.php` |
| Calendar | `calendar.blade.php` |
| Kanban | `kanban.blade.php`, `kanban/column.blade.php`, `kanban/card.blade.php` |
| Tree View | `tree.blade.php`, `tree/node.blade.php` |

## CSS (21 component files)
`datatable`, `tabs`, `accordion`, `steps`, `sidebar`,
`date-picker`, `time-picker`, `file-upload`, `autocomplete`, `tags-input`,
`color-picker`, `slider`, `otp-input`, `editor`,
`command-palette`, `confirmation-dialog`, `toasts`,
`chart`, `calendar`, `kanban`, `tree`

## PHP Classes

### DataTable System
- `DataTable/Column.php` — Fluent column builder
- `DataTable/BulkAction.php` — Bulk action builder
- `DataTable/Filters/Filter.php` — Base filter
- `DataTable/Filters/SelectFilter.php`
- `DataTable/Filters/DateRangeFilter.php`
- `DataTable/Filters/BooleanFilter.php`
- `DataTable/Filters/TextFilter.php`

### Livewire Traits
- `Traits/WithAuraDataTable.php` — Search, sort, pagination, column toggle
- `Traits/WithAuraFilters.php` — Advanced filters with query builder
- `Traits/WithAuraBulkActions.php` — Multi-select + actions
- `Traits/WithAuraInlineEdit.php` — Inline cell editing
- `Traits/WithAuraForm.php` — Form builder
