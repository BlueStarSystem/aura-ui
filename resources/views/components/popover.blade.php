@props([
    'position' => 'bottom',
    'width' => '300px',
    'closeable' => true,
    'trigger' => 'click',
])

@php
    $positionClasses = match($position) {
        'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
        'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
        'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
        'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
        default => 'top-full left-1/2 -translate-x-1/2 mt-2',
    };
@endphp

<div
    {{ $attributes->class(['aura-popover-wrapper relative inline-block']) }}
    x-data="{ open: false }"
    @if($trigger === 'hover')
        @mouseenter="open = true"
        @mouseleave="open = false"
    @endif
    @if($closeable)
        @click.outside="open = false"
        @keydown.escape.window="open = false"
    @endif
>
    {{-- Trigger --}}
    <div
        class="aura-popover-trigger inline-flex cursor-pointer"
        @if($trigger === 'click')
            @click="open = !open"
        @endif
    >
        {{ $slot }}
    </div>

    {{-- Content --}}
    <div
        class="aura-popover absolute z-aura-dropdown {{ $positionClasses }} bg-aura-surface-0 border border-aura-surface-200 rounded-aura-lg shadow-aura-xl aura-glass"
        style="width: {{ $width }};"
        x-show="open"
        x-transition:enter="aura-transition"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="aura-transition-fast"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-cloak
    >
        @if(isset($content))
            <div class="aura-popover-content p-4">
                {{ $content }}
            </div>
        @endif
    </div>
</div>
