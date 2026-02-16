@props([
    'label' => null,
    'description' => null,
    'value' => null,
    'name' => null,
    'disabled' => false,
])

<label class="aura-radio flex items-start gap-2.5 cursor-pointer relative select-none" @if($disabled) aria-disabled="true" @endif>
    <input
        type="radio"
        @if($value) value="{{ $value }}" @endif
        @if($name) name="{{ $name }}" @endif
        @if($disabled) disabled @endif
        {{ $attributes }}
    />
    <span class="aura-radio-circle shrink-0 w-[18px] h-[18px] mt-px border-2 border-aura-surface-300 rounded-full bg-aura-surface-0 flex items-center justify-center aura-transition">
        <span class="aura-radio-dot w-2 h-2 rounded-full bg-white"></span>
    </span>
    @if($label)
        <span class="aura-radio-content flex flex-col gap-0.5">
            <span class="aura-radio-label text-sm font-[450] text-aura-surface-900 leading-snug">{{ $label }}</span>
            @if($description)
                <span class="aura-radio-description text-xs text-aura-surface-400 leading-snug">{{ $description }}</span>
            @endif
        </span>
    @endif
</label>
