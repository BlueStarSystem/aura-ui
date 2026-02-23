@props([
    'logo' => null,
    'name' => null,
    'href' => '/',
    'size' => 'md',
])

@php
    $sizeClasses = match($size) {
        'sm' => ['h-6 w-6', 'text-sm'],
        'lg' => ['h-10 w-10', 'text-xl'],
        default => ['h-8 w-8', 'text-base'],
    };
@endphp

<a href="{{ $href }}" {{ $attributes->class(['aura-brand inline-flex items-center gap-2.5 no-underline']) }}>
    @if($logo)
        <img src="{{ $logo }}" alt="{{ $name ?? '' }}" class="aura-brand-logo {{ $sizeClasses[0] }} object-contain" />
    @endif
    @if($name)
        <span class="aura-brand-name font-semibold text-aura-surface-900 {{ $sizeClasses[1] }}">{{ $name }}</span>
    @endif
    @if(!$logo && !$name)
        {{ $slot }}
    @endif
</a>
