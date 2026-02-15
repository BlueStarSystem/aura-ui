@props([
    'label' => null,
    'placeholder' => null,
    'hint' => null,
    'error' => null,
    'disabled' => false,
    'size' => 'md',
])

@php
    $selectClass = 'aura-select aura-input-' . $size;
    if ($error) $selectClass .= ' aura-input-error';
@endphp

<div class="aura-input-wrapper">
    @if($label)
        <label class="aura-label">{{ $label }}</label>
    @endif

    <select
        @if($disabled) disabled @endif
        {{ $attributes->class([$selectClass]) }}
    >
        @if($placeholder)
            <option value="" disabled selected>{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
