@props([
    'name' => '',
    'subtitle' => null,
    'src' => null,
    'size' => 'md',
    'href' => null,
])

@php
    $sizeMap = match($size) {
        'sm' => ['avatar' => 'sm', 'name' => 'text-sm', 'subtitle' => 'text-xs'],
        'lg' => ['avatar' => 'lg', 'name' => 'text-lg', 'subtitle' => 'text-sm'],
        default => ['avatar' => 'md', 'name' => 'text-base', 'subtitle' => 'text-xs'],
    };

    $initials = collect(explode(' ', $name))->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->join('');
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }} @if($href) href="{{ $href }}" @endif {{ $attributes->class(['aura-profile inline-flex items-center gap-3', $href ? 'no-underline hover:opacity-80 aura-transition-fast' : '']) }}>
    <x-aura::avatar :src="$src" :initials="$initials" :size="$sizeMap['avatar']" />
    <div class="aura-profile-info flex flex-col min-w-0">
        <span class="aura-profile-name font-medium text-aura-surface-900 truncate {{ $sizeMap['name'] }}">{{ $name }}</span>
        @if($subtitle)
            <span class="aura-profile-subtitle text-aura-surface-500 truncate {{ $sizeMap['subtitle'] }}">{{ $subtitle }}</span>
        @endif
    </div>
</{{ $tag }}>
