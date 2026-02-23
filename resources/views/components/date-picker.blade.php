@props([
    'label' => null,
    'placeholder' => 'dd/mm/yyyy',
    'format' => 'd/m/Y',
    'wireFormat' => 'Y-m-d',
    'min' => null,
    'max' => null,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'size' => 'md',
    'clearable' => true,
    'withTime' => false,
    'locale' => 'en',
])

@php
    $inputClasses = ['aura-input', "aura-input-{$size}"];
    if ($error) $inputClasses[] = 'aura-input-error';
    if ($disabled) $inputClasses[] = 'aura-input-disabled';

    $dayNames = match($locale) {
        'it' => ['Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa', 'Do'],
        'de' => ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'],
        default => ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
    };
    $monthNames = match($locale) {
        'it' => ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
        'de' => ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'],
        default => ['January','February','March','April','May','June','July','August','September','October','November','December'],
    };
@endphp

<div
    {{ $attributes->class(['aura-datepicker-wrapper relative']) }}
    x-data="{
        open: false,
        value: @if(isset($__livewire) && $attributes->wire('model')->value()) $wire.entangle('{{ $attributes->wire('model')->value() }}'){{ $attributes->wire('model')->hasModifier('live') ? '.live' : '' }} @else '' @endif,
        displayValue: '',
        year: {{ now()->year }},
        month: {{ now()->month - 1 }},
        hour: 9,
        minute: 0,
        days: [],
        withTime: {{ $withTime ? 'true' : 'false' }},
        format: '{{ $format }}',
        wireFormat: '{{ $wireFormat }}',
        min: '{{ $min ?? '' }}',
        max: '{{ $max ?? '' }}',
        dayNames: {{ json_encode($dayNames) }},
        monthNames: {{ json_encode($monthNames) }},

        init() {
            if (this.value) {
                let d = new Date(this.value);
                if (!isNaN(d)) {
                    this.year = d.getFullYear();
                    this.month = d.getMonth();
                    this.hour = d.getHours();
                    this.minute = d.getMinutes();
                    this.updateDisplay(d);
                }
            }
            this.buildDays();
            this.$watch('value', (v) => {
                if (v) {
                    let d = new Date(v);
                    if (!isNaN(d)) {
                        this.year = d.getFullYear();
                        this.month = d.getMonth();
                        this.hour = d.getHours();
                        this.minute = d.getMinutes();
                        this.updateDisplay(d);
                    }
                } else {
                    this.displayValue = '';
                }
            });
        },

        buildDays() {
            let first = new Date(this.year, this.month, 1);
            let startDay = (first.getDay() + 6) % 7;
            let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
            let daysInPrev = new Date(this.year, this.month, 0).getDate();
            this.days = [];

            for (let i = startDay - 1; i >= 0; i--) {
                this.days.push({ day: daysInPrev - i, current: false, date: null });
            }
            for (let i = 1; i <= daysInMonth; i++) {
                let dt = new Date(this.year, this.month, i);
                let iso = this.toIso(dt);
                this.days.push({ day: i, current: true, date: iso, disabled: this.isDisabled(iso) });
            }
            let remaining = 42 - this.days.length;
            for (let i = 1; i <= remaining; i++) {
                this.days.push({ day: i, current: false, date: null });
            }
        },

        toIso(d) {
            let y = d.getFullYear();
            let m = String(d.getMonth() + 1).padStart(2, '0');
            let dd = String(d.getDate()).padStart(2, '0');
            return y + '-' + m + '-' + dd;
        },

        isDisabled(iso) {
            if (this.min && iso < this.min) return true;
            if (this.max && iso > this.max) return true;
            return false;
        },

        isSelected(iso) {
            if (!this.value) return false;
            return this.value.substring(0, 10) === iso;
        },

        isToday(iso) {
            return iso === this.toIso(new Date());
        },

        selectDate(iso) {
            if (this.withTime) {
                let h = String(this.hour).padStart(2, '0');
                let m = String(this.minute).padStart(2, '0');
                this.value = iso + ' ' + h + ':' + m + ':00';
            } else {
                this.value = iso;
            }
            let d = new Date(this.value);
            this.updateDisplay(d);
            if (!this.withTime) this.open = false;
        },

        updateDisplay(d) {
            let day = String(d.getDate()).padStart(2, '0');
            let month = String(d.getMonth() + 1).padStart(2, '0');
            let year = d.getFullYear();
            let h = String(d.getHours()).padStart(2, '0');
            let m = String(d.getMinutes()).padStart(2, '0');

            let fmt = this.format;
            fmt = fmt.replace('d', day).replace('m', month).replace('Y', year);
            if (this.withTime) {
                fmt = fmt.replace('H', h).replace('i', m);
                if (!fmt.includes(h)) fmt += ' ' + h + ':' + m;
            }
            this.displayValue = fmt;
        },

        prevMonth() {
            this.month--;
            if (this.month < 0) { this.month = 11; this.year--; }
            this.buildDays();
        },

        nextMonth() {
            this.month++;
            if (this.month > 11) { this.month = 0; this.year++; }
            this.buildDays();
        },

        prevYear() { this.year--; this.buildDays(); },
        nextYear() { this.year++; this.buildDays(); },

        clear() {
            this.value = '';
            this.displayValue = '';
            this.open = false;
        },

        updateTime() {
            if (this.value) {
                let iso = this.value.substring(0, 10);
                let h = String(this.hour).padStart(2, '0');
                let m = String(this.minute).padStart(2, '0');
                this.value = iso + ' ' + h + ':' + m + ':00';
                this.updateDisplay(new Date(this.value));
            }
        }
    }"
    x-on:click.outside="open = false"
    x-on:keydown.escape.window="open = false"
>
    @if($label)
        <label class="aura-label">{{ $label }}</label>
    @endif

    <div class="aura-datepicker-input-wrap relative">
        <input
            type="text"
            class="{{ implode(' ', $inputClasses) }} aura-datepicker-input"
            x-bind:value="displayValue"
            placeholder="{{ $placeholder }}"
            readonly
            @if($disabled) disabled @endif
            x-on:click="if (!{{ $disabled ? 'true' : 'false' }}) open = !open"
            aria-haspopup="dialog"
            x-bind:aria-expanded="open"
        />
        <div class="aura-datepicker-icons absolute right-0 top-0 h-full flex items-center gap-1 pr-2">
            @if($clearable)
                <button type="button" class="aura-datepicker-clear p-1 bg-transparent border-none text-aura-surface-400 cursor-pointer rounded-aura-sm aura-transition-fast hover:text-aura-surface-700" x-show="displayValue" x-on:click.stop="clear()" aria-label="Clear">
                    <x-aura::icon name="x" size="xs" />
                </button>
            @endif
            <span class="aura-datepicker-icon text-aura-surface-400">
                <x-aura::icon name="calendar" size="sm" />
            </span>
        </div>
    </div>

    {{-- Calendar Dropdown --}}
    <div
        class="aura-datepicker-dropdown absolute top-full left-0 mt-1 w-[300px] bg-aura-surface-0 border border-aura-surface-200 rounded-aura-lg shadow-aura-xl z-aura-dropdown p-3 aura-glass"
        x-show="open"
        x-transition:enter="aura-transition-enter"
        x-transition:enter-start="aura-transition-enter-start"
        x-transition:enter-end="aura-transition-enter-end"
        x-transition:leave="aura-transition-leave"
        x-transition:leave-start="aura-transition-leave-start"
        x-transition:leave-end="aura-transition-leave-end"
        x-cloak
        role="dialog"
        aria-modal="true"
    >
        {{-- Header --}}
        <div class="aura-datepicker-header flex items-center justify-between gap-1 mb-3">
            <button type="button" class="aura-datepicker-nav inline-flex items-center justify-center w-7 h-7 rounded-aura-md text-aura-surface-500 bg-transparent border-none cursor-pointer aura-transition-fast hover:bg-aura-surface-100 hover:text-aura-surface-900" x-on:click="prevYear()" aria-label="Previous year">
                <x-aura::icon name="chevrons-left" size="xs" />
            </button>
            <button type="button" class="aura-datepicker-nav inline-flex items-center justify-center w-7 h-7 rounded-aura-md text-aura-surface-500 bg-transparent border-none cursor-pointer aura-transition-fast hover:bg-aura-surface-100 hover:text-aura-surface-900" x-on:click="prevMonth()" aria-label="Previous month">
                <x-aura::icon name="chevron-left" size="xs" />
            </button>
            <span class="aura-datepicker-title text-sm font-semibold text-aura-surface-900" x-text="monthNames[month] + ' ' + year"></span>
            <button type="button" class="aura-datepicker-nav inline-flex items-center justify-center w-7 h-7 rounded-aura-md text-aura-surface-500 bg-transparent border-none cursor-pointer aura-transition-fast hover:bg-aura-surface-100 hover:text-aura-surface-900" x-on:click="nextMonth()" aria-label="Next month">
                <x-aura::icon name="chevron-right" size="xs" />
            </button>
            <button type="button" class="aura-datepicker-nav inline-flex items-center justify-center w-7 h-7 rounded-aura-md text-aura-surface-500 bg-transparent border-none cursor-pointer aura-transition-fast hover:bg-aura-surface-100 hover:text-aura-surface-900" x-on:click="nextYear()" aria-label="Next year">
                <x-aura::icon name="chevrons-right" size="xs" />
            </button>
        </div>

        {{-- Day names --}}
        <div class="aura-datepicker-weekdays grid grid-cols-7 mb-1">
            <template x-for="d in dayNames" :key="d">
                <span class="aura-datepicker-weekday text-center text-[11px] font-semibold text-aura-surface-400 py-1" x-text="d"></span>
            </template>
        </div>

        {{-- Days grid --}}
        <div class="aura-datepicker-grid grid grid-cols-7 gap-0.5">
            <template x-for="(cell, idx) in days" :key="idx">
                <button
                    type="button"
                    class="aura-datepicker-day inline-flex items-center justify-center w-9 h-9 text-sm rounded-full bg-transparent border-none cursor-pointer text-aura-surface-700 aura-transition-fast hover:bg-aura-surface-100"
                    x-text="cell.day"
                    x-bind:class="{
                        'aura-datepicker-day-other opacity-30': !cell.current,
                        'aura-datepicker-day-today font-bold ring-1 ring-aura-primary-300': cell.date && isToday(cell.date),
                        'aura-datepicker-day-selected !bg-aura-primary-500 !text-white': cell.date && isSelected(cell.date),
                        'aura-datepicker-day-disabled opacity-30 cursor-not-allowed': cell.disabled,
                    }"
                    x-bind:disabled="!cell.current || cell.disabled"
                    x-on:click="cell.current && !cell.disabled && selectDate(cell.date)"
                ></button>
            </template>
        </div>

        {{-- Time selector --}}
        <template x-if="withTime">
            <div class="aura-datepicker-time flex items-center gap-2 pt-3 mt-3 border-t border-aura-surface-200">
                <label class="aura-datepicker-time-label text-xs font-medium text-aura-surface-500">Time:</label>
                <input type="number" min="0" max="23" x-model.number="hour" x-on:change="updateTime()" class="aura-datepicker-time-input w-14 text-center py-1 px-2 text-sm border border-aura-surface-200 rounded-aura-md bg-aura-surface-0 text-aura-surface-900 outline-none" />
                <span class="aura-datepicker-time-sep text-aura-surface-400 font-medium">:</span>
                <input type="number" min="0" max="59" step="5" x-model.number="minute" x-on:change="updateTime()" class="aura-datepicker-time-input w-14 text-center py-1 px-2 text-sm border border-aura-surface-200 rounded-aura-md bg-aura-surface-0 text-aura-surface-900 outline-none" />
            </div>
        </template>
    </div>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
