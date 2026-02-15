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
    {{ $attributes->class(['aura-timepicker-wrapper']) }}
    x-data="{
        open: false,
        value: @entangle($attributes->wire('model')),
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

    <div class="aura-timepicker-input-wrap">
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
        <div class="aura-datepicker-icons">
            @if($clearable)
                <button type="button" class="aura-datepicker-clear" x-show="value" x-on:click.stop="clear()" aria-label="Cancella">
                    <x-aura::icon name="x" size="xs" />
                </button>
            @endif
            <span class="aura-datepicker-icon">
                <x-aura::icon name="clock" size="sm" />
            </span>
        </div>
    </div>

    {{-- Time dropdown --}}
    <div
        class="aura-timepicker-dropdown aura-glass"
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
        <div class="aura-timepicker-search">
            <input
                type="text"
                class="aura-input aura-input-sm"
                placeholder="Filtra..."
                x-model="search"
                x-on:click.stop
            />
        </div>
        <div class="aura-timepicker-list">
            <template x-for="slot in filteredSlots" :key="slot">
                <button
                    type="button"
                    class="aura-timepicker-option"
                    x-text="slot"
                    x-bind:class="{ 'aura-timepicker-option-selected': value === slot }"
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
