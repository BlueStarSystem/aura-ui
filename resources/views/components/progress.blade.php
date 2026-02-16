@props([
    'value' => 0,
    'max' => 100,
    'color' => 'primary',
    'size' => 'md',
    'label' => false,
    'animated' => false,
    'striped' => false,
])

@php
    $percentage = min(100, max(0, ($value / $max) * 100));

    $trackHeight = match($size) {
        'sm' => 'h-1.5',
        'lg' => 'h-4',
        default => 'h-2.5',
    };

    $colorClass = match($color) {
        'secondary' => 'bg-gradient-to-r from-aura-secondary-500 to-aura-info-500',
        'success' => 'bg-gradient-to-r from-aura-success-500 to-aura-success-600',
        'warning' => 'bg-gradient-to-r from-aura-warning-400 to-aura-warning-600',
        'danger' => 'bg-gradient-to-r from-aura-danger-500 to-aura-danger-600',
        default => 'bg-gradient-to-r from-aura-primary-500 to-aura-primary-700',
    };

    $barClasses = ['aura-progress-bar', "aura-progress-{$color}", $colorClass, 'h-full rounded-aura-full transition-[width] duration-[600ms] ease-aura-out flex items-center justify-end pr-2 min-w-0'];
    if ($striped) $barClasses[] = 'aura-progress-striped';
    if ($animated) $barClasses[] = 'aura-progress-animated';
@endphp

<div {{ $attributes->class(['aura-progress', "aura-progress-{$size}", 'w-full']) }} role="progressbar" aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="{{ $max }}">
    <div class="aura-progress-track w-full bg-aura-surface-200 rounded-aura-full overflow-hidden {{ $trackHeight }}">
        <div class="{{ implode(' ', $barClasses) }}" style="width: {{ $percentage }}%">
            @if($label && $size !== 'sm')
                <span class="aura-progress-label text-[10px] font-semibold text-white whitespace-nowrap [text-shadow:0_1px_2px_rgba(0,0,0,0.2)]">{{ round($percentage) }}%</span>
            @endif
        </div>
    </div>
</div>
