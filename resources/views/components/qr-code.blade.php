@props([
    'value' => '',
    'label' => null,
    'size' => 200,
    'margin' => 1,
    'showValue' => false,
    'caption' => null,
])

@php
    use BlueStarSystem\AuraUI\Support\Html;
    use BlueStarSystem\AuraUI\Support\QrCode;

    /**
     * A QR code with something to read when you cannot scan it.
     *
     * A QR code is a picture of a string. Ship it as an unnamed <svg> or a
     * <canvas> — which is what most libraries do — and it is nothing at all to
     * a screen reader, to a text browser, or to anyone whose camera is not
     * working. So the encoded value is always in the accessible name, and can
     * be shown as text underneath.
     *
     * Drawn on the server: no canvas script for a content security policy to
     * block, and the code is in the HTML rather than appearing a second later.
     */
    $svg = QrCode::svg((string) $value, (int) $size, (int) $margin);

    $name = $label ?: $value;

    // A link is worth linking. Anything else stays plain text so a QR code for
    // a Wi-Fi network or a payment string is not turned into a dead anchor
    // pointing at '#'.
    $isLink = preg_match('#^(https?|mailto|tel):#i', (string) $value) === 1;
    $href = $isLink ? Html::url((string) $value) : null;
@endphp

<figure {{ $attributes->class(['aura-qr-code inline-flex flex-col items-center gap-2']) }}>
    @if($svg)
        {{-- The white plate is not decoration: a dark module on a dark page is
             not scannable, and dark mode would otherwise invert around it. --}}
        <div
            class="aura-qr-code-plate rounded-aura-md bg-white p-2"
            role="img"
            aria-label="{{ $name }}"
        >{!! $svg !!}</div>
    @else
        <div class="aura-qr-code-missing rounded-aura-md border border-dashed border-aura-surface-400 p-4 text-center text-xs text-aura-surface-600">
            {{ __('aura-ui::messages.qr_code.unavailable') }}
        </div>
    @endif

    @if($showValue || ! $svg)
        <figcaption class="aura-qr-code-value max-w-[240px] break-all text-center text-xs text-aura-surface-600">
            @if($href)
                <a href="{{ $href }}" class="underline underline-offset-2 hover:no-underline">{{ $value }}</a>
            @else
                {{ $value }}
            @endif
        </figcaption>
    @elseif($caption)
        <figcaption class="aura-qr-code-caption text-center text-xs text-aura-surface-600">{{ $caption }}</figcaption>
    @endif
</figure>
