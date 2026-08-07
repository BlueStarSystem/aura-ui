@props([
    'amount' => 0,
    'currency' => '€',
    'period' => null,
    'was' => null,
    'size' => 'lg',
    'decimals' => null,
    'locale' => null,
])

@php
    /**
     * A price is read aloud badly when it is only styled: "€" as a superscript
     * and "/mo" as small print become "euro sign twelve slash m o". The figure
     * is split visually for the eye and given one plain sentence for a screen
     * reader.
     *
     * The number itself follows the application's locale. This used to be
     * hardcoded to the European convention — '1.234,56' — which is simply the
     * wrong number to an American reader, and the component ships to both.
     */
    $activeLocale = $locale ?? app()->getLocale();

    $format = function (float $value) use ($activeLocale, $decimals): string {
        $places = $decimals ?? (fmod($value, 1.0) === 0.0 ? 0 : 2);

        // intl knows every convention; without it, fall back to PHP's default,
        // which is the English one rather than a guess.
        if (class_exists(\NumberFormatter::class)) {
            $formatter = new \NumberFormatter($activeLocale, \NumberFormatter::DECIMAL);
            $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $places);
            $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $places);

            $formatted = $formatter->format($value);

            if ($formatted !== false) {
                return $formatted;
            }
        }

        return number_format($value, $places);
    };

    $formatted = $format((float) $amount);
    $wasFormatted = $was === null ? null : $format((float) $was);

    $sizeClass = match ($size) {
        'sm' => 'text-xl',
        'md' => 'text-3xl',
        'xl' => 'text-6xl',
        default => 'text-4xl',
    };

    $spoken = trim(
        ($wasFormatted !== null ? __('aura-ui::messages.price_was', ['price' => $currency.$wasFormatted]).', ' : '')
        .$currency.$formatted
        .($period ? ' '.__('aura-ui::messages.price_per', ['period' => $period]) : '')
    );
@endphp

<span {{ $attributes->class(['aura-price inline-flex items-baseline gap-1']) }}>
    {{-- One sentence for a screen reader; the pieces below are for the eye and
         are hidden from it, so the figure is not read twice. --}}
    <span class="aura-visually-hidden">{{ $spoken }}</span>

    <span aria-hidden="true" class="inline-flex items-baseline gap-1">
        @if($wasFormatted !== null)
            <s class="aura-price-was text-aura-surface-600 {{ $size === 'xl' ? 'text-2xl' : 'text-base' }}">{{ $currency }}{{ $wasFormatted }}</s>
        @endif

        <span class="aura-price-currency font-semibold text-aura-surface-700">{{ $currency }}</span>
        <span class="aura-price-amount font-extrabold tracking-tight text-aura-surface-900 {{ $sizeClass }}">{{ $formatted }}</span>

        @if($period)
            <span class="aura-price-period text-sm font-medium text-aura-surface-600">/{{ $period }}</span>
        @endif
    </span>
</span>
