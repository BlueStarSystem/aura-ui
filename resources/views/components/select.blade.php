@props([
    'label' => null,
    'placeholder' => null,
    'hint' => null,
    'error' => null,
    'disabled' => false,
    'size' => 'md',
])

@php
    $sizeClasses = match($size) {
        'sm' => 'aura-input-sm py-1.5 pl-2.5 pr-[38px] text-[13px]',
        'lg' => 'aura-input-lg py-3.5 pl-[18px] pr-[38px] text-[15px]',
        default => 'py-2.5 pl-3.5 pr-[38px] text-sm',
    };

    $selectClasses = [
        'aura-select',
        "aura-input-{$size}",
        'w-full font-[inherit] leading-normal text-aura-surface-900 bg-aura-surface-100 border border-aura-surface-200 rounded-aura-md outline-none cursor-pointer aura-transition box-border',
        'hover:border-aura-surface-300 hover:bg-aura-surface-50',
        'focus:border-aura-primary-500 focus:bg-aura-surface-0 focus:shadow-[var(--aura-glow-primary)]',
        $sizeClasses,
    ];
    if ($error) $selectClasses[] = 'aura-input-error';

    $wrapperClasses = ['aura-input-wrapper', 'flex flex-col gap-1.5 w-full max-w-[340px]'];
    if ($error) $wrapperClasses[] = 'aura-has-error';
@endphp

<div class="{{ implode(' ', $wrapperClasses) }}">
    @if($label)
        <label class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">{{ $label }}</label>
    @endif

    <select
        @if($disabled) disabled @endif
        {{ $attributes->class($selectClasses) }}
    >
        @if($placeholder)
            <option value="" disabled selected>{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>

    @if($error)
        <p class="aura-input-error-text text-xs text-aura-danger-500 font-medium flex items-center gap-1 aura-animate-shake">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint text-xs text-aura-surface-400 leading-snug">{{ $hint }}</p>
    @endif
</div>
