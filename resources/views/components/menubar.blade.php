@props([
    'label' => null,
])

@php
    /**
     * The menu bar of a desktop application: File, Edit, View.
     *
     * The keyboard behaviour is the whole point, and it is what makes this
     * different from a row of dropdowns. One stop in the tab order for the
     * entire bar — a roving tabindex moves the focus between the menus with
     * Left and Right, so Tab leaves the bar rather than walking through every
     * menu in it. Down opens a menu, Escape closes it and puts the focus back
     * on its own trigger.
     */
@endphp

<div
    {{ $attributes->class(['aura-menubar flex items-center gap-1 rounded-aura-md border border-aura-surface-200 bg-aura-surface-0 p-1']) }}
    role="menubar"
    aria-label="{{ $label ?? __('aura-ui::messages.menubar.label') }}"
    x-data="{
        openIndex: null,

        get triggers() { return [...this.$el.querySelectorAll('[data-aura-menubar-trigger]')]; },

        focusAt(index) {
            const triggers = this.triggers;
            if (! triggers.length) return;

            const next = (index + triggers.length) % triggers.length;
            // Roving tabindex: only the focused trigger is in the tab order.
            triggers.forEach((t, i) => t.setAttribute('tabindex', i === next ? '0' : '-1'));
            triggers[next].focus();

            if (this.openIndex !== null) this.openIndex = next;
        },

        indexOf(el) { return this.triggers.indexOf(el.closest('[data-aura-menubar-trigger]')); },

        toggle(index) { this.openIndex = this.openIndex === index ? null : index; },

        close(focusTrigger = true) {
            const index = this.openIndex;
            this.openIndex = null;
            if (focusTrigger && index !== null) this.triggers[index]?.focus();
        }
    }"
    x-on:keydown.arrow-right.prevent="focusAt(indexOf($event.target) + 1)"
    x-on:keydown.arrow-left.prevent="focusAt(indexOf($event.target) - 1)"
    x-on:keydown.home.prevent="focusAt(0)"
    x-on:keydown.end.prevent="focusAt(triggers.length - 1)"
    x-on:keydown.escape="close()"
    x-on:click.outside="close(false)"
>
    {{ $slot }}
</div>
