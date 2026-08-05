@props([
    'size' => null,
])

@php
    $sizeClass = match($size) {
        'xs' => 'h-2',
        'sm' => 'h-4',
        'md' => 'h-8',
        'lg' => 'h-16',
        'xl' => 'h-24',
        // With no size it takes whatever room is left, which is how you push
        // one item of a row to the far end without justify-between.
        default => 'flex-1',
    };
@endphp

<div aria-hidden="true" {{ $attributes->class(['aura-spacer', $sizeClass]) }}></div>
