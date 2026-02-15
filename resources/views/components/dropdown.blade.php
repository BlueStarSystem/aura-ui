@props([
    'position' => 'bottom-start',
    'width' => 'w-48',
    'glass' => false,
])

@php
    $menuClass = 'aura-dropdown-menu';
    if ($glass) $menuClass .= ' aura-glass';
@endphp

<div class="aura-dropdown" x-data="{ open: false }" {{ $attributes }}>
    <div x-on:click="open = !open" class="aura-dropdown-trigger">
        {{ $trigger }}
    </div>

    <div
        class="{{ $menuClass }}"
        x-show="open"
        x-on:click.away="open = false"
        x-on:keydown.escape.window="open = false"
        x-transition:enter="aura-transition"
        x-transition:enter-start="opacity-0 transform scale-95 -translate-y-1"
        x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
        x-transition:leave="aura-transition-fast"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
    >
        {{ $slot }}
    </div>
</div>
