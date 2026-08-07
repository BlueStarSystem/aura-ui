@props([
    'label' => null,
])

@php
    /**
     * The site navigation with drop-down panels — the "mega menu".
     *
     * Built as disclosures (a button with aria-expanded controlling a panel),
     * not as role="menubar". A menubar is for an application's command menus
     * and it takes the keyboard hostage: arrows move, Tab leaves the whole
     * thing, and links inside stop behaving like links. For site navigation the
     * disclosure pattern is what the ARIA authoring practices recommend, and it
     * is the one that keeps Tab working the way people expect.
     */
@endphp

<nav
    {{ $attributes->class(['aura-navigation-menu relative']) }}
    aria-label="{{ $label ?? __('aura-ui::messages.primary_navigation') }}"
    x-data="{
        open: null,
        toggle(id) { this.open = this.open === id ? null : id; },
        close() { this.open = null; }
    }"
    x-on:keydown.escape="if (open) { const id = open; close(); $refs['trigger-' + id]?.focus(); }"
    x-on:click.outside="close()"
    x-on:focusout="if (! $el.contains($event.relatedTarget)) close()"
>
    <ul class="aura-navigation-menu-list flex items-center gap-1">
        {{ $slot }}
    </ul>
</nav>
