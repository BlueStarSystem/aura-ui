@props([
    'label' => null,
    'placeholder' => null,
    'hint' => null,
    'error' => null,
    'rows' => 3,
    'autoResize' => false,
    'characterCount' => false,
    'maxlength' => null,
    'disabled' => false,
    'readonly' => false,
    'size' => 'md',
])

@php
    $textareaClass = 'aura-textarea aura-input-' . $size;
    if ($error) $textareaClass .= ' aura-input-error';
@endphp

<div class="aura-input-wrapper" @if($characterCount || $autoResize) x-data="{ count: 0 }" @endif>
    @if($label)
        <label class="aura-label">{{ $label }}</label>
    @endif

    <textarea
        rows="{{ $rows }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        @if($characterCount) x-on:input="count = $el.value.length" @endif
        @if($autoResize) x-on:input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" @endif
        {{ $attributes->class([$textareaClass]) }}
    ></textarea>

    <div class="aura-input-footer">
        @if($error)
            <p class="aura-input-error-text">{{ $error }}</p>
        @elseif($hint)
            <p class="aura-input-hint">{{ $hint }}</p>
        @endif

        @if($characterCount && $maxlength)
            <span class="aura-character-count" x-text="count + '/{{ $maxlength }}'">0/{{ $maxlength }}</span>
        @endif
    </div>
</div>
