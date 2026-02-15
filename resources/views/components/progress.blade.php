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
    $barClasses = ['aura-progress-bar', "aura-progress-{$color}"];
    if ($striped) $barClasses[] = 'aura-progress-striped';
    if ($animated) $barClasses[] = 'aura-progress-animated';
@endphp

<div {{ $attributes->class(['aura-progress', "aura-progress-{$size}"]) }} role="progressbar" aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="{{ $max }}">
    <div class="aura-progress-track">
        <div class="{{ implode(' ', $barClasses) }}" style="width: {{ $percentage }}%">
            @if($label)
                <span class="aura-progress-label">{{ round($percentage) }}%</span>
            @endif
        </div>
    </div>
</div>
