@props([
    'src' => null,
    'name' => null,
    'initials' => null,
    'alt' => '',
    'size' => 'md',
    'color' => null,
    'status' => null,
    'rounded' => 'full',
])

@php
    // Auto-generate initials from name
    if (!$initials && $name) {
        $parts = preg_split('/\s+/', trim($name));
        $initials = count($parts) >= 2
            ? mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr(end($parts), 0, 1))
            : mb_strtoupper(mb_substr($name, 0, 2));
    }

    // Auto-pick color from name hash (consistent per person)
    $avatarColors = ['primary', 'success', 'warning', 'danger', 'info', 'purple', 'pink', 'teal', 'orange', 'indigo'];
    if (!$color && $name) {
        $hash = crc32($name);
        $color = $avatarColors[abs($hash) % count($avatarColors)];
    }
    $color = $color ?? 'primary';

    $classes = ['aura-avatar', "aura-avatar-{$size}", "aura-avatar-rounded-{$rounded}"];
    if (!$src) $classes[] = "aura-avatar-color-{$color}";
@endphp

<div {{ $attributes->class($classes) }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt ?? $name }}" class="aura-avatar-img" />
    @elseif($initials)
        <span class="aura-avatar-initials">{{ $initials }}</span>
    @else
        <x-aura::icon name="user" size="{{ $size === 'xs' ? 'xs' : ($size === 'sm' ? 'sm' : 'md') }}" />
    @endif

    @if($status)
        <span class="aura-avatar-status aura-avatar-status-{{ $status }}"></span>
    @endif
</div>
