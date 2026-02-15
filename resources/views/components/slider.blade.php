@props([
    'label' => null,
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'showValue' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'color' => 'primary',
    'prefix' => null,
    'suffix' => null,
])

<div
    {{ $attributes->class(['aura-slider-wrapper']) }}
    x-data="{
        value: @entangle($attributes->wire('model')),
        min: {{ $min }},
        max: {{ $max }},

        get percentage() {
            return ((this.value - this.min) / (this.max - this.min)) * 100;
        }
    }"
>
    @if($label || $showValue)
        <div class="aura-slider-header">
            @if($label)
                <label class="aura-label">{{ $label }}</label>
            @endif
            @if($showValue)
                <span class="aura-slider-value">
                    @if($prefix){{ $prefix }}@endif<span x-text="value"></span>@if($suffix){{ $suffix }}@endif
                </span>
            @endif
        </div>
    @endif

    <div class="aura-slider-track-wrapper">
        <input
            type="range"
            class="aura-slider aura-slider-{{ $color }}"
            x-model="value"
            min="{{ $min }}"
            max="{{ $max }}"
            step="{{ $step }}"
            @if($disabled) disabled @endif
            style="--aura-slider-progress: calc(var(--percentage, 0) * 1%)"
            x-bind:style="'--aura-slider-progress: ' + percentage + '%'"
        />
    </div>

    <div class="aura-slider-labels">
        <span class="aura-slider-min">{{ $prefix }}{{ $min }}{{ $suffix }}</span>
        <span class="aura-slider-max">{{ $prefix }}{{ $max }}{{ $suffix }}</span>
    </div>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
