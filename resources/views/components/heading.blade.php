@props([
    'level' => 2,
    'size' => null,
])

@php
    $tag = 'h' . min(max((int)$level, 1), 6);

    $sizeClass = $size ? match($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        '2xl' => 'text-2xl',
        default => 'text-base',
    } : match((int)$level) {
        1 => 'text-2xl',
        2 => 'text-xl',
        3 => 'text-lg',
        4 => 'text-base',
        5 => 'text-sm',
        6 => 'text-xs',
        default => 'text-base',
    };
@endphp

<{{ $tag }} {{ $attributes->class(["aura-heading aura-heading-{$tag} font-semibold text-aura-surface-900 tracking-tight", $sizeClass]) }}>{{ $slot }}</{{ $tag }}>
