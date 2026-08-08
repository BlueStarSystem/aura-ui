@props([
    'label' => null,
    'options' => [],
    'placeholder' => 'Select...',
    'searchable' => true,
    'max' => null,
    'clearable' => true,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'size' => 'md',
])

@php
    use BlueStarSystem\AuraUI\Support\Html;

    // A label with no `for` and an input with no id: clicking the label
    // does nothing and the error text below is attached to nothing.
    $multiselectId = Html::fieldId($attributes->get('id'), null, $label, Html::wireModelFrom($attributes->getAttributes()));
    $multiselectIdError = $multiselectId.'-error';
@endphp

@php
    $normalized = [];
    foreach ($options as $k => $v) {
        if (is_int($k)) {
            $normalized[] = ['value' => (string) $v, 'label' => (string) $v];
        } else {
            $normalized[] = ['value' => (string) $k, 'label' => (string) $v];
        }
    }
@endphp

<div
    {{ $attributes->class(['aura-multiselect-wrapper relative flex flex-col gap-1.5']) }}
    x-data="{
        selected: @if($attributes->wire('model')->value()) $wire.entangle({{ Js::from($attributes->wire('model')->value()) }}){{ $attributes->wire('model')->hasModifier('live') ? '.live' : '' }} @else [] @endif,
        options: {{ Js::from($normalized) }},
        search: '',
        open: false,
        max: {{ is_null($max) ? 'null' : (int) $max }},
        highlight: -1,
        init() { if (!Array.isArray(this.selected)) this.selected = []; },
        get canAdd() { return this.max === null || this.selected.length < this.max; },
        get filteredOptions() {
            const q = this.search.toLowerCase();
            return this.options.filter(o => !this.selected.includes(o.value) && (!q || o.label.toLowerCase().includes(q)));
        },
        labelFor(v) { const o = this.options.find(o => o.value === v); return o ? o.label : v; },
        add(v) {
            if (!this.canAdd || this.selected.includes(v)) return;
            this.selected.push(v);
            this.search = '';
            this.highlight = -1;
        },
        remove(v) { this.selected = this.selected.filter(x => x !== v); },
        clear() { this.selected = []; },
        onKeydown(e) {
            if (e.key === 'ArrowDown') { e.preventDefault(); this.open = true; this.highlight = Math.min(this.highlight + 1, this.filteredOptions.length - 1); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); this.highlight = Math.max(this.highlight - 1, 0); }
            else if (e.key === 'Enter') { e.preventDefault(); const o = this.filteredOptions[this.highlight]; if (o) this.add(o.value); }
            else if (e.key === 'Backspace' && this.search === '' && this.selected.length) { this.remove(this.selected[this.selected.length - 1]); }
            else if (e.key === 'Escape') { this.open = false; }
        }
    }"
    x-on:click.outside="open = false"
>
    @if($label)
        <label for="{{ $multiselectId }}" class="aura-label">{{ $label }}</label>
    @endif

    <div class="aura-multiselect-control flex items-center flex-wrap gap-1.5 min-h-[42px] px-3 py-1.5 border border-aura-surface-500 rounded-aura-md bg-aura-surface-0 aura-transition-fast focus-within:border-aura-primary-500 focus-within:shadow-[var(--aura-glow-primary)] {{ $error ? 'border-aura-danger-500' : '' }}"
         x-bind:class="{ 'opacity-50 pointer-events-none': {{ $disabled ? 'true' : 'false' }} }"
         x-on:click="open = true; $refs.search && $refs.search.focus()">
        <template x-for="v in selected" :key="v">
            <span class="aura-multiselect-chip inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-aura-primary-50 text-aura-primary-700 rounded-aura-full">
                <span x-text="labelFor(v)"></span>
                <button type="button" class="inline-flex items-center justify-center min-w-6 min-h-6 p-0.5 bg-transparent border-none text-aura-primary-400 cursor-pointer rounded-full hover:text-aura-primary-700 hover:bg-aura-primary-100" x-on:click.stop="remove(v)" aria-label="{{ __('aura-ui::messages.remove') }}">
                    <x-aura::icon name="x" size="xs" />
                </button>
            </span>
        </template>
        @if($searchable)
            <input type="text" class="aura-multiselect-search flex-1 min-h-6 min-w-[80px] border-none bg-transparent outline-none text-sm text-aura-surface-900 p-0 shadow-none"
                x-ref="search" x-model="search" id="{{ $multiselectId }}" @if($error) aria-invalid="true" aria-describedby="{{ $multiselectIdError }}" @endif 
 x-on:focus="open = true" x-on:keydown="onKeydown($event)"
                x-bind:placeholder="selected.length ? '' : {{ Js::from($placeholder) }}" @if($disabled) disabled @endif autocomplete="off" />
        @else
            <span class="flex-1 text-sm text-aura-surface-400" x-show="!selected.length">{{ $placeholder }}</span>
        @endif
        @if($clearable)
            <button type="button" class="aura-multiselect-clear ml-auto text-aura-surface-400 hover:text-aura-surface-700" x-show="selected.length" x-on:click.stop="clear()" aria-label="{{ __('aura-ui::messages.clear_all') }}">
                <x-aura::icon name="x" size="xs" />
            </button>
        @endif
    </div>

    <div class="aura-multiselect-dropdown absolute top-full left-0 right-0 mt-1 bg-aura-surface-0 border border-aura-surface-200 rounded-aura-lg shadow-aura-xl z-aura-dropdown max-h-[220px] overflow-y-auto p-1"
         role="listbox" x-show="open" x-transition x-cloak>
        <template x-for="opt in filteredOptions" :key="opt.value">
            <button type="button" role="option" class="aura-multiselect-option block w-full text-left px-3 py-1.5 text-sm text-aura-surface-700 bg-transparent border-none cursor-pointer rounded-aura-sm hover:bg-aura-surface-100"
                x-text="opt.label" x-on:click="add(opt.value)"
                x-bind:class="{ 'bg-aura-primary-50 text-aura-primary-700': highlight === filteredOptions.indexOf(opt) }"
                x-bind:aria-selected="selected.includes(opt.value)"></button>
        </template>
        <div class="px-3 py-2 text-sm text-aura-surface-400" x-show="!filteredOptions.length">{{ __('aura-ui::messages.no_options') }}</div>
    </div>

    @if($error)
        <p role="alert" id="{{ $multiselectIdError }}" class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
