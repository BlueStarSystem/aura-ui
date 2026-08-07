@props([
    'actor' => null,
    'avatar' => null,
    'icon' => null,
    'iconColor' => 'primary',
    'time' => null,
    'datetime' => null,
    'href' => null,
    'last' => false,
])

@php
    /**
     * One entry in an activity feed. Meant to sit inside a <ul>.
     *
     * The connecting line down the left is drawn on the row rather than by the
     * list, so a feed can end without a line hanging off the bottom.
     */
    $iconClass = match ($iconColor) {
        'success' => 'bg-aura-success-50 text-aura-success-700 dark:bg-aura-success-900/30 dark:text-aura-success-400',
        'warning' => 'bg-aura-warning-50 text-aura-warning-700 dark:bg-aura-warning-900/30 dark:text-aura-warning-400',
        'danger' => 'bg-aura-danger-50 text-aura-danger-700 dark:bg-aura-danger-900/30 dark:text-aura-danger-400',
        'surface' => 'bg-aura-surface-100 text-aura-surface-700',
        default => 'bg-aura-primary-50 text-aura-primary-700 dark:bg-aura-primary-900/30 dark:text-aura-primary-400',
    };
@endphp

<li {{ $attributes->class(['aura-activity-row relative flex gap-3 pb-6', $last ? 'aura-activity-row-last pb-0' : '']) }}>
    @unless($last)
        {{-- Decoration: it says "these are connected", which the list already
             says out loud. --}}
        <span class="aura-activity-line absolute left-4 top-9 -ml-px h-[calc(100%-1.5rem)] w-0.5 bg-aura-surface-200" aria-hidden="true"></span>
    @endunless

    <span class="aura-activity-marker relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full ring-4 ring-aura-surface-0 {{ $avatar ? '' : $iconClass }}">
        @if($avatar)
            <x-aura::avatar :src="$avatar" :name="$actor" size="sm" />
        @elseif($icon)
            <x-aura::icon :name="$icon" size="xs" aria-hidden="true" />
        @else
            <span class="h-2 w-2 rounded-full bg-current" aria-hidden="true"></span>
        @endif
    </span>

    <div class="aura-activity-body min-w-0 flex-1 pt-1">
        <p class="aura-activity-text text-sm text-aura-surface-800">
            @if($actor)
                <span class="aura-activity-actor font-semibold text-aura-surface-900">{{ $actor }}</span>
            @endif

            @if($href)
                <a href="{{ \BlueStarSystem\AuraUI\Support\Html::url($href) }}" class="aura-activity-link underline underline-offset-2 hover:no-underline">{{ $slot }}</a>
            @else
                {{ $slot }}
            @endif
        </p>

        @if($time)
            {{-- A real <time>: "2 hours ago" is useless in a screen reader's
                 list of the page a week later, the machine-readable date is not. --}}
            <time
                class="aura-activity-time mt-0.5 block text-xs text-aura-surface-600"
                @if($datetime) datetime="{{ $datetime }}" @endif
            >{{ $time }}</time>
        @endif
    </div>
</li>
