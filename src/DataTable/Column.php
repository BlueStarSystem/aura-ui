<?php

namespace BlueStarSystem\AuraUI\DataTable;

use Closure;

class Column
{
    protected string $key;
    protected string $label;
    protected bool $isSortable = false;
    protected bool $isSearchable = false;
    protected bool $isInlineEditable = false;
    protected bool $isToggleable = true;
    protected bool $isVisible = true;
    protected string|null $dateFormat = null;
    protected string|null $numberFormat = null;
    protected string $align = 'left';
    protected string|null $width = null;
    protected string|null $minWidth = null;
    protected bool $isSticky = false;
    protected Closure|null $formatUsing = null;
    protected Closure|null $renderUsing = null;
    protected array $filterOptions = [];
    protected string|null $filterType = null;
    protected string|null $relationship = null;
    protected string|null $sortField = null;
    protected bool $isActions = false;

    public function __construct(string $key, string $label)
    {
        $this->key = $key;
        $this->label = $label;
    }

    public static function make(string $key, string $label = ''): static
    {
        return new static($key, $label ?: ucfirst(str_replace('_', ' ', $key)));
    }

    public static function actions(string $label = 'Azioni'): static
    {
        $column = new static('_actions', $label);
        $column->isActions = true;
        $column->isSortable = false;
        $column->isSearchable = false;
        $column->isToggleable = false;

        return $column;
    }

    public function sortable(string|null $sortField = null): static
    {
        $this->isSortable = true;
        $this->sortField = $sortField;

        return $this;
    }

    public function searchable(): static
    {
        $this->isSearchable = true;

        return $this;
    }

    public function inlineEditable(): static
    {
        $this->isInlineEditable = true;

        return $this;
    }

    public function toggleable(bool $toggleable = true): static
    {
        $this->isToggleable = $toggleable;

        return $this;
    }

    public function visible(bool $visible = true): static
    {
        $this->isVisible = $visible;

        return $this;
    }

    public function hidden(): static
    {
        $this->isVisible = false;

        return $this;
    }

    public function date(string $format = 'd/m/Y'): static
    {
        $this->dateFormat = $format;

        return $this;
    }

    public function dateTime(string $format = 'd/m/Y H:i'): static
    {
        $this->dateFormat = $format;

        return $this;
    }

    public function number(string $format = '2,.,.'): static
    {
        $this->numberFormat = $format;

        return $this;
    }

    public function align(string $align): static
    {
        $this->align = $align;

        return $this;
    }

    public function alignCenter(): static
    {
        return $this->align('center');
    }

    public function alignRight(): static
    {
        return $this->align('right');
    }

    public function width(string $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function minWidth(string $minWidth): static
    {
        $this->minWidth = $minWidth;

        return $this;
    }

    public function sticky(): static
    {
        $this->isSticky = true;

        return $this;
    }

    public function format(Closure $callback): static
    {
        $this->formatUsing = $callback;

        return $this;
    }

    public function render(Closure $callback): static
    {
        $this->renderUsing = $callback;

        return $this;
    }

    public function filterable(array $options = [], string $type = 'select'): static
    {
        $this->filterOptions = $options;
        $this->filterType = $type;

        return $this;
    }

    public function relationship(string $relation): static
    {
        $this->relationship = $relation;

        return $this;
    }

    // --- Getters ---

    public function getKey(): string
    {
        return $this->key;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function isSortable(): bool
    {
        return $this->isSortable;
    }

    public function isSearchable(): bool
    {
        return $this->isSearchable;
    }

    public function isInlineEditable(): bool
    {
        return $this->isInlineEditable;
    }

    public function isToggleable(): bool
    {
        return $this->isToggleable;
    }

    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    public function isActions(): bool
    {
        return $this->isActions;
    }

    public function getDateFormat(): ?string
    {
        return $this->dateFormat;
    }

    public function getNumberFormat(): ?string
    {
        return $this->numberFormat;
    }

    public function getAlign(): string
    {
        return $this->align;
    }

    public function getWidth(): ?string
    {
        return $this->width;
    }

    public function getMinWidth(): ?string
    {
        return $this->minWidth;
    }

    public function isSticky(): bool
    {
        return $this->isSticky;
    }

    public function getFormatUsing(): ?Closure
    {
        return $this->formatUsing;
    }

    public function getRenderUsing(): ?Closure
    {
        return $this->renderUsing;
    }

    public function getFilterOptions(): array
    {
        return $this->filterOptions;
    }

    public function getFilterType(): ?string
    {
        return $this->filterType;
    }

    public function getRelationship(): ?string
    {
        return $this->relationship;
    }

    public function getSortField(): string
    {
        return $this->sortField ?? $this->key;
    }

    /**
     * Get the formatted value for display.
     */
    public function getValue(mixed $row): mixed
    {
        $value = data_get($row, $this->key);

        if ($this->formatUsing) {
            return ($this->formatUsing)($value, $row);
        }

        if ($this->dateFormat && $value) {
            return $value instanceof \DateTimeInterface
                ? $value->format($this->dateFormat)
                : \Carbon\Carbon::parse($value)->format($this->dateFormat);
        }

        if ($this->numberFormat) {
            $parts = explode(',', $this->numberFormat);
            return number_format(
                (float) $value,
                (int) ($parts[0] ?? 2),
                $parts[1] ?? '.',
                $parts[2] ?? ','
            );
        }

        return $value;
    }

    /**
     * Convert to array for Blade component consumption.
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'label' => $this->label,
            'sortable' => $this->isSortable,
            'searchable' => $this->isSearchable,
            'inlineEditable' => $this->isInlineEditable,
            'toggleable' => $this->isToggleable,
            'visible' => $this->isVisible,
            'align' => $this->align,
            'width' => $this->width,
            'minWidth' => $this->minWidth,
            'sticky' => $this->isSticky,
            'actions' => $this->isActions,
            'sortField' => $this->getSortField(),
        ];
    }
}
