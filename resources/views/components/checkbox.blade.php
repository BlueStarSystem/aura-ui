@props([
    'label' => null,
    'description' => null,
    'value' => null,
    'disabled' => false,
])

<label class="aura-checkbox flex items-start gap-2.5 cursor-pointer relative select-none" @if($disabled) aria-disabled="true" @endif>
    <input
        type="checkbox"
        @if($value) value="{{ $value }}" @endif
        @if($disabled) disabled @endif
        {{ $attributes }}
    />
    <span class="aura-checkbox-box shrink-0 w-[18px] h-[18px] mt-px border-2 border-aura-surface-300 rounded-[5px] bg-aura-surface-0 flex items-center justify-center aura-transition">
        <svg class="aura-checkbox-icon w-3 h-3 stroke-white stroke-[3] fill-none" viewBox="0 0 12 12" fill="none">
            <path d="M2.5 6L5 8.5L9.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </span>
    @if($label)
        <span class="aura-checkbox-content flex flex-col gap-0.5">
            <span class="aura-checkbox-label text-sm font-[450] text-aura-surface-900 leading-snug">{{ $label }}</span>
            @if($description)
                <span class="aura-checkbox-description text-xs text-aura-surface-400 leading-snug">{{ $description }}</span>
            @endif
        </span>
    @endif
</label>
