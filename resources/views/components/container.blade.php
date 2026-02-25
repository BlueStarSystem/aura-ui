@props([
    'size' => 'lg',
])

@php
    $sizeClass = match($size) {
        'sm' => 'max-w-screen-sm',
        'md' => 'max-w-screen-md',
        'xl' => 'max-w-screen-xl',
        'full' => 'max-w-full',
        default => 'max-w-screen-lg',
    };
@endphp

<div {{ $attributes->class(['aura-container mx-auto px-4 sm:px-6 lg:px-8', $sizeClass]) }}>
    {{ $slot }}
</div>
