@props([
    'label' => null,
    'name' => 'phone',
    'value' => null,
    'default' => 'IT',
    'countries' => null,
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
     * A telephone number with its country code, kept as two things.
     *
     * The usual version of this is a flag in a dropdown that is not a form
     * control, a number that posts without its prefix, and no way to tell a
     * screen reader which country is selected. Here the prefix is a real
     * `<select>` with its own name and its own label, the number is a real
     * `type="tel"` field, and a hidden input carries the two joined together in
     * the form anything downstream actually wants: +39 followed by the digits.
     *
     * No flags. A flag is not a language and not a dialling code, and the two
     * disagree often enough to matter.
     */
    $phoneId = Html::fieldId($attributes->get('id'), $name, $label, Html::wireModelFrom($attributes->getAttributes()));
    $descriptionId = $phoneId.'-description';

    $defaults = [
        'IT' => ['+39', 'Italy'], 'FR' => ['+33', 'France'], 'DE' => ['+49', 'Germany'],
        'ES' => ['+34', 'Spain'], 'PT' => ['+351', 'Portugal'], 'NL' => ['+31', 'Netherlands'],
        'BE' => ['+32', 'Belgium'], 'AT' => ['+43', 'Austria'], 'CH' => ['+41', 'Switzerland'],
        'GB' => ['+44', 'United Kingdom'], 'IE' => ['+353', 'Ireland'], 'US' => ['+1', 'United States'],
    ];

    $list = $countries ?? $defaults;

    // A number already in international form arrives split, so the prefix does
    // not end up typed twice.
    $prefix = null;
    $national = (string) ($value ?? '');

    if (str_starts_with($national, '+')) {
        foreach ($list as $entry) {
            $candidate = is_array($entry) ? $entry[0] : $entry;

            if (str_starts_with($national, $candidate) && strlen($candidate) > strlen((string) $prefix)) {
                $prefix = $candidate;
            }
        }

        if ($prefix !== null) {
            $national = trim(substr($national, strlen($prefix)));
        }
    }

    $prefix ??= (is_array($list[$default] ?? null) ? $list[$default][0] : null) ?? '+39';

    $describedBy = ($error || $hint)
        ? Html::describedBy($attributes->get('aria-describedby'), $descriptionId)
        : $attributes->get('aria-describedby');
@endphp

<div
    {{ $attributes->except(['id', 'aria-describedby'])->class(['aura-phone-input flex aura-field w-full flex-col gap-1.5']) }}
    x-data="{
        prefix: {{ Js::from($prefix) }},
        national: {{ Js::from($national) }},

        get full() {
            const digits = this.national.replace(/[^0-9]/g, '');

            return digits === '' ? '' : this.prefix + digits;
        }
    }"
>
    @if($label)
        <label for="{{ $phoneId }}" class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">{{ $label }}</label>
    @endif

    <div class="aura-phone-input-control flex items-stretch gap-2">
        <select
            class="{{ InputStyle::classes($size, (bool) $error, (bool) $disabled) }} w-auto shrink-0"
            {{-- Its own name, because "the country code" is a thing a screen
                 reader has to be able to say without guessing from position. --}}
            aria-label="{{ __('aura-ui::messages.phone.country_code') }}"
            x-model="prefix"
            @if($disabled) disabled @endif
        >
            @foreach($list as $code => $entry)
                @php($dial = is_array($entry) ? $entry[0] : $entry)
                @php($country = is_array($entry) ? ($entry[1] ?? $code) : $code)
                <option value="{{ $dial }}">{{ $country }} ({{ $dial }})</option>
            @endforeach
        </select>

        <input
            id="{{ $phoneId }}"
            type="tel"
            inputmode="tel"
            autocomplete="tel-national"
            class="{{ InputStyle::classes($size, (bool) $error, (bool) $disabled) }}"
            x-model="national"
            @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @if($error) aria-invalid="true" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
        />
    </div>

    {{-- What posts is the whole number, not the half of it that was typed. --}}
    <input type="hidden" name="{{ $name }}" x-bind:value="full" />

    @if($error)
        <p id="{{ $descriptionId }}" role="alert" class="aura-phone-input-error text-xs font-medium text-aura-danger-700 dark:text-aura-danger-500">{{ $error }}</p>
    @elseif($hint)
        <p id="{{ $descriptionId }}" class="aura-phone-input-hint text-xs text-aura-surface-600">{{ $hint }}</p>
    @endif
</div>
