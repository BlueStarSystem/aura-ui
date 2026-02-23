@props([
    'label' => null,
    'placeholder' => 'Search...',
    'options' => [],
    'optionLabel' => 'label',
    'optionValue' => 'value',
    'clearable' => true,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'size' => 'md',
    'minChars' => 0,
    'noResultsText' => 'No results',
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
    {{ $attributes->class(['aura-autocomplete-wrapper relative flex flex-col gap-1.5']) }}
    x-data="{
        open: false,
        value: @if(isset($__livewire) && $attributes->wire('model')->value()) $wire.entangle('{{ $attributes->wire('model')->value() }}'){{ $attributes->wire('model')->hasModifier('live') ? '.live' : '' }} @else '' @endif,
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

    <div class="aura-autocomplete-input-wrap relative">
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
        <div class="aura-datepicker-icons absolute right-0 top-0 h-full flex items-center gap-1 pr-2">
            @if($clearable)
                <button type="button" class="aura-datepicker-clear p-1 bg-transparent border-none text-aura-surface-400 cursor-pointer rounded-aura-sm aura-transition-fast hover:text-aura-surface-700" x-show="value" x-on:click.stop="clear()" aria-label="Clear">
                    <x-aura::icon name="x" size="xs" />
                </button>
            @endif
        </div>
    </div>

    {{-- Dropdown --}}
    <div
        class="aura-autocomplete-dropdown absolute top-full left-0 right-0 mt-1 bg-aura-surface-0 border border-aura-surface-200 rounded-aura-lg shadow-aura-xl z-aura-dropdown max-h-[200px] overflow-y-auto p-1 aura-glass"
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
                class="aura-autocomplete-option block w-full text-left px-3 py-2 text-sm text-aura-surface-700 bg-transparent border-none cursor-pointer rounded-aura-sm aura-transition-fast hover:bg-aura-surface-100"
                x-text="opt.label"
                x-bind:class="{
                    'aura-autocomplete-option-selected bg-aura-primary-50 text-aura-primary-700 font-medium': String(value) === String(opt.value),
                    'aura-autocomplete-option-highlighted bg-aura-surface-100': highlightIndex === idx,
                }"
                x-on:click="select(opt)"
                role="option"
                x-bind:aria-selected="String(value) === String(opt.value)"
            ></button>
        </template>
    </div>

    {{-- No results --}}
    <div
        class="aura-autocomplete-dropdown absolute top-full left-0 right-0 mt-1 bg-aura-surface-0 border border-aura-surface-200 rounded-aura-lg shadow-aura-xl z-aura-dropdown max-h-[200px] overflow-y-auto p-1 aura-glass"
        x-show="open && search.length >= minChars && filtered.length === 0"
        x-cloak
    >
        <div class="aura-autocomplete-no-results px-3 py-4 text-center text-sm text-aura-surface-400">{{ $noResultsText }}</div>
    </div>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
