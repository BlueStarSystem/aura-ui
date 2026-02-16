@props([
    'variant' => 'info',
    'icon' => null,
    'dismissible' => false,
    'bordered' => true,
])

@php
    $defaultIcons = [
        'info' => 'info',
        'success' => 'check-circle',
        'warning' => 'alert-triangle',
        'danger' => 'x-circle',
    ];
    $iconName = $icon ?? ($defaultIcons[$variant] ?? 'info');

    $variantClasses = match($variant) {
        'info' => 'bg-aura-info-50 border-aura-info-500 text-aura-info-800 dark:bg-[rgba(14,165,233,0.08)] dark:text-aura-info-200',
        'success' => 'bg-aura-success-50 border-aura-success-500 text-aura-success-800 dark:bg-[rgba(16,185,129,0.08)] dark:text-aura-success-200',
        'warning' => 'bg-aura-warning-50 border-aura-warning-500 text-aura-warning-800 dark:bg-[rgba(245,158,11,0.08)] dark:text-aura-warning-200',
        'danger' => 'bg-aura-danger-50 border-aura-danger-500 text-aura-danger-800 dark:bg-[rgba(239,68,68,0.08)] dark:text-aura-danger-200',
        default => 'bg-aura-info-50 border-aura-info-500 text-aura-info-800',
    };

    $classes = [
        'aura-alert',
        "aura-alert-{$variant}",
        'flex items-start gap-3 px-4 py-3.5 rounded-aura-lg border-l-4 relative aura-transition',
        $variantClasses,
    ];
    if ($bordered) $classes[] = 'aura-alert-bordered';
@endphp

<div
    {{ $attributes->class($classes) }}
    role="alert"
    @if($dismissible) x-data="{ show: true }" x-show="show" x-transition @endif
>
    <div class="aura-alert-icon shrink-0 w-5 h-5 mt-px">
        <x-aura::icon :name="$iconName" size="md" />
    </div>

    <div class="aura-alert-content flex-1 min-w-0">
        @if(isset($title))
            <h4 class="aura-alert-title text-sm font-semibold mb-1 leading-snug">{{ $title }}</h4>
        @endif
        <div class="aura-alert-body text-[13px] leading-normal opacity-85">{{ $slot }}</div>
        @if(isset($actions))
            <div class="aura-alert-actions">{{ $actions }}</div>
        @endif
    </div>

    @if($dismissible)
        <button type="button" class="aura-alert-dismiss shrink-0 w-7 h-7 flex items-center justify-center border-none bg-transparent cursor-pointer rounded-aura-sm text-current opacity-50 hover:opacity-100 hover:bg-black/5 aura-transition-fast" x-on:click="show = false" aria-label="Chiudi">
            <x-aura::icon name="x" size="sm" />
        </button>
    @endif
</div>
