@props([
    'variant' => 'note',
    'title' => null,
    'icon' => null,
])

@php
    /**
     * The prose counterpart of alert. An alert reports what just happened and
     * often needs announcing; a callout is part of the document — a note in a
     * guide, a warning in a changelog — and is read in its turn.
     */
    $variantClass = match ($variant) {
        'tip' => 'aura-callout-tip border-aura-success-500 bg-aura-success-50 dark:bg-aura-success-900/30',
        'warning' => 'aura-callout-warning border-aura-warning-500 bg-aura-warning-50 dark:bg-aura-warning-900/30',
        'danger' => 'aura-callout-danger border-aura-danger-500 bg-aura-danger-50 dark:bg-aura-danger-900/30',
        'info' => 'aura-callout-info border-aura-info-500 bg-aura-info-50 dark:bg-aura-info-900/30',
        default => 'aura-callout-note border-aura-primary-500 bg-aura-primary-50 dark:bg-aura-primary-900/30',
    };

    $iconColor = match ($variant) {
        'tip' => 'text-aura-success-700',
        'warning' => 'text-aura-warning-700',
        'danger' => 'text-aura-danger-700',
        'info' => 'text-aura-info-700',
        default => 'text-aura-primary-700',
    };

    $iconName = $icon ?? match ($variant) {
        'tip' => 'lightbulb',
        'warning' => 'alert-triangle',
        'danger' => 'alert-circle',
        'info' => 'info',
        default => 'book-open',
    };
@endphp

<div {{ $attributes->class(['aura-callout flex gap-3 rounded-aura-md border-l-4 p-4', $variantClass]) }}>
    <div class="aura-callout-icon shrink-0 {{ $iconColor }}" aria-hidden="true">
        <x-aura::icon :name="$iconName" size="md" />
    </div>

    <div class="aura-callout-content min-w-0 flex-1">
        @if($title)
            <p class="aura-callout-title mb-1 font-semibold text-aura-surface-900">{{ $title }}</p>
        @endif

        <div class="aura-callout-body text-sm leading-relaxed text-aura-surface-800">{{ $slot }}</div>
    </div>
</div>
