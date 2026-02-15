@props([
    'src' => null,
    'initials' => null,
    'alt' => '',
    'size' => 'md',
    'color' => 'primary',
    'status' => null,
    'rounded' => 'full',
])

@php
    $classes = ['aura-avatar', "aura-avatar-{$size}", "aura-avatar-rounded-{$rounded}"];
    if (!$src) $classes[] = "aura-avatar-{$color}";
@endphp

<div {{ $attributes->class($classes) }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt }}" class="aura-avatar-img" />
    @elseif($initials)
        <span class="aura-avatar-initials">{{ $initials }}</span>
    @else
        <x-aura::icon name="user" size="{{ $size === 'xs' ? 'xs' : ($size === 'sm' ? 'sm' : 'md') }}" />
    @endif

    @if($status)
        <span class="aura-avatar-status aura-avatar-status-{{ $status }}"></span>
    @endif
</div>
