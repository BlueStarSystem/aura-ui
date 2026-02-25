@props([
    'icon' => null,
    'color' => 'primary',
    'date' => null,
])

@php
    $colorClasses = match($color) {
        'success' => 'bg-aura-success-500 text-white',
        'danger' => 'bg-aura-danger-500 text-white',
        'warning' => 'bg-aura-warning-500 text-white',
        'info' => 'bg-aura-info-500 text-white',
        'secondary' => 'bg-aura-surface-400 text-white',
        default => 'bg-aura-primary-500 text-white',
    };
@endphp

<div {{ $attributes->class(['aura-timeline-item relative pl-12 pb-8 last:pb-0']) }}>
    <div class="aura-timeline-dot absolute left-2 top-0.5 flex h-5 w-5 items-center justify-center rounded-full {{ $colorClasses }} ring-4 ring-aura-surface-0">
        @if($icon)
            <x-aura::icon :name="$icon" class="h-3 w-3" />
        @else
            <div class="h-2 w-2 rounded-full bg-current opacity-60"></div>
        @endif
    </div>

    @if($date)
        <time class="aura-timeline-date mb-1 block text-xs text-aura-surface-400">{{ $date }}</time>
    @endif

    <div class="aura-timeline-content">
        {{ $slot }}
    </div>
</div>
