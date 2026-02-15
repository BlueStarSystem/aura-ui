@props([
    'icon' => null,
    'variant' => null,
    'href' => null,
    'type' => 'button',
])

@php
    $class = 'aura-dropdown-item';
    if ($variant === 'danger') $class .= ' aura-dropdown-item-danger';
@endphp

@if($href)
<a href="{{ $href }}" class="{{ $class }}" {{ $attributes }}>
    @if($icon) <x-aura::icon :name="$icon" size="sm" /> @endif
    <span>{{ $slot }}</span>
</a>
@else
<button type="{{ $type }}" class="{{ $class }}" {{ $attributes }}>
    @if($icon) <x-aura::icon :name="$icon" size="sm" /> @endif
    <span>{{ $slot }}</span>
</button>
@endif
