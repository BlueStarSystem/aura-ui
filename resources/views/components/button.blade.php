@props([
    'variant' => 'primary',
    'size' => 'md',
    'outline' => false,
    'gradient' => false,
    'loading' => false,
    'disabled' => false,
    'icon' => null,
    'iconRight' => null,
    'iconOnly' => false,
    'href' => null,
    'type' => 'button',
])

@php
    $classes = ['aura-btn', "aura-btn-{$variant}", "aura-btn-{$size}"];

    if ($outline) $classes[] = 'aura-btn-outline';
    if ($gradient) $classes[] = 'aura-btn-gradient';
    if ($loading) $classes[] = 'aura-btn-loading';
    if ($iconOnly) $classes[] = 'aura-btn-icon-only';

    $isDisabled = $disabled || $loading;
    $tag = $href ? 'a' : 'button';
@endphp

@if($href)
<a href="{{ $href }}" {{ $attributes->class($classes) }} @if($isDisabled) aria-disabled="true" tabindex="-1" @endif>
    @if($loading)
        <span class="aura-btn-spinner"></span>
    @elseif($icon)
        <x-aura::icon :name="$icon" size="sm" />
    @endif
    <span>{{ $slot }}</span>
    @if($iconRight)
        <x-aura::icon :name="$iconRight" size="sm" />
    @endif
</a>
@else
<button type="{{ $type }}" {{ $attributes->class($classes) }} @if($isDisabled) disabled @endif>
    @if($loading)
        <span class="aura-btn-spinner"></span>
    @elseif($icon)
        <x-aura::icon :name="$icon" size="sm" />
    @endif
    <span>{{ $slot }}</span>
    @if($iconRight)
        <x-aura::icon :name="$iconRight" size="sm" />
    @endif
</button>
@endif
