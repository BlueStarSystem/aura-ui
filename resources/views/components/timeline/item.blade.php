@props([
    'icon' => null,
    'color' => 'primary',
    'date' => null,
])

@php
    $dotBg = match($color) {
        'success' => 'var(--aura-success-500, #22c55e)',
        'danger' => 'var(--aura-danger-500, #ef4444)',
        'warning' => 'var(--aura-warning-500, #f59e0b)',
        'info' => 'var(--aura-info-500, #06b6d4)',
        'secondary' => 'var(--aura-surface-400, #9ca3af)',
        default => 'var(--aura-primary-500, #6366f1)',
    };
@endphp

<div {{ $attributes->class(['aura-timeline-item']) }} style="position:relative;padding-left:3.5rem;padding-bottom:2rem;">
    {{-- Dot --}}
    <div style="position:absolute;left:0.375rem;top:0.25rem;width:1.5rem;height:1.5rem;border-radius:9999px;background:{{ $dotBg }};display:flex;align-items:center;justify-content:center;color:#fff;box-shadow:0 0 0 4px var(--aura-surface-0, #fff);">
        @if($icon)
            <x-aura::icon :name="$icon" class="h-3 w-3" />
        @else
            <div style="width:0.5rem;height:0.5rem;border-radius:9999px;background:currentColor;opacity:0.6;"></div>
        @endif
    </div>

    @if($date)
        <time style="display:block;margin-bottom:0.25rem;font-size:0.75rem;color:var(--aura-surface-400, #9ca3af);">{{ $date }}</time>
    @endif

    <div class="aura-timeline-content" style="color:var(--aura-surface-700, #374151);font-size:0.875rem;line-height:1.5;">
        {{ $slot }}
    </div>
</div>
