@props([
    'title' => '',
    'description' => null,
    'time' => null,
    'read' => false,
    'icon' => 'heroicon-o-bell',
    'color' => 'primary',
    'url' => null,
])

@php
    $tag = $url ? 'a' : 'div';
    $extraAttrs = $url ? 'href="' . e($url) . '"' : '';
@endphp

<{{ $tag }}
    {!! $extraAttrs !!}
    {{ $attributes->class([
        'aura-notification-center__item',
        'aura-notification-center__item--unread' => ! $read,
        'aura-notification-center__item--' . $color,
    ]) }}
>
    <div class="aura-notification-center__item-icon">
        <x-aura::icon :name="$icon" class="w-4 h-4" />
    </div>
    <div class="aura-notification-center__item-body">
        <span class="aura-notification-center__item-title">{{ $title }}</span>
        @if ($description)
            <span class="aura-notification-center__item-desc">{{ $description }}</span>
        @endif
        @if ($time)
            <span class="aura-notification-center__item-time">{{ $time }}</span>
        @endif
    </div>
</{{ $tag }}>
