@props([
    'label' => null,
    'placeholder' => null,
    'options' => [],
    'name' => null,
    'value' => null,
    'allowCustom' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'size' => 'md',
    'noResultsText' => null,
])

@php
    use BlueStarSystem\AuraUI\Support\Html;
    use BlueStarSystem\AuraUI\Support\InputStyle;

    /**
     * A field you can type into that also has a list to choose from.
     *
     * The ARIA combobox pattern in full, which is the part usually skipped:
     * the input keeps the focus at all times and points at the highlighted
     * option with aria-activedescendant, so arrowing through the list is
     * announced. The options are plain elements with role="option", not
     * buttons — a button inside a listbox is reachable with Tab, which breaks
     * the pattern and traps a keyboard inside the popup.
     *
     * `allowCustom` decides whether typed text that matches nothing is a value
     * or a mistake, and the field says which in its own hint.
     */
    $comboId = Html::fieldId($attributes->get('id'), $name, $label, Html::wireModelFrom($attributes->getAttributes()));
    $listId = $comboId.'-listbox';
    $descriptionId = $comboId.'-description';

    $items = [];
    foreach ($options as $key => $option) {
        $items[] = is_array($option) || is_object($option)
            ? ['value' => (string) (((array) $option)['value'] ?? $key), 'label' => (string) (((array) $option)['label'] ?? $key)]
            : ['value' => is_int($key) ? (string) $option : (string) $key, 'label' => (string) $option];
    }

    $describedBy = ($error || $hint)
        ? Html::describedBy($attributes->get('aria-describedby'), $descriptionId)
        : $attributes->get('aria-describedby');
@endphp

<div
    {{ $attributes->except(['id', 'aria-describedby'])->class(['aura-combobox-wrapper relative flex aura-field w-full flex-col gap-1.5']) }}
    x-data="{
        open: false,
        query: {{ Js::from((string) $value) }},
        selected: {{ Js::from((string) $value) }},
        active: -1,
        items: {{ Js::from($items) }},
        allowCustom: {{ Js::from((bool) $allowCustom) }},

        get matches() {
            const q = this.query.trim().toLowerCase();

            return q === '' ? this.items : this.items.filter((i) => i.label.toLowerCase().includes(q));
        },

        get activeId() {
            const match = this.matches[this.active];

            return match ? {{ Js::from($comboId) }} + '-option-' + match.value : null;
        },

        show() { if (! this.open) { this.open = true; this.active = -1; } },

        choose(item) {
            this.selected = item.value;
            this.query = item.label;
            this.open = false;
            this.active = -1;
        },

        move(step) {
            this.show();
            const count = this.matches.length;
            if (! count) return;

            this.active = (this.active + step + count) % count;
        },

        commit() {
            if (this.active >= 0 && this.matches[this.active]) {
                this.choose(this.matches[this.active]);

                return;
            }

            // Typed text that matches nothing: either it is the value, or the
            // field goes back to the last thing that was actually chosen.
            const exact = this.items.find((i) => i.label.toLowerCase() === this.query.trim().toLowerCase());

            if (exact) { this.choose(exact); return; }

            this.selected = this.allowCustom ? this.query.trim() : this.selected;
            if (! this.allowCustom) { this.query = (this.items.find((i) => i.value === this.selected) || {}).label || ''; }
            this.open = false;
        }
    }"
    x-on:click.outside="if (open) { open = false; commit(); }"
>
    @if($label)
        <label id="{{ $comboId }}-label" for="{{ $comboId }}" class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">{{ $label }}</label>
    @endif

    <div class="aura-combobox-control relative">
        <input
            id="{{ $comboId }}"
            type="text"
            role="combobox"
            class="{{ InputStyle::classes($size, (bool) $error, (bool) $disabled) }} pr-9"
            autocomplete="off"
            aria-autocomplete="list"
            aria-controls="{{ $listId }}"
            x-bind:aria-expanded="open ? 'true' : 'false'"
            x-bind:aria-activedescendant="open ? activeId : null"
            @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @if($error) aria-invalid="true" @endif
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($disabled) disabled @endif
            x-model="query"
            x-on:input="show()"
            x-on:keydown.arrow-down.prevent="move(1)"
            x-on:keydown.arrow-up.prevent="move(-1)"
            x-on:keydown.enter.prevent="commit()"
            x-on:keydown.escape="open = false; active = -1"
            x-on:keydown.tab="if (open) commit()"
        />

        @if($name)
            <input type="hidden" name="{{ $name }}" x-bind:value="selected" />
        @endif

        {{-- A pointer needs a way to open the list without typing. It is not in
             the tab order: the input beside it already does this with a key. --}}
        <button
            type="button"
            class="aura-combobox-toggle absolute right-1 top-1/2 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-aura-sm text-aura-surface-600 cursor-pointer hover:bg-aura-surface-100"
            tabindex="-1"
            aria-hidden="true"
            x-on:click="open ? (open = false) : ($refs.list && show())"
            @if($disabled) disabled @endif
        >
            <x-aura::icon name="chevron-down" size="xs" />
        </button>

        {{-- Inside the control, not the wrapper: anchored to the wrapper it
             opened below the hint text and covered it. --}}
        <ul
        id="{{ $listId }}"
        x-ref="list"
        role="listbox"
        {{-- Pointed at the same label rather than repeating its text: two
             elements carrying the same name read as two of the same thing. --}}
        @if($label) aria-labelledby="{{ $comboId }}-label" @endif
        class="aura-combobox-list absolute top-full left-0 right-0 z-aura-dropdown mt-1 max-h-[220px] overflow-y-auto rounded-aura-lg border border-aura-surface-200 bg-aura-surface-0 p-1 shadow-aura-xl"
        x-show="open && matches.length > 0"
        x-cloak
        tabindex="-1"
    >
        <template x-for="(item, index) in matches" :key="item.value">
            <li
                x-bind:id="{{ Js::from($comboId) }} + '-option-' + item.value"
                role="option"
                class="aura-combobox-option cursor-pointer rounded-aura-sm px-3 py-2 text-sm text-aura-surface-800"
                x-bind:class="{ 'bg-aura-surface-100': active === index, 'font-semibold text-aura-primary-700': selected === item.value }"
                x-bind:aria-selected="selected === item.value ? 'true' : 'false'"
                x-on:click="choose(item)"
                x-on:mousemove="active = index"
                x-text="item.label"
            ></li>
        </template>
        </ul>
    </div>

    {{-- Said once, in a live region, rather than leaving the list silently
         empty: nothing announces the absence of options otherwise. --}}
    <p
        class="aura-combobox-empty text-xs text-aura-surface-600"
        role="status"
        x-show="open && matches.length === 0"
        x-cloak
    >{{ $noResultsText ?? __('aura-ui::messages.combobox.no_results') }}</p>

    @if($error)
        <p id="{{ $descriptionId }}" role="alert" class="aura-combobox-error text-xs font-medium text-aura-danger-700 dark:text-aura-danger-500">{{ $error }}</p>
    @elseif($hint)
        <p id="{{ $descriptionId }}" class="aura-combobox-hint text-xs text-aura-surface-600">{{ $hint }}</p>
    @endif
</div>
