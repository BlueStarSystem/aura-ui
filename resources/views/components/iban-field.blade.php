@props([
    'label' => null,
    'name' => 'iban',
    'value' => null,
    'hint' => null,
    'error' => null,
    'size' => 'md',
    'disabled' => false,
    'required' => false,
])

@php
    use BlueStarSystem\AuraUI\Support\Html;
    use BlueStarSystem\AuraUI\Support\Iban;
    use BlueStarSystem\AuraUI\Support\InputStyle;

    /**
     * A bank account number, printed the way a bank prints it.
     *
     * The grouping into fours is not decoration: it is how the number appears
     * on a statement, and reading a 27-character string back without it is
     * where the typos come from. The field regroups as you type and strips the
     * spaces again before the form posts, so the value that arrives is the
     * plain one.
     *
     * The checksum runs in the browser as a courtesy, so a mistake is caught
     * before the page reloads. It is not the answer: validate on the server
     * with `BlueStarSystem\AuraUI\Rules\Iban`, which is the same arithmetic
     * where it counts.
     */
    $ibanId = Html::fieldId($attributes->get('id'), $name, $label, Html::wireModelFrom($attributes->getAttributes()));
    $descriptionId = $ibanId.'-description';

    $initial = $value ? Iban::format((string) $value) : '';

    $describedBy = ($error || $hint)
        ? Html::describedBy($attributes->get('aria-describedby'), $descriptionId)
        : $attributes->get('aria-describedby');
@endphp

<div
    {{ $attributes->except(['id', 'aria-describedby'])->class(['aura-iban-field flex w-full max-w-[340px] flex-col gap-1.5']) }}
    x-data="{
        display: {{ Js::from($initial) }},

        get plain() { return this.display.replace(/[^0-9A-Za-z]/g, '').toUpperCase(); },

        onInput() {
            const caretAtEnd = this.$refs.field.selectionStart === this.display.length;
            this.display = (this.plain.match(/.{1,4}/g) || []).join(' ');

            // Regrouping rewrites the value, which sends the caret to the end.
            // Only acceptable when it was already there.
            if (! caretAtEnd) this.$nextTick(() => this.$refs.field.setSelectionRange(this.display.length, this.display.length));
        },

        get looksValid() {
            const value = this.plain;
            if (! /^[A-Z]{2}[0-9]{2}[A-Z0-9]{6,30}$/.test(value)) return null;

            const rearranged = value.slice(4) + value.slice(0, 4);
            let digits = '';
            for (const character of rearranged) {
                digits += /[A-Z]/.test(character) ? String(character.charCodeAt(0) - 55) : character;
            }

            let remainder = 0;
            for (let i = 0; i < digits.length; i += 7) {
                remainder = Number(String(remainder) + digits.slice(i, i + 7)) % 97;
            }

            return remainder === 1;
        }
    }"
>
    @if($label)
        <label for="{{ $ibanId }}" class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">{{ $label }}</label>
    @endif

    <input
        id="{{ $ibanId }}"
        x-ref="field"
        type="text"
        class="{{ InputStyle::classes($size, (bool) $error, (bool) $disabled) }} font-aura-mono uppercase"
        inputmode="text"
        autocomplete="off"
        spellcheck="false"
        x-model="display"
        x-on:input="onInput()"
        @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
        @if($error) aria-invalid="true" @else x-bind:aria-invalid="looksValid === false ? 'true' : null" @endif
        @if($required) required @endif
        @if($disabled) disabled @endif
        placeholder="IT60 X054 2811 1010 0000 0123 456"
    />

    {{-- The spaces are for reading. What posts is the plain number. --}}
    <input type="hidden" name="{{ $name }}" x-bind:value="plain" />

    @if($error)
        <p id="{{ $descriptionId }}" role="alert" class="aura-iban-field-error text-xs font-medium text-aura-danger-700 dark:text-aura-danger-500">{{ $error }}</p>
    @else
        <p
            id="{{ $descriptionId }}"
            class="aura-iban-field-hint text-xs text-aura-surface-600"
            x-bind:class="{ 'text-aura-danger-500 font-medium': looksValid === false }"
        >
            <span x-show="looksValid !== false">{{ $hint ?? __('aura-ui::messages.iban.hint') }}</span>
            {{-- role="alert" only on the branch that is an error, so the hint is
                 not re-announced every time the field is touched. --}}
            <span x-show="looksValid === false" x-cloak role="alert">{{ __('aura-ui::messages.iban.invalid') }}</span>
        </p>
    @endif
</div>
