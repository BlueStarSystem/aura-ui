@props([
    'aside' => 'right',
])

@php
    $directionClass = match($aside) {
        'left' => 'aura-layout-aside-left flex-row-reverse',
        default => 'aura-layout-aside-right',
    };
@endphp

<div {{ $attributes->class(['aura-layout flex flex-col lg:flex-row gap-6 lg:gap-8', $directionClass]) }}>
    {{ $slot }}
</div>
