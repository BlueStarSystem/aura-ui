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
     * is therefore split visually for the eye and given one plain sentence for
     * a screen reader.
     */
    $formatted = number_format(
        (float) $amount,
        $decimals ?? (fmod((float) $amount, 1.0) === 0.0 ? 0 : 2),
        ',',
        '.'
    );

    $wasFormatted = $was === null ? null : number_format((float) $was, $decimals ?? (fmod((float) $was, 1.0) === 0.0 ? 0 : 2), ',', '.');

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
