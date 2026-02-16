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
    $sizeClasses = match($size) {
        'sm' => 'aura-input-sm py-1.5 px-2.5 text-[13px]',
        'lg' => 'aura-input-lg py-3.5 px-[18px] text-[15px]',
        default => 'py-2.5 px-3.5 text-sm',
    };

    $inputClasses = [
        'aura-input',
        "aura-input-{$size}",
        'w-full font-inherit leading-normal text-aura-surface-900 bg-aura-surface-100 border border-aura-surface-200 rounded-aura-md outline-none aura-transition box-border',
        'placeholder:text-aura-surface-400',
        'hover:border-aura-surface-300 hover:bg-aura-surface-50',
        'focus:border-aura-primary-500 focus:bg-aura-surface-0 focus:shadow-[var(--aura-glow-primary)]',
        $sizeClasses,
    ];
    if ($error) $inputClasses[] = 'aura-input-error';

    $wrapperClasses = ['aura-input-wrapper', 'flex flex-col gap-1.5 w-full max-w-[340px]'];
    if ($error) $wrapperClasses[] = 'aura-has-error';
@endphp

<div class="{{ implode(' ', $wrapperClasses) }}">
    @if($label)
        <label class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">{{ $label }}</label>
    @endif

    <div class="aura-input-container {{ ($prefixIcon || $prefix || $suffixIcon || $suffix) ? 'aura-input-group flex items-stretch rounded-aura-md overflow-hidden' : '' }} {{ ($prefixIcon || $prefix) ? 'aura-input-has-prefix' : '' }} {{ ($suffixIcon || $suffix) ? 'aura-input-has-suffix' : '' }}">
        @if($prefixIcon)
            <span class="aura-input-prefix aura-input-icon flex items-center px-3 text-[13px] text-aura-surface-400 bg-aura-surface-200 border border-aura-surface-200 border-r-0 whitespace-nowrap">
                <x-aura::icon :name="$prefixIcon" size="sm" />
            </span>
        @elseif($prefix)
            <span class="aura-input-prefix flex items-center px-3 text-[13px] text-aura-surface-400 bg-aura-surface-200 border border-aura-surface-200 border-r-0 whitespace-nowrap">{{ $prefix }}</span>
        @endif

        <input
            type="{{ $type }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            {{ $attributes->class($inputClasses) }}
        />

        @if($suffixIcon)
            <span class="aura-input-suffix aura-input-icon flex items-center px-3 text-[13px] text-aura-surface-400 bg-aura-surface-200 border border-aura-surface-200 border-l-0 whitespace-nowrap">
                <x-aura::icon :name="$suffixIcon" size="sm" />
            </span>
        @elseif($suffix)
            <span class="aura-input-suffix flex items-center px-3 text-[13px] text-aura-surface-400 bg-aura-surface-200 border border-aura-surface-200 border-l-0 whitespace-nowrap">{{ $suffix }}</span>
        @endif
    </div>

    @if($error)
        <p class="aura-input-error-text text-xs text-aura-danger-500 font-medium flex items-center gap-1 aura-animate-shake">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint text-xs text-aura-surface-400 leading-snug">{{ $hint }}</p>
    @endif
</div>
