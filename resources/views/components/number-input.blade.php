@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'min' => null,
    'max' => null,
    'step' => 1,
    'size' => 'md',
    'controls' => true,
])

@php
    use BlueStarSystem\AuraUI\Support\Html;

    $inputId = Html::fieldId($attributes->get('id'), $attributes->get('name'), $label, Html::wireModelFrom($attributes->getAttributes()));
    $descriptionId = $inputId.'-description';

    $describedBy = ($error || $hint)
        ? Html::describedBy($attributes->get('aria-describedby'), $descriptionId)
        : $attributes->get('aria-describedby');

    $sizeClasses = match($size) {
        'sm' => 'py-1.5 px-2.5 text-[13px]',
        'lg' => 'py-3.5 px-[18px] text-[15px]',
        default => 'py-2.5 px-3.5 text-sm',
    };
@endphp

<div class="aura-number-input aura-input-wrapper flex flex-col gap-1.5 w-full max-w-[340px] {{ $error ? 'aura-has-error' : '' }}">
    @if($label)
        <x-aura::label :for="$inputId">{{ $label }}</x-aura::label>
    @endif

    {{-- x-data, empty but required: $refs only resolves inside an Alpine scope. --}}
    <div class="aura-number-input-container flex items-stretch" x-data="{}">
        @if($controls)
            <button
                type="button"
                x-on:click="$refs.field.stepDown(); $refs.field.dispatchEvent(new Event('input', { bubbles: true }))"
                aria-label="{{ __('aura-ui::messages.decrease') }}"
                tabindex="-1"
                class="aura-number-input-step flex items-center justify-center px-3 rounded-l-aura-md border border-r-0 border-aura-surface-500 bg-aura-surface-200 text-aura-surface-700 hover:bg-aura-surface-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-aura-primary-600"
            >&minus;</button>
        @endif

        {{-- The wheel is not a control: scrolling past a focused number field
             silently changes the value, which is a classic way to submit a
             quantity nobody typed. --}}
        <input
            x-ref="field"
            type="number"
            id="{{ $inputId }}"
            inputmode="decimal"
            x-on:wheel.prevent
            @if($min !== null) min="{{ $min }}" @endif
            @if($max !== null) max="{{ $max }}" @endif
            step="{{ $step }}"
            @if($error) aria-invalid="true" @endif
            @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->except(['id', 'type', 'aria-describedby'])->class([
                'aura-input w-full font-[inherit] leading-normal text-aura-surface-900 bg-aura-surface-100',
                'border border-aura-surface-500 outline-none aura-transition box-border text-center',
                'hover:border-aura-surface-600 hover:bg-aura-surface-50',
                'focus:border-aura-primary-500 focus:bg-aura-surface-0 focus:shadow-[var(--aura-glow-primary)]',
                'focus:relative focus:z-10',
                $controls ? '' : 'rounded-aura-md',
                $sizeClasses,
                'aura-input-error' => (bool) $error,
            ]) }}
        />

        @if($controls)
            <button
                type="button"
                x-on:click="$refs.field.stepUp(); $refs.field.dispatchEvent(new Event('input', { bubbles: true }))"
                aria-label="{{ __('aura-ui::messages.increase') }}"
                tabindex="-1"
                class="aura-number-input-step flex items-center justify-center px-3 rounded-r-aura-md border border-l-0 border-aura-surface-500 bg-aura-surface-200 text-aura-surface-700 hover:bg-aura-surface-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-aura-primary-600"
            >+</button>
        @endif
    </div>

    @if($error)
        <p id="{{ $descriptionId }}" role="alert" class="aura-input-error-text text-xs text-aura-danger-500 font-medium">{{ $error }}</p>
    @elseif($hint)
        <p id="{{ $descriptionId }}" class="aura-input-hint text-xs text-aura-surface-600 leading-snug">{{ $hint }}</p>
    @endif
</div>
