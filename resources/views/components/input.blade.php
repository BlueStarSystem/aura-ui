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
    use BlueStarSystem\AuraUI\Support\Html;

    // Stable across renders: uniqid() gave the field a different id on every
    // Livewire round trip, which rewrote the label's `for` and the
    // aria-describedby pointing at the error text underneath the user.
    $inputId = Html::fieldId($attributes->get('id'), $attributes->get('name'), $label, Html::wireModelFrom($attributes->getAttributes()));
    $descriptionId = $inputId.'-description';

    // Merged, not replaced: the bag may already carry an aria-describedby the
    // application attached to its own help text. Emitting a second attribute
    // means the browser keeps one and silently drops the other.
    $describedBy = ($error || $hint)
        ? Html::describedBy($attributes->get('aria-describedby'), $descriptionId)
        : $attributes->get('aria-describedby');
@endphp

@php
    $sizeClasses = match($size) {
        'sm' => 'aura-input-sm py-1.5 px-2.5 text-[13px]',
        'lg' => 'aura-input-lg py-3.5 px-[18px] text-[15px]',
        default => 'py-2.5 px-3.5 text-sm',
    };

    $inputClasses = [
        'aura-input',
        "aura-input-{$size}",
        'w-full font-[inherit] leading-normal text-aura-surface-900 bg-aura-surface-100 border border-aura-surface-500 rounded-aura-md outline-none aura-transition box-border',
        'placeholder:text-aura-surface-400',
        'hover:border-aura-surface-600 hover:bg-aura-surface-50',
        'focus:border-aura-primary-500 focus:bg-aura-surface-0 focus:shadow-[var(--aura-glow-primary)]',
        $sizeClasses,
    ];
    if ($error) $inputClasses[] = 'aura-input-error';

    $wrapperClasses = ['aura-input-wrapper', 'flex flex-col gap-1.5 w-full max-w-[340px]'];
    if ($error) $wrapperClasses[] = 'aura-has-error';
@endphp

<div class="{{ implode(' ', $wrapperClasses) }}">
    @if($label)
        <label for="{{ $inputId }}" class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">{{ $label }}</label>
    @endif

    <div class="aura-input-container {{ ($prefixIcon || $prefix || $suffixIcon || $suffix) ? 'aura-input-group flex items-stretch rounded-aura-md overflow-hidden' : '' }} {{ ($prefixIcon || $prefix) ? 'aura-input-has-prefix' : '' }} {{ ($suffixIcon || $suffix) ? 'aura-input-has-suffix' : '' }}">
        @if($prefixIcon)
            <span class="aura-input-prefix aura-input-icon flex items-center px-3 text-[13px] text-aura-surface-600 bg-aura-surface-200 border border-aura-surface-500 border-r-0 whitespace-nowrap">
                <x-aura::icon :name="$prefixIcon" size="sm" />
            </span>
        @elseif($prefix)
            <span class="aura-input-prefix flex items-center px-3 text-[13px] text-aura-surface-600 bg-aura-surface-200 border border-aura-surface-500 border-r-0 whitespace-nowrap">{{ $prefix }}</span>
        @endif

        <input
            type="{{ $type }}"
            id="{{ $inputId }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            @if($error) aria-invalid="true" @endif
            @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->except(['id', 'aria-describedby'])->class($inputClasses) }}
        />

        @if($suffixIcon)
            <span class="aura-input-suffix aura-input-icon flex items-center px-3 text-[13px] text-aura-surface-600 bg-aura-surface-200 border border-aura-surface-500 border-l-0 whitespace-nowrap">
                <x-aura::icon :name="$suffixIcon" size="sm" />
            </span>
        @elseif($suffix)
            <span class="aura-input-suffix flex items-center px-3 text-[13px] text-aura-surface-600 bg-aura-surface-200 border border-aura-surface-500 border-l-0 whitespace-nowrap">{{ $suffix }}</span>
        @endif
    </div>

    @if($error)
        {{-- role="alert" so an error inserted after a Livewire submit is
             announced immediately, instead of only when the user happens to
             return to the field. --}}
        <p id="{{ $descriptionId }}" role="alert" class="aura-input-error-text text-xs text-aura-danger-500 font-medium flex items-center gap-1 aura-animate-shake">{{ $error }}</p>
    @elseif($hint)
        <p id="{{ $descriptionId }}" class="aura-input-hint text-xs text-aura-surface-400 leading-snug">{{ $hint }}</p>
    @endif
</div>
