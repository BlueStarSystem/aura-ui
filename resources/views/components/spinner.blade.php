@props([
    'size' => 'md',
    'color' => 'primary',
])

@php
    $sizeClasses = match($size) {
        'sm' => 'w-4 h-4 border-2',
        'lg' => 'w-9 h-9 border-[3px]',
        default => 'w-6 h-6 border-[3px]',
    };
@endphp

<div {{ $attributes->class(['aura-spinner', "aura-spinner-{$size}", "aura-spinner-{$color}", 'inline-block rounded-full border-aura-surface-200 border-t-aura-primary-500 aura-animate-spin', $sizeClasses]) }} role="status" aria-label="Loading">
    <span class="sr-only">Loading...</span>
</div>
