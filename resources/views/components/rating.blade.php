@props([
    'value' => 0,
    'max' => 5,
    'size' => 'md',
    'readonly' => false,
    'color' => 'warning',
])

@php
    $sizeClass = match($size) {
        'sm' => 'h-4 w-4',
        'lg' => 'h-7 w-7',
        default => 'h-5 w-5',
    };

    $colorClass = match($color) {
        'primary' => 'text-aura-primary-500',
        'danger' => 'text-aura-danger-500',
        'success' => 'text-aura-success-500',
        default => 'text-aura-warning-400',
    };

    $gapClass = match($size) {
        'sm' => 'gap-0.5',
        'lg' => 'gap-1.5',
        default => 'gap-1',
    };
@endphp

<div x-data="{ rating: {{ (int)$value }}, hovered: 0 }"
     {{ $attributes->class(['aura-rating inline-flex items-center', $gapClass]) }}
     role="radiogroup"
     aria-label="Rating">
    @for($i = 1; $i <= $max; $i++)
        <button type="button"
                @if(!$readonly)
                    x-on:click="rating = {{ $i }}; $dispatch('input', rating)"
                    x-on:mouseenter="hovered = {{ $i }}"
                    x-on:mouseleave="hovered = 0"
                @endif
                class="aura-rating-star {{ $readonly ? 'cursor-default' : 'cursor-pointer' }} aura-transition"
                :class="(hovered >= {{ $i }} || (!hovered && rating >= {{ $i }})) ? '{{ $colorClass }}' : 'text-aura-surface-300'"
                role="radio"
                :aria-checked="rating === {{ $i }}"
                aria-label="Rate {{ $i }} of {{ $max }}">
            <svg class="{{ $sizeClass }}" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </button>
    @endfor
</div>
