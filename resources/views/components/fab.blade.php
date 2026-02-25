@props([
    'position' => 'bottom-right',
    'size' => 'md',
    'color' => 'primary',
    'icon' => null,
    'expandable' => false,
])

@php
    $positionClass = match($position) {
        'bottom-left' => 'bottom-6 left-6',
        'top-right' => 'top-6 right-6',
        'top-left' => 'top-6 left-6',
        default => 'bottom-6 right-6',
    };

    $sizeClass = match($size) {
        'sm' => 'h-10 w-10',
        'lg' => 'h-16 w-16',
        default => 'h-12 w-12',
    };

    $iconSize = match($size) {
        'sm' => 'h-4 w-4',
        'lg' => 'h-7 w-7',
        default => 'h-5 w-5',
    };

    $colorClass = match($color) {
        'success' => 'bg-aura-success-500 hover:bg-aura-success-600 text-white',
        'danger' => 'bg-aura-danger-500 hover:bg-aura-danger-600 text-white',
        'secondary' => 'bg-aura-surface-600 hover:bg-aura-surface-700 text-white',
        default => 'bg-aura-primary-500 hover:bg-aura-primary-600 text-white',
    };
@endphp

<div @if($expandable) x-data="{ open: false }" @endif
     class="aura-fab fixed {{ $positionClass }} z-50"
     {{ $attributes }}>

    @if($expandable && isset($actions))
        <div x-show="open" x-transition:enter="aura-transition" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="aura-transition-fast" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
             x-cloak
             class="aura-fab-actions absolute bottom-full mb-3 flex flex-col-reverse items-center gap-2">
            {{ $actions }}
        </div>
    @endif

    <button type="button"
            @if($expandable) x-on:click="open = !open" @endif
            class="aura-fab-button {{ $sizeClass }} {{ $colorClass }} inline-flex items-center justify-center rounded-full shadow-lg aura-transition hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2">
        @if($icon)
            <x-aura::icon :name="$icon" :class="$iconSize" />
        @else
            <span @if($expandable) :class="open ? 'rotate-45' : ''" class="aura-transition" @endif>
                <svg class="{{ $iconSize }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            </span>
        @endif
    </button>
</div>
