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
    $textareaClasses = [
        'aura-textarea',
        "aura-input-{$size}",
        'w-full min-h-[100px] py-2.5 px-3.5 font-[inherit] text-sm leading-relaxed text-aura-surface-900 bg-aura-surface-100 border border-aura-surface-200 rounded-aura-md outline-none resize-y aura-transition box-border',
        'placeholder:text-aura-surface-400',
        'hover:border-aura-surface-300 hover:bg-aura-surface-50',
        'focus:border-aura-primary-500 focus:bg-aura-surface-0 focus:shadow-[var(--aura-glow-primary)]',
    ];
    if ($error) $textareaClasses[] = 'aura-input-error';

    $wrapperClasses = ['aura-input-wrapper', 'flex flex-col gap-1.5 w-full max-w-[340px]'];
    if ($error) $wrapperClasses[] = 'aura-has-error';
@endphp

<div class="{{ implode(' ', $wrapperClasses) }}" @if($characterCount || $autoResize) x-data="{ count: 0 }" @endif>
    @if($label)
        <label class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">{{ $label }}</label>
    @endif

    <textarea
        rows="{{ $rows }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        @if($characterCount) x-on:input="count = $el.value.length" @endif
        @if($autoResize) x-on:input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" @endif
        {{ $attributes->class($textareaClasses) }}
    ></textarea>

    <div class="aura-input-footer">
        @if($error)
            <p class="aura-input-error-text text-xs text-aura-danger-500 font-medium flex items-center gap-1 aura-animate-shake">{{ $error }}</p>
        @elseif($hint)
            <p class="aura-input-hint text-xs text-aura-surface-400 leading-snug">{{ $hint }}</p>
        @endif

        @if($characterCount && $maxlength)
            <span class="aura-character-count text-xs text-aura-surface-400" x-text="count + '/{{ $maxlength }}'">0/{{ $maxlength }}</span>
        @endif
    </div>
</div>
