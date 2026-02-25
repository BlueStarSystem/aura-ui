@props([
    'value' => 0,
    'size' => 'md',
    'color' => 'primary',
    'showLabel' => true,
    'thickness' => null,
])

@php
    $val = max(0, min(100, (int)$value));

    $dimensions = match($size) {
        'sm' => ['size' => 48, 'stroke' => 4, 'text' => 'text-xs'],
        'lg' => ['size' => 96, 'stroke' => 8, 'text' => 'text-xl'],
        'xl' => ['size' => 128, 'stroke' => 10, 'text' => 'text-2xl'],
        default => ['size' => 64, 'stroke' => 6, 'text' => 'text-sm'],
    };

    $strokeWidth = $thickness ?? $dimensions['stroke'];
    $svgSize = $dimensions['size'];
    $radius = ($svgSize / 2) - $strokeWidth;
    $circumference = 2 * M_PI * $radius;
    $offset = $circumference - ($val / 100) * $circumference;

    $colorClass = match($color) {
        'success' => 'text-aura-success-500',
        'danger' => 'text-aura-danger-500',
        'warning' => 'text-aura-warning-500',
        'info' => 'text-aura-info-500',
        default => 'text-aura-primary-500',
    };
@endphp

<div {{ $attributes->class(['aura-radial-progress inline-flex items-center justify-center relative', $colorClass]) }}
     role="progressbar"
     aria-valuenow="{{ $val }}"
     aria-valuemin="0"
     aria-valuemax="100">
    <svg width="{{ $svgSize }}" height="{{ $svgSize }}" viewBox="0 0 {{ $svgSize }} {{ $svgSize }}" class="transform -rotate-90">
        <circle cx="{{ $svgSize / 2 }}" cy="{{ $svgSize / 2 }}" r="{{ $radius }}"
                fill="none" stroke="currentColor" stroke-width="{{ $strokeWidth }}"
                class="opacity-15" />
        <circle cx="{{ $svgSize / 2 }}" cy="{{ $svgSize / 2 }}" r="{{ $radius }}"
                fill="none" stroke="currentColor" stroke-width="{{ $strokeWidth }}"
                stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $offset }}"
                stroke-linecap="round"
                class="aura-transition" />
    </svg>
    @if($showLabel)
        <span class="absolute inset-0 flex items-center justify-center font-semibold {{ $dimensions['text'] }}">
            {{ $slot->isEmpty() ? $val . '%' : $slot }}
        </span>
    @endif
</div>
