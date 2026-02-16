@props([
    'text' => '',
    'position' => 'top',
    'delay' => 200,
])

<div class="aura-tooltip-wrapper relative inline-flex" x-data="{ show: false }" {{ $attributes }}>
    <div
        x-on:mouseenter="setTimeout(() => show = true, {{ $delay }})"
        x-on:mouseleave="show = false"
        x-on:focus="show = true"
        x-on:blur="show = false"
    >
        {{ $slot }}
    </div>
    <div
        class="aura-tooltip aura-tooltip-{{ $position }} absolute bottom-[calc(100%+8px)] left-1/2 -translate-x-1/2 z-aura-tooltip py-1.5 px-3 text-xs font-medium text-white bg-aura-surface-900 dark:bg-aura-surface-700 dark:text-aura-surface-900 rounded-aura-sm whitespace-nowrap pointer-events-none shadow-aura-lg"
        x-show="show"
        x-transition:enter="aura-transition-fast"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="aura-transition-fast"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
        role="tooltip"
    >
        {{ $text }}
        <span class="aura-tooltip-arrow"></span>
    </div>
</div>
