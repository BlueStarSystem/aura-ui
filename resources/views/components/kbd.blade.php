@props([
    'size' => 'md',
])

@php
    $sizeClass = match($size) {
        'sm' => 'text-[10px] px-1 py-px min-w-[18px]',
        'lg' => 'text-sm px-2 py-1 min-w-[28px]',
        default => 'text-xs px-1.5 py-0.5 min-w-[22px]',
    };
@endphp

<kbd {{ $attributes->class([
    'aura-kbd',
    'inline-flex items-center justify-center font-mono font-medium',
    'rounded-aura-sm border border-aura-surface-300 bg-aura-surface-100 text-aura-surface-600',
    'shadow-[0_1px_0_1px_rgba(0,0,0,0.05)]',
    $sizeClass,
]) }}>{{ $slot }}</kbd>
