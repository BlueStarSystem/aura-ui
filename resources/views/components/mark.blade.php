@props([
    'color' => 'warning',
])

@php
    // -100 background with -900 text: both shades exist in every accent scale
    // and the pair is asserted in the contrast suite.
    $colorClass = match($color) {
        'primary' => 'bg-aura-primary-100 text-aura-primary-900',
        'success' => 'bg-aura-success-100 text-aura-success-900',
        'danger' => 'bg-aura-danger-100 text-aura-danger-900',
        'info' => 'bg-aura-info-100 text-aura-info-900',
        default => 'bg-aura-warning-100 text-aura-warning-900',
    };
@endphp

<mark {{ $attributes->class(['aura-mark rounded px-1', $colorClass]) }}>{{ $slot }}</mark>
