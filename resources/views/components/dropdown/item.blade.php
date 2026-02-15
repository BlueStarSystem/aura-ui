@props([
    'icon' => null,
    'variant' => null,
    'href' => null,
])

@php
    $class = 'aura-dropdown-item';
    if ($variant === 'danger') $class .= ' aura-dropdown-item-danger';
    $tag = $href ? 'a' : 'button';
@endphp

@if($href)
<a href="{{ $href }}" class="{{ $class }}" {{ $attributes }}>
    @if($icon) <x-aura::icon :name="$icon" size="sm" /> @endif
    <span>{{ $slot }}</span>
</a>
@else
<button type="button" class="{{ $class }}" {{ $attributes }}>
    @if($icon) <x-aura::icon :name="$icon" size="sm" /> @endif
    <span>{{ $slot }}</span>
</button>
@endif
