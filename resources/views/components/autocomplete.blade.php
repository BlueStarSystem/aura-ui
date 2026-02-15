@props([
    'label' => null,
    'placeholder' => 'Cerca...',
    'options' => [],
    'optionLabel' => 'label',
    'optionValue' => 'value',
    'clearable' => true,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'size' => 'md',
    'minChars' => 0,
    'noResultsText' => 'Nessun risultato',
])

@php
    $inputClasses = ['aura-input', "aura-input-{$size}"];
    if ($error) $inputClasses[] = 'aura-input-error';
    if ($disabled) $inputClasses[] = 'aura-input-disabled';

    // Normalize options to [{label, value}]
    $normalizedOptions = [];
    foreach ($options as $key => $opt) {
        if (is_array($opt) || is_object($opt)) {
            $opt = (array)$opt;
            $normalizedOptions[] = ['label' => $opt[$optionLabel] ?? $key, 'value' => $opt[$optionValue] ?? $key];
        } else {
            $normalizedOptions[] = ['label' => $opt, 'value' => $key];
        }
    }
@endphp

<div
    {{ $attributes->class(['aura-autocomplete-wrapper']) }}
    x-data="{
        open: false,
        value: @entangle($attributes->wire('model')),
        search: '',
        options: {{ json_encode($normalizedOptions) }},
        minChars: {{ $minChars }},
        highlightIndex: -1,

        init() {
            this.syncDisplay();
            this.$watch('value', () => this.syncDisplay());
        },

        syncDisplay() {
            if (this.value !== null && this.value !== '') {
                let opt = this.options.find(o => String(o.value) === String(this.value));
                this.search = opt ? opt.label : '';
            } else {
                this.search = '';
            }
        },

        get filtered() {
            if (this.search.length < this.minChars) return [];
            let q = this.search.toLowerCase();
            return this.options.filter(o => o.label.toLowerCase().includes(q));
        },

        select(opt) {
            this.value = opt.value;
            this.search = opt.label;
            this.open = false;
            this.highlightIndex = -1;
        },

        clear() {
            this.value = '';
            this.search = '';
            this.open = false;
            this.highlightIndex = -1;
        },

        onInput() {
            this.open = this.search.length >= this.minChars;
            this.highlightIndex = -1;
            if (this.search === '') this.value = '';
        },

        onKeydown(e) {
            if (!this.open) return;
            let items = this.filtered;
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                this.highlightIndex = Math.min(this.highlightIndex + 1, items.length - 1);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                this.highlightIndex = Math.max(this.highlightIndex - 1, 0);
            } else if (e.key === 'Enter' && this.highlightIndex >= 0) {
                e.preventDefault();
                this.select(items[this.highlightIndex]);
            }
        }
    }"
    x-on:click.outside="open = false"
    x-on:keydown.escape="open = false"
>
    @if($label)
        <label class="aura-label">{{ $label }}</label>
    @endif

    <div class="aura-autocomplete-input-wrap">
        <input
            type="text"
            class="{{ implode(' ', $inputClasses) }}"
            x-model="search"
            x-on:input="onInput()"
            x-on:focus="if (search.length >= minChars) open = true"
            x-on:keydown="onKeydown($event)"
            placeholder="{{ $placeholder }}"
            @if($disabled) disabled @endif
            role="combobox"
            aria-autocomplete="list"
            x-bind:aria-expanded="open"
            autocomplete="off"
        />
        <div class="aura-datepicker-icons">
            @if($clearable)
                <button type="button" class="aura-datepicker-clear" x-show="value" x-on:click.stop="clear()" aria-label="Cancella">
                    <x-aura::icon name="x" size="xs" />
                </button>
            @endif
        </div>
    </div>

    {{-- Dropdown --}}
    <div
        class="aura-autocomplete-dropdown aura-glass"
        x-show="open && filtered.length > 0"
        x-transition:enter="aura-transition-enter"
        x-transition:enter-start="aura-transition-enter-start"
        x-transition:enter-end="aura-transition-enter-end"
        x-transition:leave="aura-transition-leave"
        x-transition:leave-start="aura-transition-leave-start"
        x-transition:leave-end="aura-transition-leave-end"
        x-cloak
        role="listbox"
    >
        <template x-for="(opt, idx) in filtered" :key="opt.value">
            <button
                type="button"
                class="aura-autocomplete-option"
                x-text="opt.label"
                x-bind:class="{
                    'aura-autocomplete-option-selected': String(value) === String(opt.value),
                    'aura-autocomplete-option-highlighted': highlightIndex === idx,
                }"
                x-on:click="select(opt)"
                role="option"
                x-bind:aria-selected="String(value) === String(opt.value)"
            ></button>
        </template>
    </div>

    {{-- No results --}}
    <div
        class="aura-autocomplete-dropdown aura-glass"
        x-show="open && search.length >= minChars && filtered.length === 0"
        x-cloak
    >
        <div class="aura-autocomplete-no-results">{{ $noResultsText }}</div>
    </div>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
