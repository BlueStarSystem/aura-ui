@props([
    'threshold' => 400,
    'position' => 'bottom-right',
    'label' => null,
    'smooth' => true,
])

@php
    $buttonLabel = $label ?? __('aura-ui::messages.back_to_top');

    $positionClass = match ($position) {
        'bottom-left' => 'bottom-6 left-6',
        'bottom-center' => 'bottom-6 left-1/2 -translate-x-1/2',
        default => 'bottom-6 right-6',
    };
@endphp

<button
    type="button"
    {{ $attributes->class([
        'aura-scroll-to-top fixed z-aura-sticky inline-flex h-11 w-11 items-center justify-center rounded-full border border-aura-surface-200 bg-aura-surface-0 text-aura-surface-700 shadow-aura-lg cursor-pointer aura-transition hover:bg-aura-surface-50 hover:text-aura-surface-900',
        $positionClass,
    ]) }}
    aria-label="{{ $buttonLabel }}"
    x-data="{
        shown: false,

        init() {
            this.check();
            window.addEventListener('scroll', () => this.check(), { passive: true });
        },

        check() { this.shown = window.scrollY > {{ (int) $threshold }}; },

        toTop() {
            // Honour a reduced-motion preference: a long smooth scroll is one
            // of the motions that makes people ill, and this is exactly the
            // kind of nicety that ignores the setting.
            const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            window.scrollTo({ top: 0, behavior: (reduced || !{{ $smooth ? 'true' : 'false' }}) ? 'auto' : 'smooth' });

            // Sending focus back to the top matters more than the animation:
            // without it the keyboard stays where it was and the page has
            // scrolled away underneath it.
            const target = document.querySelector('main, [role=main], h1') ?? document.body;
            target.setAttribute('tabindex', '-1');
            target.focus({ preventScroll: true });
        }
    }"
    x-show="shown"
    x-transition:enter="aura-transition"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="aura-transition-fast"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
    x-on:click="toTop()"
>
    <x-aura::icon name="arrow-up" size="sm" aria-hidden="true" />
</button>
