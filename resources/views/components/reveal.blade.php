@props([
    'direction' => 'up',
    'delay' => 0,
    'duration' => 600,
    'once' => true,
    'as' => 'div',
])

@php
    /**
     * Content that eases in as it scrolls into view.
     *
     * The two things this must never do: hide content from assistive
     * technology, and animate for someone who asked for less motion. It is
     * therefore only ever opacity and transform — the element is in the
     * accessibility tree the whole time — and with prefers-reduced-motion the
     * content is simply there.
     */
    $tag = in_array($as, ['div', 'section', 'article', 'li', 'span'], true) ? $as : 'div';

    $offset = match ($direction) {
        'down' => 'translateY(-1rem)',
        'left' => 'translateX(1rem)',
        'right' => 'translateX(-1rem)',
        'none' => 'none',
        default => 'translateY(1rem)',
    };
@endphp

<{{ $tag }}
    {{ $attributes->class(['aura-reveal']) }}
    x-data="{
        revealed: false,

        init() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                this.revealed = true;
                return;
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        this.revealed = true;
                        if ({{ $once ? 'true' : 'false' }}) observer.disconnect();
                    } else if (! {{ $once ? 'true' : 'false' }}) {
                        this.revealed = false;
                    }
                });
            }, { threshold: 0.15 });

            observer.observe(this.$el);
        }
    }"
    x-bind:style="revealed
        ? 'opacity:1; transform:none; transition: opacity {{ (int) $duration }}ms ease {{ (int) $delay }}ms, transform {{ (int) $duration }}ms cubic-bezier(0.16,1,0.3,1) {{ (int) $delay }}ms'
        : 'opacity:0; transform:{{ $offset }}'"
>
    {{ $slot }}
</{{ $tag }}>
