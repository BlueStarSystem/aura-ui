@props([
    'title' => '',
    'value' => '',
    'change' => null,
    'changeType' => 'neutral',
    'icon' => null,
    'href' => null,
])

@php
    $changeClass = match($changeType) {
        'positive' => 'aura-stats-change-positive text-aura-success-600 dark:text-aura-success-400',
        'negative' => 'aura-stats-change-negative text-aura-danger-600 dark:text-aura-danger-400',
        default => 'aura-stats-change-neutral text-aura-surface-400',
    };
    $changeIcon = match($changeType) {
        'positive' => 'trending-up',
        'negative' => 'trending-down',
        default => null,
    };
    $tag = $href ? 'a' : 'div';
    $baseClasses = 'aura-stats-card flex items-start justify-between gap-4 py-5 px-6 bg-aura-surface-0 border border-aura-surface-200 rounded-aura-lg shadow-aura-sm no-underline aura-transition-slow hover:shadow-aura-md overflow-hidden';
@endphp

<{{ $tag }} @if($href) href="{{ $href }}" @endif {{ $attributes->class([$baseClasses, $href ? 'aura-card-hover hover:shadow-aura-xl hover:-translate-y-0.5 hover:border-aura-surface-300' : '']) }}>
    <div class="aura-stats-content flex flex-col gap-1">
        <p class="aura-stats-title m-0 text-[13px] font-medium text-aura-surface-400 uppercase tracking-wider">{{ $title }}</p>
        <p class="aura-stats-value m-0 text-[28px] font-bold text-aura-surface-900 tracking-tight leading-tight">{{ $value }}</p>
        @if($change)
            <div class="aura-stats-change {{ $changeClass }} inline-flex items-center gap-1 mt-1 text-[13px] font-semibold">
                @if($changeIcon)
                    <x-aura::icon :name="$changeIcon" size="xs" />
                @endif
                <span>{{ $change }}</span>
            </div>
        @endif
    </div>
    @if($icon)
        <div class="aura-stats-icon flex items-center justify-center w-12 h-12 bg-aura-primary-50 dark:bg-[rgba(129,140,248,0.12)] rounded-aura-lg text-aura-primary-500 shrink-0">
            <x-aura::icon :name="$icon" size="lg" />
        </div>
    @endif
</{{ $tag }}>
