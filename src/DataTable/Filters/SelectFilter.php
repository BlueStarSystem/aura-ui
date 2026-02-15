<?php

namespace BlueStarSystem\AuraUI\DataTable\Filters;

use Illuminate\Database\Eloquent\Builder;

class SelectFilter extends Filter
{
    protected array $options = [];
    protected bool $multiple = false;
    protected string|null $column = null;

    public static function make(string $key, string $label): static
    {
        return new static($key, $label);
    }

    public function options(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function multiple(): static
    {
        $this->multiple = true;

        return $this;
    }

    public function column(string $column): static
    {
        $this->column = $column;

        return $this;
    }

    public function getType(): string
    {
        return 'select';
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    public function apply(Builder $query, mixed $value): Builder
    {
        if ($this->isEmpty($value)) {
            return $query;
        }

        $column = $this->column ?? $this->key;

        if ($this->multiple && is_array($value)) {
            return $query->whereIn($column, $value);
        }

        return $query->where($column, $value);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'options' => $this->options,
            'multiple' => $this->multiple,
        ]);
    }
}
