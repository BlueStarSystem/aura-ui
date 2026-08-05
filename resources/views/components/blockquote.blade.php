@props([
    'cite' => null,
    'author' => null,
])

<figure {{ $attributes->class(['aura-blockquote']) }}>
    <blockquote @if($cite) cite="{{ $cite }}" @endif class="aura-blockquote-body border-l-4 border-aura-primary-500 pl-4 text-aura-surface-700 italic">
        {{ $slot }}
    </blockquote>

    @if($author)
        {{-- figcaption, not a <p> inside the quote: the attribution is about
             the quote, it is not part of what was said. --}}
        <figcaption class="aura-blockquote-author mt-2 pl-4 text-sm text-aura-surface-600 not-italic">
            — {{ $author }}
        </figcaption>
    @endif
</figure>
