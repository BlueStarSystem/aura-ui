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
    if (!$initials && $name) {
        $parts = preg_split('/\s+/', trim($name));
        $initials = count($parts) >= 2
            ? mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr(end($parts), 0, 1))
            : mb_strtoupper(mb_substr($name, 0, 2));
    }

    $avatarColors = ['primary', 'success', 'warning', 'danger', 'info', 'purple', 'pink', 'teal', 'orange', 'indigo'];
    if (!$color && $name) {
        $hash = crc32($name);
        $color = $avatarColors[abs($hash) % count($avatarColors)];
    }
    $color = $color ?? 'primary';

    $sizeClasses = match($size) {
        'xs' => 'aura-avatar-xs w-6 h-6 text-[10px]',
        'sm' => 'aura-avatar-sm w-8 h-8 text-xs',
        'lg' => 'aura-avatar-lg w-12 h-12 text-lg',
        'xl' => 'aura-avatar-xl w-16 h-16 text-2xl',
        default => 'aura-avatar-md w-10 h-10 text-sm',
    };

    $classes = [
        'aura-avatar',
        "aura-avatar-{$size}",
        "aura-avatar-rounded-{$rounded}",
        'relative inline-flex items-center justify-center rounded-full overflow-visible text-white font-semibold shrink-0 aura-transition',
        $sizeClasses,
    ];
    if (!$src) $classes[] = "aura-avatar-color-{$color}";
@endphp

<div {{ $attributes->class($classes) }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt ?? $name }}" class="aura-avatar-img w-full h-full object-cover rounded-full" />
    @elseif($initials)
        <span class="aura-avatar-initials">{{ $initials }}</span>
    @else
        <x-aura::icon name="user" size="{{ $size === 'xs' ? 'xs' : ($size === 'sm' ? 'sm' : 'md') }}" />
    @endif

    @if($status)
        <span class="aura-avatar-status aura-avatar-status-{{ $status }}"></span>
    @endif
</div>
