@props([
    'label' => null,
    'placeholder' => 'HH:MM',
    'step' => 15,
    'min' => '00:00',
    'max' => '23:59',
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'size' => 'md',
    'clearable' => true,
])

@php
    $inputClasses = ['aura-input', "aura-input-{$size}"];
    if ($error) $inputClasses[] = 'aura-input-error';
    if ($disabled) $inputClasses[] = 'aura-input-disabled';

    // Generate time slots
    $slots = [];
    $startParts = explode(':', $min);
    $endParts = explode(':', $max);
    $startMinutes = ((int)$startParts[0]) * 60 + ((int)($startParts[1] ?? 0));
    $endMinutes = ((int)$endParts[0]) * 60 + ((int)($endParts[1] ?? 59));
    for ($m = $startMinutes; $m <= $endMinutes; $m += $step) {
        $h = intdiv($m, 60);
        $mi = $m % 60;
        $slots[] = sprintf('%02d:%02d', $h, $mi);
    }
@endphp

<div
    {{ $attributes->class(['aura-timepicker-wrapper relative']) }}
    x-data="{
        open: false,
        value: @if(isset($__livewire) && $attributes->wire('model')->value()) $wire.entangle('{{ $attributes->wire('model')->value() }}'){{ $attributes->wire('model')->hasModifier('live') ? '.live' : '' }} @else '' @endif,
        slots: {{ json_encode($slots) }},
        search: '',

        get filteredSlots() {
            if (!this.search) return this.slots;
            return this.slots.filter(s => s.includes(this.search));
        },

        select(time) {
            this.value = time;
            this.open = false;
            this.search = '';
        },

        clear() {
            this.value = '';
            this.open = false;
        }
    }"
    x-on:click.outside="open = false"
    x-on:keydown.escape.window="open = false"
>
    @if($label)
        <label class="aura-label">{{ $label }}</label>
    @endif

    <div class="aura-timepicker-input-wrap relative">
        <input
            type="text"
            class="{{ implode(' ', $inputClasses) }} aura-timepicker-input"
            x-bind:value="value"
            placeholder="{{ $placeholder }}"
            readonly
            @if($disabled) disabled @endif
            x-on:click="if (!{{ $disabled ? 'true' : 'false' }}) open = !open"
            aria-haspopup="listbox"
            x-bind:aria-expanded="open"
        />
        <div class="aura-datepicker-icons absolute right-0 top-0 h-full flex items-center gap-1 pr-2">
            @if($clearable)
                <button type="button" class="aura-datepicker-clear p-1 bg-transparent border-none text-aura-surface-400 cursor-pointer rounded-aura-sm aura-transition-fast hover:text-aura-surface-700" x-show="value" x-on:click.stop="clear()" aria-label="Clear">
                    <x-aura::icon name="x" size="xs" />
                </button>
            @endif
            <span class="aura-datepicker-icon text-aura-surface-400">
                <x-aura::icon name="clock" size="sm" />
            </span>
        </div>
    </div>

    {{-- Time dropdown --}}
    <div
        class="aura-timepicker-dropdown absolute top-full left-0 mt-1 w-[200px] bg-aura-surface-0 border border-aura-surface-200 rounded-aura-lg shadow-aura-xl z-aura-dropdown overflow-hidden aura-glass"
        x-show="open"
        x-transition:enter="aura-transition-enter"
        x-transition:enter-start="aura-transition-enter-start"
        x-transition:enter-end="aura-transition-enter-end"
        x-transition:leave="aura-transition-leave"
        x-transition:leave-start="aura-transition-leave-start"
        x-transition:leave-end="aura-transition-leave-end"
        x-cloak
        role="listbox"
    >
        <div class="aura-timepicker-search p-2 border-b border-aura-surface-200">
            <input
                type="text"
                class="aura-input aura-input-sm"
                placeholder="Filter..."
                x-model="search"
                x-on:click.stop
            />
        </div>
        <div class="aura-timepicker-list max-h-[200px] overflow-y-auto p-1">
            <template x-for="slot in filteredSlots" :key="slot">
                <button
                    type="button"
                    class="aura-timepicker-option block w-full text-left px-3 py-1.5 text-sm text-aura-surface-700 bg-transparent border-none cursor-pointer rounded-aura-sm aura-transition-fast hover:bg-aura-surface-100"
                    x-text="slot"
                    x-bind:class="{ 'aura-timepicker-option-selected !bg-aura-primary-50 !text-aura-primary-600 font-medium': value === slot }"
                    x-on:click="select(slot)"
                    role="option"
                    x-bind:aria-selected="value === slot"
                ></button>
            </template>
        </div>
    </div>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
