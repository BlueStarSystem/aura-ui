@props([
    'current' => 0,
    'variant' => 'horizontal',
    'clickable' => false,
    'size' => 'md',
])

@php
    $classes = ['aura-steps', "aura-steps-{$variant}", "aura-steps-{$size}"];
@endphp

<div
    class="{{ implode(' ', $classes) }}"
    x-data="{ current: {{ (int)$current }} }"
    {{ $attributes }}
>
    <div class="aura-steps-list">
        {{ $slot }}
    </div>
</div>
