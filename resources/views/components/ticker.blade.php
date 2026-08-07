@props([
    'value' => 0,
    'from' => 0,
    'duration' => 1200,
    'prefix' => null,
    'suffix' => null,
    'decimals' => 0,
    'label' => null,
])

@php
    /**
     * A figure that counts up when it comes into view.
     *
     * The final value is in the markup from the start, so it is right without
     * JavaScript, right for a crawler, and right for anyone who asked for less
     * motion — for them the animation simply never runs. Counting from zero
     * while a screen reader reads would announce a stream of meaningless
     * numbers, so the live region is deliberately absent and the accessible
     * name carries the final figure.
     */
    $finalText = number_format((float) $value, (int) $decimals, ',', '.');
    $spoken = trim(($label ? $label.': ' : '').($prefix ?? '').$finalText.($suffix ?? ''));
@endphp

<span
    {{ $attributes->class(['aura-ticker inline-flex items-baseline tabular-nums']) }}
    role="img"
    aria-label="{{ $spoken }}"
    x-data="{
        shown: {{ Js::from($finalText) }},

        init() {
            const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (reduced) return;

            const observer = new IntersectionObserver((entries) => {
                if (!entries[0].isIntersecting) return;
                observer.disconnect();
                this.run();
            }, { threshold: 0.4 });

            observer.observe(this.$el);
        },

        run() {
            const from = {{ (float) $from }};
            const to = {{ (float) $value }};
            const duration = {{ (int) $duration }};
            const decimals = {{ (int) $decimals }};
            const started = performance.now();

            const step = (now) => {
                const progress = Math.min(1, (now - started) / duration);
                // Ease-out: fast at first, settling at the end.
                const eased = 1 - Math.pow(1 - progress, 3);
                const current = from + (to - from) * eased;

                this.shown = current.toLocaleString('it-IT', {
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals,
                });

                if (progress < 1) requestAnimationFrame(step);
            };

            requestAnimationFrame(step);
        }
    }"
>
    <span aria-hidden="true">
        @if($prefix)<span class="aura-ticker-prefix">{{ $prefix }}</span>@endif
        <span class="aura-ticker-value" x-text="shown">{{ $finalText }}</span>
        @if($suffix)<span class="aura-ticker-suffix">{{ $suffix }}</span>@endif
    </span>
</span>
