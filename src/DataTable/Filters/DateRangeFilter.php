<?php

namespace BlueStarSystem\AuraUI\DataTable\Filters;

use Illuminate\Database\Eloquent\Builder;

class DateRangeFilter extends Filter
{
    protected string|null $column = null;
    protected string $format = 'Y-m-d';

    public static function make(string $key, string $label): static
    {
        return new static($key, $label);
    }

    public function column(string $column): static
    {
        $this->column = $column;

        return $this;
    }

    public function format(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function getType(): string
    {
        return 'date_range';
    }

    public function apply(Builder $query, mixed $value): Builder
    {
        if ($this->isEmpty($value)) {
            return $query;
        }

        $column = $this->column ?? $this->key;

        if (is_array($value)) {
            if (! empty($value['from'])) {
                $query->whereDate($column, '>=', $value['from']);
            }
            if (! empty($value['to'])) {
                $query->whereDate($column, '<=', $value['to']);
            }
        }

        return $query;
    }

    public function isEmpty(mixed $value): bool
    {
        if (! is_array($value)) {
            return true;
        }

        return empty($value['from']) && empty($value['to']);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'format' => $this->format,
        ]);
    }
}
