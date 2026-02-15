@props([
    'label' => null,
    'placeholder' => 'gg/mm/aaaa',
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
    'locale' => 'it',
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
    {{ $attributes->class(['aura-datepicker-wrapper']) }}
    x-data="{
        open: false,
        value: @entangle($attributes->wire('model')),
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

    <div class="aura-datepicker-input-wrap">
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
        <div class="aura-datepicker-icons">
            @if($clearable)
                <button type="button" class="aura-datepicker-clear" x-show="displayValue" x-on:click.stop="clear()" aria-label="Cancella">
                    <x-aura::icon name="x" size="xs" />
                </button>
            @endif
            <span class="aura-datepicker-icon">
                <x-aura::icon name="calendar" size="sm" />
            </span>
        </div>
    </div>

    {{-- Calendar Dropdown --}}
    <div
        class="aura-datepicker-dropdown aura-glass"
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
        <div class="aura-datepicker-header">
            <button type="button" class="aura-datepicker-nav" x-on:click="prevYear()" aria-label="Anno precedente">
                <x-aura::icon name="chevrons-left" size="xs" />
            </button>
            <button type="button" class="aura-datepicker-nav" x-on:click="prevMonth()" aria-label="Mese precedente">
                <x-aura::icon name="chevron-left" size="xs" />
            </button>
            <span class="aura-datepicker-title" x-text="monthNames[month] + ' ' + year"></span>
            <button type="button" class="aura-datepicker-nav" x-on:click="nextMonth()" aria-label="Mese successivo">
                <x-aura::icon name="chevron-right" size="xs" />
            </button>
            <button type="button" class="aura-datepicker-nav" x-on:click="nextYear()" aria-label="Anno successivo">
                <x-aura::icon name="chevrons-right" size="xs" />
            </button>
        </div>

        {{-- Day names --}}
        <div class="aura-datepicker-weekdays">
            <template x-for="d in dayNames" :key="d">
                <span class="aura-datepicker-weekday" x-text="d"></span>
            </template>
        </div>

        {{-- Days grid --}}
        <div class="aura-datepicker-grid">
            <template x-for="(cell, idx) in days" :key="idx">
                <button
                    type="button"
                    class="aura-datepicker-day"
                    x-text="cell.day"
                    x-bind:class="{
                        'aura-datepicker-day-other': !cell.current,
                        'aura-datepicker-day-today': cell.date && isToday(cell.date),
                        'aura-datepicker-day-selected': cell.date && isSelected(cell.date),
                        'aura-datepicker-day-disabled': cell.disabled,
                    }"
                    x-bind:disabled="!cell.current || cell.disabled"
                    x-on:click="cell.current && !cell.disabled && selectDate(cell.date)"
                ></button>
            </template>
        </div>

        {{-- Time selector --}}
        <template x-if="withTime">
            <div class="aura-datepicker-time">
                <label class="aura-datepicker-time-label">Ora:</label>
                <input type="number" min="0" max="23" x-model.number="hour" x-on:change="updateTime()" class="aura-datepicker-time-input" />
                <span class="aura-datepicker-time-sep">:</span>
                <input type="number" min="0" max="59" step="5" x-model.number="minute" x-on:change="updateTime()" class="aura-datepicker-time-input" />
            </div>
        </template>
    </div>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
