@props([
    'padding' => 'md',
    'shadow' => 'md',
    'hover' => false,
    'bordered' => true,
    'glass' => false,
])

@php
    $classes = ['aura-card', "aura-card-shadow-{$shadow}", "aura-card-padding-{$padding}"];
    if ($hover) $classes[] = 'aura-card-hover';
    if ($bordered) $classes[] = 'aura-card-bordered';
    if ($glass) $classes[] = 'aura-glass';
@endphp

<div {{ $attributes->class($classes) }}>
    @if(isset($header))
        <div class="aura-card-header">
            {{ $header }}
        </div>
    @endif

    <div class="aura-card-body">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="aura-card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
