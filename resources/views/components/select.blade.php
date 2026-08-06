@props([
    'label' => null,
    'placeholder' => null,
    'hint' => null,
    'error' => null,
    'disabled' => false,
    'size' => 'md',
])

@php
    use BlueStarSystem\AuraUI\Support\Html;

    // Stable across renders: uniqid() handed the field a different id on every
    // Livewire round trip, rewriting the label's `for` and the
    // aria-describedby that points at the error text.
    $inputId = Html::fieldId($attributes->get('id'), $attributes->get('name'), $label ?? null, Html::wireModelFrom($attributes->getAttributes()));
    $descriptionId = $inputId.'-description';

    // Merged, not replaced: the bag may already carry an aria-describedby the
    // application attached to its own help text.
    $describedBy = ($error || ($hint ?? null))
        ? Html::describedBy($attributes->get('aria-describedby'), $descriptionId)
        : $attributes->get('aria-describedby');
@endphp

@php
    $sizeClasses = match($size) {
        'sm' => 'aura-input-sm py-1.5 pl-2.5 pr-[38px] text-[13px]',
        'lg' => 'aura-input-lg py-3.5 pl-[18px] pr-[38px] text-[15px]',
        default => 'py-2.5 pl-3.5 pr-[38px] text-sm',
    };

    $selectClasses = [
        'aura-select',
        "aura-input-{$size}",
        'w-full font-[inherit] leading-normal text-aura-surface-900 bg-aura-surface-100 border border-aura-surface-500 rounded-aura-md outline-none cursor-pointer aura-transition box-border',
        'hover:border-aura-surface-600 hover:bg-aura-surface-50',
        'focus:border-aura-primary-500 focus:bg-aura-surface-0 focus:shadow-[var(--aura-glow-primary)]',
        $sizeClasses,
    ];
    if ($error) $selectClasses[] = 'aura-input-error';

    $wrapperClasses = ['aura-input-wrapper', 'flex flex-col gap-1.5 w-full max-w-[340px]'];
    if ($error) $wrapperClasses[] = 'aura-has-error';
@endphp

<div class="{{ implode(' ', $wrapperClasses) }}">
    @if($label)
        <label for="{{ $inputId }}" class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">{{ $label }}</label>
    @endif

    <select
        id="{{ $inputId }}"
        @if($disabled) disabled @endif
        @if($error) aria-invalid="true" @endif
        @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
        {{ $attributes->except(['id', 'aria-describedby'])->class($selectClasses) }}
    >
        @if($placeholder)
            <option value="" disabled selected>{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>

    @if($error)
        <p id="{{ $descriptionId }}" role="alert" class="aura-input-error-text text-xs text-aura-danger-500 font-medium flex items-center gap-1 aura-animate-shake">{{ $error }}</p>
    @elseif($hint)
        <p id="{{ $descriptionId }}" class="aura-input-hint text-xs text-aura-surface-400 leading-snug">{{ $hint }}</p>
    @endif
</div>
