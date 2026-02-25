@props([
    'size' => 'sm',
    'as' => 'p',
])

@php
    $sizeClass = match($size) {
        'base' => 'text-base',
        'lg' => 'text-lg',
        default => 'text-sm',
    };

    $tag = in_array($as, ['p', 'span', 'div']) ? $as : 'p';
@endphp

<{{ $tag }} {{ $attributes->class(['aura-subheading text-aura-surface-500 leading-relaxed', $sizeClass]) }}>{{ $slot }}</{{ $tag }}>
