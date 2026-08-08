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

    // An aria-label passed by the caller has to reach the range input; left in
    // the attribute bag it lands on the wrapper div, where it names nothing.
    $sliderAriaLabel = $attributes->get('aria-label');
    $attributes = $attributes->except('aria-label');
@endphp

<div
    {{ $attributes->class(['aura-slider-wrapper flex flex-col gap-2']) }}
    x-data="{
        value: @if($attributes->wire('model')->value()) $wire.entangle({{ Js::from($attributes->wire('model')->value()) }}){{ $attributes->wire('model')->hasModifier('live') ? '.live' : '' }} @else {{ (float) ($value ?? $min) }} @endif,
        min: {{ (float) $min }},
        max: {{ (float) $max }},

        get percentage() {
            return ((this.value - this.min) / (this.max - this.min)) * 100;
        }
    }"
>
    @php
        $sliderId = $attributes->get('id') ?: 'aura-slider-'.\Illuminate\Support\Str::random(8);
        $sliderDescribedBy = $error ? $sliderId.'-error' : ($hint ? $sliderId.'-hint' : null);
    @endphp

    @if($label || $showValue)
        <div class="aura-slider-header flex items-center justify-between">
            @if($label)
                {{-- The `for` is the whole point: without it the label sits beside
                     the track and names nothing, and the range input is announced
                     with no name at all. --}}
                <label class="aura-label" for="{{ $sliderId }}">{{ $label }}</label>
            @endif
            @if($showValue)
                <span class="aura-slider-value text-sm font-medium text-aura-surface-700">
                    @if($prefix){{ $prefix }}@endif<span x-text="value"></span>@if($suffix){{ $suffix }}@endif
                </span>
            @endif
        </div>
    @endif

    {{-- No vertical padding: the input now carries 24px of its own height so a
         pointer has somewhere to land. --}}
    <div class="aura-slider-track-wrapper flex items-center">
        <input
            type="range"
            id="{{ $sliderId }}"
            class="aura-slider aura-slider-{{ $color }}"
            x-model="value"
            min="{{ $min }}"
            max="{{ $max }}"
            step="{{ $step }}"
            @unless($label) aria-label="{{ $sliderAriaLabel ?: __('aura-ui::messages.value') }}" @endunless
            @if($sliderDescribedBy) aria-describedby="{{ $sliderDescribedBy }}" @endif
            @if($error) aria-invalid="true" @endif
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
        <p role="alert" class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
