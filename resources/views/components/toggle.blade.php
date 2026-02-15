@props([
    'label' => null,
    'description' => null,
    'size' => 'md',
    'color' => 'primary',
    'disabled' => false,
])

@php
    $toggleClass = 'aura-toggle aura-toggle-' . $size . ' aura-toggle-' . $color;
@endphp

<label class="aura-toggle-wrapper" @if($disabled) aria-disabled="true" @endif>
    <input
        type="checkbox"
        class="aura-toggle-input"
        @if($disabled) disabled @endif
        {{ $attributes }}
    />
    <span class="{{ $toggleClass }}">
        <span class="aura-toggle-knob"></span>
    </span>
    @if($label)
        <span class="aura-toggle-text">
            <span class="aura-toggle-label">{{ $label }}</span>
            @if($description)
                <span class="aura-toggle-description">{{ $description }}</span>
            @endif
        </span>
    @endif
</label>
