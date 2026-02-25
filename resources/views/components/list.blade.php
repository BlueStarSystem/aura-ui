@props([
    'variant' => 'default',
    'divided' => false,
])

@php
    $variantClass = match($variant) {
        'bordered' => 'border border-aura-surface-200 rounded-aura-lg',
        'flush' => '',
        default => '',
    };
@endphp

<ul {{ $attributes->class([
    'aura-list',
    $variantClass,
    $divided ? 'divide-y divide-aura-surface-200' : 'space-y-1',
]) }}>
    {{ $slot }}
</ul>
