@props([
    'size' => 'md',
    'color' => 'primary',
])

@php
    $sizeClasses = match($size) {
        'sm' => 'w-4 h-4 border-2',
        'lg' => 'w-9 h-9 border-[3px]',
        'xl' => 'w-12 h-12 border-4',
        default => 'w-6 h-6 border-[3px]',
    };

    $colorClass = match($color) {
        'secondary' => 'border-t-aura-secondary-500',
        'success' => 'border-t-aura-success-500',
        'danger' => 'border-t-aura-danger-500',
        'white' => 'border-t-white',
        default => 'border-t-aura-primary-500',
    };
@endphp

<div {{ $attributes->class(['aura-spinner', "aura-spinner-{$size}", "aura-spinner-{$color}", 'inline-block rounded-full border-aura-surface-200 aura-animate-spin', $sizeClasses, $colorClass]) }} role="status" aria-label="Loading">
    <span class="sr-only">Loading...</span>
</div>
