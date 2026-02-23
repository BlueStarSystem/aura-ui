@props([
    'label' => null,
    'for' => null,
    'hint' => null,
    'error' => null,
    'required' => false,
])

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
        <p class="aura-input-error-text text-xs text-aura-danger-500">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint text-xs text-aura-surface-400">{{ $hint }}</p>
    @endif
</div>
