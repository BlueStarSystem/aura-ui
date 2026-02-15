@props([
    'label' => null,
    'description' => null,
    'value' => null,
    'disabled' => false,
])

<label class="aura-checkbox-wrapper" @if($disabled) aria-disabled="true" @endif>
    <input
        type="checkbox"
        class="aura-checkbox"
        @if($value) value="{{ $value }}" @endif
        @if($disabled) disabled @endif
        {{ $attributes }}
    />
    <span class="aura-checkbox-box">
        <svg class="aura-checkbox-icon" viewBox="0 0 12 12" fill="none">
            <path d="M2.5 6L5 8.5L9.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </span>
    @if($label)
        <span class="aura-checkbox-text">
            <span class="aura-checkbox-label">{{ $label }}</span>
            @if($description)
                <span class="aura-checkbox-description">{{ $description }}</span>
            @endif
        </span>
    @endif
</label>
