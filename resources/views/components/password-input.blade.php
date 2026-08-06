@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'size' => 'md',
    'revealable' => true,
])

@php
    use BlueStarSystem\AuraUI\Support\Html;

    $inputId = Html::fieldId($attributes->get('id'), $attributes->get('name'), $label);
    $descriptionId = $inputId.'-description';

    $describedBy = ($error || $hint)
        ? Html::describedBy($attributes->get('aria-describedby'), $descriptionId)
        : $attributes->get('aria-describedby');

    $sizeClasses = match($size) {
        'sm' => 'py-1.5 pl-2.5 pr-9 text-[13px]',
        'lg' => 'py-3.5 pl-[18px] pr-12 text-[15px]',
        default => 'py-2.5 pl-3.5 pr-10 text-sm',
    };
@endphp

<div class="aura-password-input aura-input-wrapper flex flex-col gap-1.5 w-full max-w-[340px] {{ $error ? 'aura-has-error' : '' }}"
     x-data="{ revealed: false }">
    @if($label)
        <x-aura::label :for="$inputId">{{ $label }}</x-aura::label>
    @endif

    <div class="aura-password-input-container relative">
        {{-- The type flips between password and text: a masked field that is
             really a text field with a font trick loses the browser's own
             password handling, including offering to save it. --}}
        <input
            x-bind:type="revealed ? 'text' : 'password'"
            type="password"
            id="{{ $inputId }}"
            @if($error) aria-invalid="true" @endif
            @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->except(['id', 'type', 'aria-describedby'])->class([
                'aura-input w-full font-[inherit] leading-normal text-aura-surface-900 bg-aura-surface-100',
                'border border-aura-surface-500 rounded-aura-md outline-none aura-transition box-border',
                'placeholder:text-aura-surface-400',
                'hover:border-aura-surface-600 hover:bg-aura-surface-50',
                'focus:border-aura-primary-500 focus:bg-aura-surface-0 focus:shadow-[var(--aura-glow-primary)]',
                $sizeClasses,
                'aura-input-error' => (bool) $error,
            ]) }}
        />

        @if($revealable)
            {{-- aria-pressed, not a label swap: a toggle button that reports its
                 own state is announced correctly however it is styled. --}}
            <button
                type="button"
                x-on:click="revealed = !revealed"
                x-bind:aria-pressed="revealed ? 'true' : 'false'"
                x-bind:aria-label="revealed ? {{ Js::from(__('aura-ui::messages.hide_password')) }} : {{ Js::from(__('aura-ui::messages.show_password')) }}"
                aria-pressed="false"
                aria-label="{{ __('aura-ui::messages.show_password') }}"
                class="aura-password-input-toggle absolute right-2 top-1/2 -translate-y-1/2 flex items-center justify-center rounded p-1 text-aura-surface-600 hover:text-aura-surface-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-aura-primary-600"
            >
                <span x-show="!revealed"><x-aura::icon name="eye" size="sm" /></span>
                <span x-show="revealed" x-cloak><x-aura::icon name="eye-off" size="sm" /></span>
            </button>
        @endif
    </div>

    @if($error)
        <p id="{{ $descriptionId }}" role="alert" class="aura-input-error-text text-xs text-aura-danger-500 font-medium">{{ $error }}</p>
    @elseif($hint)
        <p id="{{ $descriptionId }}" class="aura-input-hint text-xs text-aura-surface-600 leading-snug">{{ $hint }}</p>
    @endif
</div>
