@props([
    'label' => null,
    'orientation' => 'horizontal',
])

@php
    /**
     * A group of controls that behaves as one tab stop.
     *
     * That is the whole point of role="toolbar": Tab moves past the toolbar
     * rather than through every button in it, and the arrow keys move inside.
     * Ten buttons in a div means ten tab presses to get past a formatting bar.
     *
     * The roving tabindex is what makes it true, so it is implemented here
     * rather than left to the caller to remember.
     */
    $isVertical = $orientation === 'vertical';
@endphp

<div
    {{ $attributes->class([
        'aura-toolbar inline-flex items-center gap-1 rounded-aura-md border border-aura-surface-200 bg-aura-surface-0 p-1',
        $isVertical ? 'flex-col' : 'flex-row',
    ]) }}
    role="toolbar"
    aria-label="{{ $label ?? __('aura-ui::messages.toolbar') }}"
    @if($isVertical) aria-orientation="vertical" @endif
    x-data="{
        items() {
            return Array.from(this.$el.querySelectorAll('button, a[href], [role=button]'))
                .filter((el) => !el.disabled && el.getAttribute('aria-hidden') !== 'true');
        },

        init() {
            // One tab stop: the first control is reachable, the rest are not
            // until you are inside.
            this.$nextTick(() => {
                const items = this.items();
                items.forEach((el, i) => el.setAttribute('tabindex', i === 0 ? '0' : '-1'));
            });
        },

        move(delta) {
            const items = this.items();
            if (!items.length) return;

            const current = items.indexOf(document.activeElement);
            const next = items[(Math.max(current, 0) + delta + items.length) % items.length];

            items.forEach((el) => el.setAttribute('tabindex', '-1'));
            next.setAttribute('tabindex', '0');
            next.focus();
        },

        edge(last) {
            const items = this.items();
            if (!items.length) return;

            const target = last ? items[items.length - 1] : items[0];
            items.forEach((el) => el.setAttribute('tabindex', '-1'));
            target.setAttribute('tabindex', '0');
            target.focus();
        }
    }"
    @if($isVertical)
        x-on:keydown.arrow-down.prevent="move(1)"
        x-on:keydown.arrow-up.prevent="move(-1)"
    @else
        x-on:keydown.arrow-right.prevent="move(1)"
        x-on:keydown.arrow-left.prevent="move(-1)"
    @endif
    x-on:keydown.home.prevent="edge(false)"
    x-on:keydown.end.prevent="edge(true)"
>
    {{ $slot }}
</div>
