<?php

namespace BlueStarSystem\AuraUI\DataTable\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    protected string $key;
    protected string $label;
    protected mixed $defaultValue = null;
    protected string|null $placeholder = null;

    public function __construct(string $key, string $label)
    {
        $this->key = $key;
        $this->label = $label;
    }

    abstract public function apply(Builder $query, mixed $value): Builder;

    abstract public function getType(): string;

    public function default(mixed $value): static
    {
        $this->defaultValue = $value;

        return $this;
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function isEmpty(mixed $value): bool
    {
        return $value === null || $value === '' || $value === [];
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'label' => $this->label,
            'type' => $this->getType(),
            'default' => $this->defaultValue,
            'placeholder' => $this->placeholder,
        ];
    }
}
