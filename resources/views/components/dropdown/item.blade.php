@props([
    'icon' => null,
    'variant' => null,
    'href' => null,
    'type' => 'button',
])

@php
    $classes = ['aura-dropdown-item', 'flex items-center gap-2.5 w-full py-2 px-3 font-inherit text-[13px] font-[450] text-aura-surface-900 bg-transparent border-none rounded-aura-sm cursor-pointer text-left aura-transition-fast no-underline leading-snug hover:bg-aura-surface-100'];
    if ($variant === 'danger') $classes[] = 'aura-dropdown-item-danger text-aura-danger-600 hover:bg-aura-danger-50 hover:text-aura-danger-700';
@endphp

@if($href)
<a href="{{ $href }}" class="{{ implode(' ', $classes) }}" {{ $attributes }}>
    @if($icon) <x-aura::icon :name="$icon" size="sm" /> @endif
    <span>{{ $slot }}</span>
</a>
@else
<button type="{{ $type }}" class="{{ implode(' ', $classes) }}" {{ $attributes }}>
    @if($icon) <x-aura::icon :name="$icon" size="sm" /> @endif
    <span>{{ $slot }}</span>
</button>
@endif
