@props([
    'label' => null,
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'value' => null,
    'showValue' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'color' => 'primary',
    'prefix' => null,
    'suffix' => null,
])

@php
    $initialValue = $value ?? $min;
    $initialPercentage = $max > $min ? (($initialValue - $min) / ($max - $min)) * 100 : 0;
@endphp

<div
    {{ $attributes->class(['aura-slider-wrapper flex flex-col gap-2']) }}
    x-data="{
        value: @if($attributes->wire('model')->value()) $wire.entangle('{{ $attributes->wire('model')->value() }}'){{ $attributes->wire('model')->hasModifier('live') ? '.live' : '' }} @else {{ $value ?? $min }} @endif,
        min: {{ $min }},
        max: {{ $max }},

        get percentage() {
            return ((this.value - this.min) / (this.max - this.min)) * 100;
        }
    }"
>
    @if($label || $showValue)
        <div class="aura-slider-header flex items-center justify-between">
            @if($label)
                <label class="aura-label">{{ $label }}</label>
            @endif
            @if($showValue)
                <span class="aura-slider-value text-sm font-medium text-aura-surface-700">
                    @if($prefix){{ $prefix }}@endif<span x-text="value"></span>@if($suffix){{ $suffix }}@endif
                </span>
            @endif
        </div>
    @endif

    <div class="aura-slider-track-wrapper py-1">
        <input
            type="range"
            class="aura-slider aura-slider-{{ $color }}"
            x-model="value"
            min="{{ $min }}"
            max="{{ $max }}"
            step="{{ $step }}"
            @if($disabled) disabled @endif
            style="--aura-slider-progress: {{ $initialPercentage }}%"
            x-bind:style="'--aura-slider-progress: ' + percentage + '%'"
        />
    </div>

    <div class="aura-slider-labels flex justify-between text-xs text-aura-surface-400">
        <span class="aura-slider-min">{{ $prefix }}{{ $min }}{{ $suffix }}</span>
        <span class="aura-slider-max">{{ $prefix }}{{ $max }}{{ $suffix }}</span>
    </div>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
