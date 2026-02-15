<?php

namespace BlueStarSystem\AuraUI\Traits;

use BlueStarSystem\AuraUI\DataTable\Column;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

trait WithAuraDataTable
{
    use WithPagination;

    public string $search = '';
    public string $sortField = '';
    public string $sortDirection = 'asc';
    public int $perPage = 10;
    public array $visibleColumns = [];

    /**
     * Define the table columns.
     *
     * @return Column[]
     */
    abstract public function columns(): array;

    /**
     * Define the base query.
     */
    abstract public function query(): Builder;

    /**
     * Available per-page options.
     */
    public function perPageOptions(): array
    {
        return [10, 25, 50, 100];
    }

    /**
     * Debounce delay for search (ms).
     */
    public function searchDebounce(): int
    {
        return 300;
    }

    /**
     * Placeholder text for search input.
     */
    public function searchPlaceholder(): string
    {
        return 'Cerca...';
    }

    /**
     * Mount default values.
     */
    public function mountWithAuraDataTable(): void
    {
        if (empty($this->visibleColumns)) {
            $this->visibleColumns = collect($this->columns())
                ->filter(fn (Column $col) => $col->isVisible())
                ->map(fn (Column $col) => $col->getKey())
                ->values()
                ->toArray();
        }

        if (empty($this->sortField)) {
            $firstSortable = collect($this->columns())
                ->first(fn (Column $col) => $col->isSortable());

            if ($firstSortable) {
                $this->sortField = $firstSortable->getSortField();
            }
        }
    }

    /**
     * Reset page when search changes.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset page when per-page changes.
     */
    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    /**
     * Sort by a column.
     */
    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    /**
     * Toggle column visibility.
     */
    public function toggleColumn(string $key): void
    {
        if (in_array($key, $this->visibleColumns)) {
            $this->visibleColumns = array_values(
                array_filter($this->visibleColumns, fn ($k) => $k !== $key)
            );
        } else {
            $this->visibleColumns[] = $key;
        }
    }

    /**
     * Check if a column is visible.
     */
    public function isColumnVisible(string $key): bool
    {
        return in_array($key, $this->visibleColumns);
    }

    /**
     * Get visible Column objects.
     *
     * @return Column[]
     */
    public function getVisibleColumns(): array
    {
        return collect($this->columns())
            ->filter(fn (Column $col) => $col->isActions() || in_array($col->getKey(), $this->visibleColumns))
            ->values()
            ->toArray();
    }

    /**
     * Get toggleable Column objects for column picker.
     *
     * @return Column[]
     */
    public function getToggleableColumns(): array
    {
        return collect($this->columns())
            ->filter(fn (Column $col) => $col->isToggleable())
            ->values()
            ->toArray();
    }

    /**
     * Get searchable column keys.
     */
    public function getSearchableColumns(): array
    {
        return collect($this->columns())
            ->filter(fn (Column $col) => $col->isSearchable())
            ->map(fn (Column $col) => $col->getKey())
            ->values()
            ->toArray();
    }

    /**
     * Build and execute the full query with search, sort, filters, and pagination.
     */
    public function getItems(): LengthAwarePaginator
    {
        $query = $this->query();

        // Apply search
        $query = $this->applySearch($query);

        // Apply filters (from WithAuraFilters if used)
        if (method_exists($this, 'applyFilters')) {
            $query = $this->applyFilters($query);
        }

        // Apply sort
        $query = $this->applySort($query);

        return $query->paginate($this->perPage);
    }

    /**
     * Apply search to query.
     */
    protected function applySearch(Builder $query): Builder
    {
        if (empty($this->search)) {
            return $query;
        }

        $searchable = $this->getSearchableColumns();

        if (empty($searchable)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($searchable) {
            foreach ($searchable as $column) {
                if (str_contains($column, '.')) {
                    // Relationship search: "relation.column"
                    $parts = explode('.', $column, 2);
                    $q->orWhereHas($parts[0], function (Builder $sub) use ($parts) {
                        $sub->where($parts[1], 'like', "%{$this->search}%");
                    });
                } else {
                    $q->orWhere($column, 'like', "%{$this->search}%");
                }
            }
        });
    }

    /**
     * Apply sort to query.
     */
    protected function applySort(Builder $query): Builder
    {
        if (empty($this->sortField)) {
            return $query;
        }

        // Validate sort field against defined columns
        $validSort = collect($this->columns())
            ->first(fn (Column $col) => $col->getSortField() === $this->sortField && $col->isSortable());

        if (! $validSort) {
            return $query;
        }

        $direction = in_array($this->sortDirection, ['asc', 'desc']) ? $this->sortDirection : 'asc';

        return $query->orderBy($this->sortField, $direction);
    }

    /**
     * Reset all table state.
     */
    public function resetTable(): void
    {
        $this->search = '';
        $this->sortField = '';
        $this->sortDirection = 'asc';
        $this->resetPage();

        if (method_exists($this, 'resetFilters')) {
            $this->resetFilters();
        }

        if (method_exists($this, 'deselectAll')) {
            $this->deselectAll();
        }

        $this->mountWithAuraDataTable();
    }

    /**
     * Check if any filters/search are active.
     */
    public function hasActiveFilters(): bool
    {
        if (! empty($this->search)) {
            return true;
        }

        if (method_exists($this, 'hasActiveFilterValues')) {
            return $this->hasActiveFilterValues();
        }

        return false;
    }
}
