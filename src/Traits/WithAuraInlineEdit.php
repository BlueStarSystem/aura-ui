<?php

namespace BlueStarSystem\AuraUI\Traits;

trait WithAuraInlineEdit
{
    public ?string $editingCell = null;
    public ?string $editingRow = null;
    public string $editingValue = '';

    /**
     * Start editing a cell.
     */
    public function startEditing(string $rowId, string $column, string $currentValue = ''): void
    {
        $this->editingRow = $rowId;
        $this->editingCell = $column;
        $this->editingValue = $currentValue;
    }

    /**
     * Cancel editing.
     */
    public function cancelEditing(): void
    {
        $this->editingRow = null;
        $this->editingCell = null;
        $this->editingValue = '';
    }

    /**
     * Save the edited cell value.
     * Override this in your component for custom save logic.
     */
    public function saveEditing(): void
    {
        if (! $this->editingRow || ! $this->editingCell) {
            return;
        }

        $this->updateCellValue($this->editingRow, $this->editingCell, $this->editingValue);
        $this->cancelEditing();
    }

    /**
     * Update a cell value in the database.
     * Override this for custom update logic.
     */
    protected function updateCellValue(string $rowId, string $column, mixed $value): void
    {
        if (method_exists($this, 'query')) {
            $model = $this->query()->getModel();
            $record = $model::find($rowId);

            if ($record) {
                $record->update([$column => $value]);
            }
        }
    }

    /**
     * Check if a specific cell is being edited.
     */
    public function isEditing(string $rowId, string $column): bool
    {
        return $this->editingRow === $rowId && $this->editingCell === $column;
    }

    /**
     * Check if any cell is being edited.
     */
    public function isEditingAny(): bool
    {
        return $this->editingRow !== null && $this->editingCell !== null;
    }
}
