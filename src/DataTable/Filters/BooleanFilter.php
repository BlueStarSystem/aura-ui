<?php

namespace BlueStarSystem\AuraUI\DataTable\Filters;

use Illuminate\Database\Eloquent\Builder;

class BooleanFilter extends Filter
{
    protected string|null $column = null;
    protected string $trueLabel = 'Si';
    protected string $falseLabel = 'No';

    public static function make(string $key, string $label): static
    {
        return new static($key, $label);
    }

    public function column(string $column): static
    {
        $this->column = $column;

        return $this;
    }

    public function labels(string $trueLabel, string $falseLabel): static
    {
        $this->trueLabel = $trueLabel;
        $this->falseLabel = $falseLabel;

        return $this;
    }

    public function getType(): string
    {
        return 'boolean';
    }

    public function getTrueLabel(): string
    {
        return $this->trueLabel;
    }

    public function getFalseLabel(): string
    {
        return $this->falseLabel;
    }

    public function apply(Builder $query, mixed $value): Builder
    {
        if ($this->isEmpty($value)) {
            return $query;
        }

        $column = $this->column ?? $this->key;

        return $query->where($column, filter_var($value, FILTER_VALIDATE_BOOLEAN));
    }

    public function isEmpty(mixed $value): bool
    {
        return $value === null || $value === '';
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'trueLabel' => $this->trueLabel,
            'falseLabel' => $this->falseLabel,
        ]);
    }
}
