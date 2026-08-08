@props([
    'label' => null,
    'for' => null,
    'hint' => null,
    'error' => null,
    'required' => false,
])

@php $descriptionId = $for ? $for . '-description' : null; @endphp

<div {{ $attributes->class(['aura-field flex flex-col gap-1.5', $error ? 'aura-has-error' : '']) }}>
    @if($label)
        <label @if($for) for="{{ $for }}" @endif class="aura-label text-sm font-medium text-aura-surface-700">
            {{ $label }}
            @if($required)
                <span class="aura-field-required text-aura-danger-500 ml-0.5">*</span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if($error)
        <p role="alert" @if($descriptionId) id="{{ $descriptionId }}" @endif class="aura-input-error-text text-xs text-aura-danger-700 dark:text-aura-danger-500">{{ $error }}</p>
    @elseif($hint)
        <p @if($descriptionId) id="{{ $descriptionId }}" @endif class="aura-input-hint text-xs text-aura-surface-600">{{ $hint }}</p>
    @endif
</div>
