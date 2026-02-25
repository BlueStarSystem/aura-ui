@props([
    'width' => 'md',
    'sticky' => false,
])

@php
    $widthClass = match($width) {
        'sm' => 'lg:w-56',
        'lg' => 'lg:w-80',
        default => 'lg:w-64',
    };

    $classes = [
        'aura-aside shrink-0',
        $widthClass,
    ];

    if ($sticky) $classes[] = 'aura-aside-sticky lg:sticky lg:top-4 lg:self-start';
@endphp

<aside {{ $attributes->class($classes) }}>
    {{ $slot }}
</aside>
