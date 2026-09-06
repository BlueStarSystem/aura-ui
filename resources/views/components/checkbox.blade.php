@props([
    'label' => null,
    'description' => null,
    'value' => null,
    'disabled' => false,
    'error' => null,
])

@php
    use BlueStarSystem\AuraUI\Support\Html;

    // The label may carry markup (a consent line with links to the terms and
    // the privacy policy is the common case), so the default slot is the label
    // when the prop is not given.
    $labelContent = $label ?? (Html::slotIsEmpty($slot) ? null : $slot);

    $fieldId = Html::fieldId($attributes->get('id'), $attributes->get('name'), $label);
    $descriptionId = $description ? 'aura-checkbox-desc-'.$fieldId : null;
    $errorId = $error ? 'aura-checkbox-error-'.$fieldId : null;

    $describedBy = Html::describedBy($attributes->get('aria-describedby'), $descriptionId, $errorId);
@endphp

@if($error)
<div class="aura-checkbox-field flex flex-col gap-1">
@endif
<label class="aura-checkbox flex items-start gap-2.5 cursor-pointer relative select-none" @if($disabled) aria-disabled="true" @endif>
    <input
        type="checkbox"
        @if($value) value="{{ $value }}" @endif
        @if($disabled) disabled @endif
        @if($error) aria-invalid="true" @endif
        @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
        {{ $attributes->except('aria-describedby') }}
    />
    <span class="aura-checkbox-box shrink-0 w-[18px] h-[18px] mt-px border-2 {{ $error ? 'border-aura-danger-600' : 'border-aura-surface-500' }} rounded-[5px] bg-aura-surface-0 flex items-center justify-center aura-transition">
        <svg class="aura-checkbox-icon w-3 h-3 stroke-white stroke-[3] fill-none" viewBox="0 0 12 12" fill="none" aria-hidden="true" focusable="false">
            <path d="M2.5 6L5 8.5L9.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </span>
    @if($labelContent)
        <span class="aura-checkbox-content flex flex-col gap-0.5">
            <span class="aura-checkbox-label text-sm font-[450] text-aura-surface-900 leading-snug">{{ $labelContent }}</span>
            @if($description)
                <span id="{{ $descriptionId }}" class="aura-checkbox-description text-xs text-aura-surface-600 leading-snug">{{ $description }}</span>
            @endif
        </span>
    @endif
</label>
@if($error)
    {{-- role="alert" so an error inserted after a submit is announced. --}}
    <p id="{{ $errorId }}" role="alert" class="aura-checkbox-error text-xs font-medium text-aura-danger-700 dark:text-aura-danger-500">{{ $error }}</p>
</div>
@endif
