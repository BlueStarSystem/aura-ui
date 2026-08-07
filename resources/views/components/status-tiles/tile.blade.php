@props([
    'name' => '',
    'status' => 'operational',
    'detail' => null,
    'href' => null,
])

@php
    /**
     * The state is carried by a colour and by a word. A grid of coloured
     * squares is exactly the case WCAG 1.4.1 is about: without the word, the
     * page says nothing at all to someone who cannot see the difference between
     * amber and green.
     */
    $known = ['operational', 'degraded', 'outage', 'maintenance', 'unknown'];
    $key = in_array($status, $known, true) ? $status : 'unknown';

    $stateClass = match ($key) {
        'operational' => 'border-aura-success-200 bg-aura-success-50 dark:bg-aura-success-900/25',
        'degraded' => 'border-aura-warning-200 bg-aura-warning-50 dark:bg-aura-warning-900/25',
        'outage' => 'border-aura-danger-200 bg-aura-danger-50 dark:bg-aura-danger-900/25',
        'maintenance' => 'border-aura-info-200 bg-aura-info-50 dark:bg-aura-info-900/25',
        default => 'border-aura-surface-200 bg-aura-surface-50',
    };

    $dotClass = match ($key) {
        'operational' => 'bg-aura-success-600',
        'degraded' => 'bg-aura-warning-600',
        'outage' => 'bg-aura-danger-600',
        'maintenance' => 'bg-aura-info-600',
        default => 'bg-aura-surface-500',
    };

    $stateText = __('aura-ui::messages.status_'.$key);
    $tag = $href ? 'a' : 'div';
@endphp

<li>
    <{{ $tag }}
        {{ $attributes->class([
            'aura-status-tile flex h-full flex-col gap-1 rounded-aura-md border p-3',
            $stateClass,
            $href ? 'aura-transition-fast hover:shadow-aura-sm' : '',
        ]) }}
        @if($href) href="{{ \BlueStarSystem\AuraUI\Support\Html::url($href) }}" @endif
    >
        <span class="aura-status-tile-head flex items-center gap-2">
            <span class="aura-status-tile-dot h-2 w-2 shrink-0 rounded-full {{ $dotClass }}" aria-hidden="true"></span>
            <span class="aura-status-tile-name truncate text-sm font-medium text-aura-surface-900">{{ $name }}</span>
        </span>

        {{-- The word, not only the colour. --}}
        <span class="aura-status-tile-state text-xs text-aura-surface-700">{{ $stateText }}</span>

        @if($detail)
            <span class="aura-status-tile-detail text-xs text-aura-surface-600">{{ $detail }}</span>
        @endif
    </{{ $tag }}>
</li>
