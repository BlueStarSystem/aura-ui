@props([
    'label' => null,
    'name' => 'amount',
    'value' => null,
    'currency' => 'EUR',
    'locale' => null,
    'min' => null,
    'max' => null,
    'step' => '0.01',
    'hint' => null,
    'error' => null,
    'size' => 'md',
    'disabled' => false,
    'required' => false,
])

@php
    use BlueStarSystem\AuraUI\Support\Html;
    use BlueStarSystem\AuraUI\Support\InputStyle;

    /**
     * An amount of money, typed the way the reader writes numbers.
     *
     * Two problems this exists to avoid. A plain `type="number"` shows a
     * spinner nobody wants on a price and, in several locales, silently
     * refuses the comma people actually type. And a field formatted for display
     * usually posts its formatting: "1.234,56" arrives at the server, which
     * reads it as 1.234 and takes a thousand euro off the invoice.
     *
     * So: the visible field is text and accepts either separator, and a hidden
     * field carries the machine value — a dot decimal, no grouping, always.
     */
    $currencyId = Html::fieldId($attributes->get('id'), $name, $label, Html::wireModelFrom($attributes->getAttributes()));
    $descriptionId = $currencyId.'-description';

    $resolvedLocale = $locale ?? app()->getLocale();

    $symbols = ['EUR' => '€', 'USD' => '$', 'GBP' => '£', 'CHF' => 'CHF', 'JPY' => '¥'];
    $symbol = $symbols[strtoupper($currency)] ?? strtoupper($currency);

    // How this locale writes one thousand and a half, so the browser can copy it.
    $decimalSeparator = ',';
    $groupSeparator = '.';

    if (class_exists(\NumberFormatter::class)) {
        $formatter = new \NumberFormatter($resolvedLocale, \NumberFormatter::DECIMAL);
        $decimalSeparator = $formatter->getSymbol(\NumberFormatter::DECIMAL_SEPARATOR_SYMBOL);
        $groupSeparator = $formatter->getSymbol(\NumberFormatter::GROUPING_SEPARATOR_SYMBOL);
    }

    $initial = $value === null || $value === ''
        ? ''
        : number_format((float) $value, 2, $decimalSeparator, $groupSeparator);

    $describedBy = ($error || $hint)
        ? Html::describedBy($attributes->get('aria-describedby'), $descriptionId)
        : $attributes->get('aria-describedby');
@endphp

<div
    {{ $attributes->except(['id', 'aria-describedby'])->class(['aura-currency-input flex w-full max-w-[280px] flex-col gap-1.5']) }}
    x-data="{
        display: {{ Js::from($initial) }},
        decimal: {{ Js::from($decimalSeparator) }},
        group: {{ Js::from($groupSeparator) }},

        /** The machine value: a dot decimal and nothing else. */
        get plain() {
            const cleaned = this.display
                .split(this.group).join('')
                .split(this.decimal).join('.')
                .replace(/[^0-9.\-]/g, '');

            return cleaned === '' || isNaN(Number(cleaned)) ? '' : cleaned;
        },

        /** Typing is left alone; tidying happens when the field is left. */
        onBlur() {
            if (this.plain === '') { this.display = ''; return; }

            const parts = Number(this.plain).toFixed(2).split('.');
            const whole = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, this.group);

            this.display = whole + this.decimal + parts[1];
        }
    }"
>
    @if($label)
        <label for="{{ $currencyId }}" class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">{{ $label }}</label>
    @endif

    <div class="aura-currency-input-control relative">
        {{-- Decoration: the currency is already in the field's description, and
             read twice it is noise. --}}
        <span class="aura-currency-input-symbol pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-aura-surface-600" aria-hidden="true">{{ $symbol }}</span>

        <input
            id="{{ $currencyId }}"
            type="text"
            {{-- `decimal` rather than `numeric`: it brings up a keypad that has
                 the separator on it. --}}
            inputmode="decimal"
            autocomplete="off"
            class="{{ InputStyle::classes($size, (bool) $error, (bool) $disabled) }} pl-9 text-right tabular-nums"
            x-model="display"
            x-on:blur="onBlur()"
            @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @if($error) aria-invalid="true" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
        />
    </div>

    <input
        type="hidden"
        name="{{ $name }}"
        x-bind:value="plain"
        @if($min !== null) data-min="{{ $min }}" @endif
        @if($max !== null) data-max="{{ $max }}" @endif
        data-step="{{ $step }}"
    />

    @if($error)
        <p id="{{ $descriptionId }}" role="alert" class="aura-currency-input-error text-xs font-medium text-aura-danger-500">{{ $error }}</p>
    @else
        <p id="{{ $descriptionId }}" class="aura-currency-input-hint text-xs text-aura-surface-600">
            {{ $hint ?? __('aura-ui::messages.currency.hint', ['currency' => strtoupper($currency)]) }}
        </p>
    @endif
</div>
