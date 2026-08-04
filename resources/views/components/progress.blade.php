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

    // When striped/animated, use solid background-color instead of gradient
    // because both gradient and stripes use background-image and conflict.
    $colorClass = ($striped || $animated)
        ? match($color) {
            'secondary' => 'bg-aura-secondary-700 dark:bg-aura-secondary-300',
            'success' => 'bg-aura-success-700 dark:bg-aura-success-300',
            'warning' => 'bg-aura-warning-700 dark:bg-aura-warning-300',
            'danger' => 'bg-aura-danger-500 dark:bg-aura-danger-300',
            default => 'bg-aura-primary-600 dark:bg-aura-primary-300',
        }
        : match($color) {
            'secondary' => 'bg-gradient-to-r from-aura-secondary-700 to-aura-info-700 dark:from-aura-secondary-300 dark:to-aura-info-300',
            'success' => 'bg-gradient-to-r from-aura-success-700 to-aura-success-700 dark:from-aura-success-300 dark:to-aura-success-300',
            'warning' => 'bg-gradient-to-r from-aura-warning-700 to-aura-warning-700 dark:from-aura-warning-300 dark:to-aura-warning-300',
            'danger' => 'bg-gradient-to-r from-aura-danger-700 to-aura-danger-700 dark:from-aura-danger-300 dark:to-aura-danger-300',
            default => 'bg-gradient-to-r from-aura-primary-700 to-aura-primary-900 dark:from-aura-primary-300 dark:to-aura-primary-300',
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
