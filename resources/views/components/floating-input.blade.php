@props([
    'name' => '',
    'label' => '',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'disabled' => false,
    'error' => null,
])

@php
    use BlueStarSystem\AuraUI\Support\Html;

    // Stable across renders: uniqid() gave the field a new id on every Livewire
    // round trip, rewriting the label's `for` and the aria-describedby.
    $inputId = Html::fieldId($attributes->get('id'), $name, $label);
    $descriptionId = $inputId.'-description';

    $describedBy = $error
        ? Html::describedBy($attributes->get('aria-describedby'), $descriptionId)
        : $attributes->get('aria-describedby');
@endphp

<div
    {{ $attributes->only('class')->class([
        'aura-floating-input',
        'aura-floating-input--error' => (bool) $error,
        'aura-floating-input--disabled' => $disabled,
    ]) }}
    x-data="{
        focused: false,
        filled: {{ $value ? 'true' : 'false' }},
        get active() { return this.focused || this.filled; },
    }"
>
    <div class="aura-floating-input__field">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $inputId }}"
            @if($value) value="{{ $value }}" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($error) aria-invalid="true" @endif
            @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
            class="aura-floating-input__input"
            :class="{ 'aura-floating-input__input--active': active }"
            x-on:focus="focused = true"
            x-on:blur="focused = false; filled = $el.value.length > 0"
            x-on:input="filled = $el.value.length > 0"
            {{ $attributes->except(['class', 'id', 'aria-describedby']) }}
        />
        <label
            for="{{ $inputId }}"
            class="aura-floating-input__label"
            :class="{ 'aura-floating-input__label--float': active }"
        >
            {{ $label }}
            @if ($required)
                <span class="aura-floating-input__required">*</span>
            @endif
        </label>
    </div>

    @if ($error)
        {{-- role="alert" so an error inserted after a Livewire submit is
             announced immediately, not only when the user returns to the field. --}}
        <p id="{{ $descriptionId }}" role="alert" class="aura-floating-input__error">{{ $error }}</p>
    @endif
</div>
