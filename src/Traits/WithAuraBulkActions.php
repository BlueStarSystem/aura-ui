<?php

namespace BlueStarSystem\AuraUI\Traits;

use BlueStarSystem\AuraUI\DataTable\BulkAction;

trait WithAuraBulkActions
{
    public array $selected = [];
    public bool $selectAll = false;
    public bool $selectPage = false;

    /**
     * Define available bulk actions.
     *
     * @return BulkAction[]
     */
    public function bulkActions(): array
    {
        return [];
    }

    /**
     * Toggle select all on current page.
     */
    public function updatedSelectPage(bool $value): void
    {
        if ($value) {
            $this->selectPageItems();
        } else {
            $this->selected = [];
            $this->selectAll = false;
        }
    }

    /**
     * Select all items on current page.
     */
    protected function selectPageItems(): void
    {
        if (method_exists($this, 'getItems')) {
            $items = $this->getItems();
            $this->selected = collect($items->items())
                ->pluck($this->getItemKeyName())
                ->map(fn ($id) => (string) $id)
                ->toArray();
        }
    }

    /**
     * Select all items across all pages.
     */
    public function selectAllItems(): void
    {
        $this->selectAll = true;

        if (method_exists($this, 'query')) {
            $this->selected = $this->query()
                ->pluck($this->getItemKeyName())
                ->map(fn ($id) => (string) $id)
                ->toArray();
        }
    }

    /**
     * Deselect all.
     */
    public function deselectAll(): void
    {
        $this->selected = [];
        $this->selectAll = false;
        $this->selectPage = false;
    }

    /**
     * Toggle single item selection.
     */
    public function toggleSelection(string $id): void
    {
        if (in_array($id, $this->selected)) {
            $this->selected = array_values(array_filter($this->selected, fn ($s) => $s !== $id));
            $this->selectAll = false;
            $this->selectPage = false;
        } else {
            $this->selected[] = $id;
        }
    }

    /**
     * Check if an item is selected.
     */
    public function isSelected(string $id): bool
    {
        return in_array($id, $this->selected);
    }

    /**
     * Get count of selected items.
     */
    public function selectedCount(): int
    {
        return count($this->selected);
    }

    /**
     * Has any selection.
     */
    public function hasSelection(): bool
    {
        return ! empty($this->selected);
    }

    /**
     * Execute a bulk action by key.
     */
    public function executeBulkAction(string $actionKey): void
    {
        $action = collect($this->bulkActions())
            ->first(fn (BulkAction $a) => $a->getKey() === $actionKey);

        if (! $action || empty($this->selected)) {
            return;
        }

        $action->execute($this->selected);

        if ($action->shouldDeselectAfter()) {
            $this->deselectAll();
        }
    }

    /**
     * Get the primary key name for items.
     */
    protected function getItemKeyName(): string
    {
        return 'id';
    }

    /**
     * Get bulk actions as array for Blade.
     */
    public function getBulkActionsArray(): array
    {
        return collect($this->bulkActions())
            ->map(fn (BulkAction $a) => $a->toArray())
            ->toArray();
    }
}
