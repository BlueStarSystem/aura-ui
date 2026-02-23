@props([
    'size' => 'base',
    'color' => 'default',
    'weight' => 'normal',
    'as' => 'p',
])

@php
    $sizeClass = match($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        default => 'text-base',
    };

    $colorClass = match($color) {
        'muted' => 'text-aura-surface-400',
        'subtle' => 'text-aura-surface-500',
        'primary' => 'text-aura-primary-600',
        'success' => 'text-aura-success-600',
        'danger' => 'text-aura-danger-600',
        'warning' => 'text-aura-warning-600',
        default => 'text-aura-surface-600',
    };

    $weightClass = match($weight) {
        'light' => 'font-light',
        'medium' => 'font-medium',
        'semibold' => 'font-semibold',
        'bold' => 'font-bold',
        default => 'font-normal',
    };

    $tag = in_array($as, ['p', 'span', 'div']) ? $as : 'p';
@endphp

<{{ $tag }} {{ $attributes->class(["aura-text leading-relaxed", $sizeClass, $colorClass, $weightClass]) }}>{{ $slot }}</{{ $tag }}>
