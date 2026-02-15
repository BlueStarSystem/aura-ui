@props([
    'label' => null,
    'description' => null,
    'value' => null,
    'name' => null,
    'disabled' => false,
])

<label class="aura-radio-wrapper" @if($disabled) aria-disabled="true" @endif>
    <input
        type="radio"
        class="aura-radio"
        @if($value) value="{{ $value }}" @endif
        @if($name) name="{{ $name }}" @endif
        @if($disabled) disabled @endif
        {{ $attributes }}
    />
    <span class="aura-radio-circle"></span>
    @if($label)
        <span class="aura-radio-text">
            <span class="aura-radio-label">{{ $label }}</span>
            @if($description)
                <span class="aura-radio-description">{{ $description }}</span>
            @endif
        </span>
    @endif
</label>
