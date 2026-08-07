@props([
    'src' => null,
    'alt' => null,
    'ratio' => null,
    'fit' => 'cover',
    'rounded' => 'md',
    'caption' => null,
    'decorative' => false,
    'lazy' => true,
    'fallback' => null,
])

@php
    /**
     * `alt` has no default on purpose. An image with no alt is announced by its
     * filename, which is worse than nothing; an image with alt="" is skipped
     * silently, which is right only when it is decoration. Only the caller
     * knows which is meant, so `decorative` is explicit rather than inferred
     * from an empty string.
     */
    $altText = $decorative ? '' : (string) ($alt ?? '');

    $fitClass = match ($fit) {
        'contain' => 'object-contain',
        'fill' => 'object-fill',
        'none' => 'object-none',
        default => 'object-cover',
    };

    $roundedClass = match ($rounded) {
        'none' => '',
        'sm' => 'rounded-aura-sm',
        'lg' => 'rounded-aura-lg',
        'full' => 'rounded-aura-full',
        default => 'rounded-aura-md',
    };

    $imgClass = trim('aura-image '.$fitClass.' '.($ratio ? 'h-full w-full' : $roundedClass));

    $ratioStyle = $ratio
        ? 'aspect-ratio: '.(\BlueStarSystem\AuraUI\Support\Html::cssValue($ratio) ?? '16/9')
        : null;
@endphp

<figure {{ $attributes->class(['aura-image-figure', $caption ? '' : 'contents']) }}>
    @if($ratio)
        <div class="aura-image-frame overflow-hidden {{ $roundedClass }}" style="{{ $ratioStyle }}">
    @endif

    <img
        class="{{ $imgClass }}"
        src="{{ \BlueStarSystem\AuraUI\Support\Html::src($src) }}"
        alt="{{ $altText }}"
        @if($decorative) aria-hidden="true" @endif
        @if($lazy) loading="lazy" decoding="async" @endif
        @if($fallback)
            {{-- A broken image otherwise leaves a torn-page icon and the alt
                 text where a picture should be. --}}
            onerror="this.onerror=null;this.src={{ Js::from(\BlueStarSystem\AuraUI\Support\Html::src($fallback)) }}"
        @endif
    />

    @if($ratio)
        </div>
    @endif

    @if($caption)
        <figcaption class="aura-image-caption mt-2 text-sm text-aura-surface-600">{{ $caption }}</figcaption>
    @endif
</figure>
