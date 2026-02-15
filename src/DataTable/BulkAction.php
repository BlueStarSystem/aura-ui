<?php

namespace BlueStarSystem\AuraUI\DataTable;

use Closure;

class BulkAction
{
    protected string $key;
    protected string $label;
    protected string|null $icon = null;
    protected string $color = 'primary';
    protected string|null $confirmMessage = null;
    protected string|null $confirmTitle = null;
    protected Closure|null $actionCallback = null;
    protected bool $requiresConfirmation = false;
    protected bool $deselectAfter = true;

    public function __construct(string $key, string $label)
    {
        $this->key = $key;
        $this->label = $label;
    }

    public static function make(string $key, string $label): static
    {
        return new static($key, $label);
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function color(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function confirm(string $message, string $title = 'Conferma'): static
    {
        $this->requiresConfirmation = true;
        $this->confirmMessage = $message;
        $this->confirmTitle = $title;

        return $this;
    }

    public function action(Closure $callback): static
    {
        $this->actionCallback = $callback;

        return $this;
    }

    public function keepSelected(): static
    {
        $this->deselectAfter = false;

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function requiresConfirmation(): bool
    {
        return $this->requiresConfirmation;
    }

    public function getConfirmMessage(): ?string
    {
        return $this->confirmMessage;
    }

    public function getConfirmTitle(): ?string
    {
        return $this->confirmTitle;
    }

    public function shouldDeselectAfter(): bool
    {
        return $this->deselectAfter;
    }

    /**
     * Execute the bulk action with the given IDs.
     */
    public function execute(array $ids): mixed
    {
        if ($this->actionCallback) {
            return ($this->actionCallback)($ids);
        }

        return null;
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'label' => $this->label,
            'icon' => $this->icon,
            'color' => $this->color,
            'requiresConfirmation' => $this->requiresConfirmation,
            'confirmMessage' => $this->confirmMessage,
            'confirmTitle' => $this->confirmTitle,
        ];
    }
}
