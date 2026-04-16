@props([
    'count' => 0,
    'position' => 'bottom-end',
    'maxHeight' => '24rem',
])

<div
    {{ $attributes->class(['aura-notification-center']) }}
    x-data="{ open: false }"
    @click.outside="open = false"
    @keydown.escape.window="open = false"
>
    <button
        type="button"
        class="aura-notification-center__trigger"
        @click="open = !open"
        aria-label="Notifications"
        :aria-expanded="open"
    >
        <svg class="aura-notification-center__bell" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
        </svg>
        @if ($count > 0)
            <span class="aura-notification-center__badge" x-transition.scale>{{ $count }}</span>
        @endif
    </button>

    <div
        class="aura-notification-center__dropdown aura-notification-center__dropdown--{{ $position }}"
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-cloak
        role="menu"
    >
        <div class="aura-notification-center__list" style="max-height: {{ $maxHeight }}">
            @if ($slot->isEmpty() && isset($empty))
                <div class="aura-notification-center__empty">
                    {{ $empty }}
                </div>
            @else
                {{ $slot }}
            @endif
        </div>

        @if (isset($footer))
            <div class="aura-notification-center__footer">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
