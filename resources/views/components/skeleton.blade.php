@props([
    'rounded' => 'md',
])

@php
    $roundedClass = match($rounded) {
        'none' => 'rounded-none',
        'sm' => 'rounded-aura-sm',
        'lg' => 'rounded-aura-lg',
        'full' => 'rounded-full',
        default => 'rounded-aura-md',
    };
@endphp

<div {{ $attributes->class(['aura-skeleton', "aura-skeleton-rounded-{$rounded}", 'relative overflow-hidden bg-aura-surface-200 dark:bg-aura-surface-200', $roundedClass]) }} aria-hidden="true"></div>
