@props([
    'variant' => 'primary',
    'size' => 'md',
    'dot' => false,
    'icon' => null,
    'removable' => false,
    'outline' => false,
    'gradient' => false,
    'rounded' => false,
])

@php
    $classes = ['aura-badge', "aura-badge-{$variant}", "aura-badge-{$size}"];
    if ($outline) $classes[] = 'aura-badge-outline';
    if ($gradient) $classes[] = 'aura-badge-gradient';
    if ($rounded) $classes[] = 'aura-badge-pill';
@endphp

<span {{ $attributes->class($classes) }}>
    @if($dot)
        <span class="aura-badge-dot"></span>
    @endif
    @if($icon)
        <x-aura::icon :name="$icon" size="xs" />
    @endif
    {{ $slot }}
    @if($removable)
        <button type="button" class="aura-badge-remove" aria-label="Remove">
            <x-aura::icon name="x" size="xs" />
        </button>
    @endif
</span>
