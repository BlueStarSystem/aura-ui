<?php

namespace BlueStarSystem\AuraUI\Traits;

use BlueStarSystem\AuraUI\DataTable\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait WithAuraFilters
{
    public array $filterValues = [];

    /**
     * Define available filters.
     *
     * @return Filter[]
     */
    public function filters(): array
    {
        return [];
    }

    /**
     * Mount default filter values.
     */
    public function mountWithAuraFilters(): void
    {
        foreach ($this->filters() as $filter) {
            if (! isset($this->filterValues[$filter->getKey()])) {
                $this->filterValues[$filter->getKey()] = $filter->getDefaultValue();
            }
        }
    }

    /**
     * Reset page when filters change.
     */
    public function updatedFilterValues(): void
    {
        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    /**
     * Apply all active filters to the query.
     */
    public function applyFilters(Builder $query): Builder
    {
        foreach ($this->filters() as $filter) {
            $value = $this->filterValues[$filter->getKey()] ?? null;

            if (! $filter->isEmpty($value)) {
                $query = $filter->apply($query, $value);
            }
        }

        return $query;
    }

    /**
     * Reset all filter values to defaults.
     */
    public function resetFilters(): void
    {
        $this->filterValues = [];
        $this->mountWithAuraFilters();

        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    /**
     * Reset a single filter.
     */
    public function resetFilter(string $key): void
    {
        $filter = collect($this->filters())->first(fn (Filter $f) => $f->getKey() === $key);

        if ($filter) {
            $this->filterValues[$key] = $filter->getDefaultValue();
        } else {
            unset($this->filterValues[$key]);
        }

        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    /**
     * Check if any filter has an active (non-default) value.
     */
    public function hasActiveFilterValues(): bool
    {
        foreach ($this->filters() as $filter) {
            $value = $this->filterValues[$filter->getKey()] ?? null;

            if (! $filter->isEmpty($value) && $value !== $filter->getDefaultValue()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get count of active filters.
     */
    public function activeFilterCount(): int
    {
        $count = 0;

        foreach ($this->filters() as $filter) {
            $value = $this->filterValues[$filter->getKey()] ?? null;

            if (! $filter->isEmpty($value) && $value !== $filter->getDefaultValue()) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Get filters as array for Blade consumption.
     */
    public function getFiltersArray(): array
    {
        return collect($this->filters())
            ->map(fn (Filter $f) => array_merge($f->toArray(), [
                'value' => $this->filterValues[$f->getKey()] ?? $f->getDefaultValue(),
            ]))
            ->toArray();
    }
}
