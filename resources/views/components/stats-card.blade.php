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
        'positive' => 'aura-stats-change-positive',
        'negative' => 'aura-stats-change-negative',
        default => 'aura-stats-change-neutral',
    };
    $changeIcon = match($changeType) {
        'positive' => 'trending-up',
        'negative' => 'trending-down',
        default => null,
    };
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }} @if($href) href="{{ $href }}" @endif {{ $attributes->class(['aura-stats-card', $href ? 'aura-card-hover' : '']) }}>
    <div class="aura-stats-content">
        <p class="aura-stats-title">{{ $title }}</p>
        <p class="aura-stats-value">{{ $value }}</p>
        @if($change)
            <div class="aura-stats-change {{ $changeClass }}">
                @if($changeIcon)
                    <x-aura::icon :name="$changeIcon" size="xs" />
                @endif
                <span>{{ $change }}</span>
            </div>
        @endif
    </div>
    @if($icon)
        <div class="aura-stats-icon">
            <x-aura::icon :name="$icon" size="lg" />
        </div>
    @endif
</{{ $tag }}>
