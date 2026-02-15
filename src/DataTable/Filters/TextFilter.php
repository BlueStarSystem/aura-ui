<?php

namespace BlueStarSystem\AuraUI\DataTable\Filters;

use Illuminate\Database\Eloquent\Builder;

class TextFilter extends Filter
{
    protected string|null $column = null;
    protected string $operator = 'like';

    public static function make(string $key, string $label): static
    {
        return new static($key, $label);
    }

    public function column(string $column): static
    {
        $this->column = $column;

        return $this;
    }

    public function exact(): static
    {
        $this->operator = '=';

        return $this;
    }

    public function getType(): string
    {
        return 'text';
    }

    public function apply(Builder $query, mixed $value): Builder
    {
        if ($this->isEmpty($value)) {
            return $query;
        }

        $column = $this->column ?? $this->key;

        if ($this->operator === 'like') {
            return $query->where($column, 'like', "%{$value}%");
        }

        return $query->where($column, $this->operator, $value);
    }
}
