@props([
    'label' => null,
    'type' => 'text',
    'placeholder' => null,
    'hint' => null,
    'error' => null,
    'prefix' => null,
    'suffix' => null,
    'prefixIcon' => null,
    'suffixIcon' => null,
    'clearable' => false,
    'disabled' => false,
    'readonly' => false,
    'size' => 'md',
])

@php
    $wrapperClass = 'aura-input-wrapper';
    $inputClass = 'aura-input aura-input-' . $size;
    if ($error) $inputClass .= ' aura-input-error';
    if ($prefixIcon || $prefix) $inputClass .= ' aura-input-has-prefix';
    if ($suffixIcon || $suffix) $inputClass .= ' aura-input-has-suffix';
@endphp

<div class="{{ $wrapperClass }}">
    @if($label)
        <label class="aura-label">{{ $label }}</label>
    @endif

    <div class="aura-input-container">
        @if($prefixIcon)
            <span class="aura-input-prefix aura-input-icon">
                <x-aura::icon :name="$prefixIcon" size="sm" />
            </span>
        @elseif($prefix)
            <span class="aura-input-prefix">{{ $prefix }}</span>
        @endif

        <input
            type="{{ $type }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            {{ $attributes->class([$inputClass]) }}
        />

        @if($suffixIcon)
            <span class="aura-input-suffix aura-input-icon">
                <x-aura::icon :name="$suffixIcon" size="sm" />
            </span>
        @elseif($suffix)
            <span class="aura-input-suffix">{{ $suffix }}</span>
        @endif
    </div>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
