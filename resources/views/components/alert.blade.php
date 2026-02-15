@props([
    'variant' => 'info',
    'icon' => null,
    'dismissible' => false,
    'bordered' => true,
])

@php
    $defaultIcons = [
        'info' => 'info',
        'success' => 'check-circle',
        'warning' => 'alert-triangle',
        'danger' => 'x-circle',
    ];
    $iconName = $icon ?? ($defaultIcons[$variant] ?? 'info');

    $classes = ['aura-alert', "aura-alert-{$variant}"];
    if ($bordered) $classes[] = 'aura-alert-bordered';
@endphp

<div
    {{ $attributes->class($classes) }}
    role="alert"
    @if($dismissible) x-data="{ show: true }" x-show="show" x-transition @endif
>
    <div class="aura-alert-icon">
        <x-aura::icon :name="$iconName" size="md" />
    </div>

    <div class="aura-alert-content">
        @if(isset($title))
            <h4 class="aura-alert-title">{{ $title }}</h4>
        @endif
        <div class="aura-alert-body">{{ $slot }}</div>
        @if(isset($actions))
            <div class="aura-alert-actions">{{ $actions }}</div>
        @endif
    </div>

    @if($dismissible)
        <button type="button" class="aura-alert-dismiss" x-on:click="show = false" aria-label="Chiudi">
            <x-aura::icon name="x" size="sm" />
        </button>
    @endif
</div>
