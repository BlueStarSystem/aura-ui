@props([
    'label' => null,
    'description' => null,
    'size' => 'md',
    'color' => 'primary',
    'disabled' => false,
])

@php
    $trackClasses = match($size) {
        'sm' => 'aura-toggle aura-toggle-sm w-9 h-5 box-border',
        'lg' => 'aura-toggle aura-toggle-lg w-[52px] h-7 box-border',
        default => 'aura-toggle w-11 h-6 box-border',
    };
    $knobClasses = match($size) {
        'sm' => 'w-4 h-4',
        'lg' => 'w-6 h-6',
        default => 'w-5 h-5',
    };
@endphp

<label class="aura-toggle-wrapper inline-flex items-center gap-2.5 cursor-pointer select-none relative" @if($disabled) aria-disabled="true" @endif>
    <input
        type="checkbox"
        class="aura-toggle-input"
        @if($disabled) disabled @endif
        {{ $attributes }}
    />
    <span class="{{ $trackClasses }} aura-toggle-{{ $color }} relative bg-aura-surface-300 border border-aura-surface-500 rounded-aura-full aura-transition-slow shrink-0">
        <span class="aura-toggle-knob {{ $knobClasses }} absolute top-px left-px bg-white rounded-full shadow-[0_1px_3px_rgba(0,0,0,0.15),0_1px_2px_rgba(0,0,0,0.1)] aura-transition-slow"></span>
    </span>
    @if($label)
        <span class="aura-toggle-text flex flex-col">
            <span class="aura-toggle-label text-sm font-[450] text-aura-surface-900">{{ $label }}</span>
            @if($description)
                <span class="aura-toggle-description text-xs text-aura-surface-400">{{ $description }}</span>
            @endif
        </span>
    @endif
</label>
