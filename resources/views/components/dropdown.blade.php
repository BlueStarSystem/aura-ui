@props([
    'position' => 'bottom-start',
    'width' => 'w-48',
    'glass' => false,
])

@php
    $menuClasses = ['aura-dropdown-menu', 'absolute top-[calc(100%+4px)] left-0 z-aura-dropdown min-w-[200px] p-1.5 bg-aura-surface-0 border border-aura-surface-200 rounded-aura-lg shadow-aura-xl origin-top-left'];
    if ($glass) $menuClasses[] = 'aura-glass';
@endphp

<div class="aura-dropdown relative inline-block" x-data="{ open: false }" {{ $attributes }}>
    <div x-on:click="open = !open" class="aura-dropdown-trigger" x-ref="auraDropdownTrigger" aria-haspopup="menu" :aria-expanded="open">
        {{ $trigger }}
    </div>

    <div
        class="{{ implode(' ', $menuClasses) }}"
        x-show="open"
        role="menu"
        tabindex="-1"
        x-on:click.outside="open = false"
        x-on:keydown.escape.stop="open = false; $nextTick(() => $refs.auraDropdownTrigger?.querySelector('button, a, [tabindex]')?.focus())"
        x-effect="if (open) { $nextTick(() => $el.querySelector('[role=menuitem]')?.focus()) }"
        x-on:keydown.arrow-down.prevent="(() => { const items = [...$el.querySelectorAll('[role=menuitem]')].filter(e => e.offsetParent !== null); if (! items.length) return; const i = items.indexOf(document.activeElement); items[(i + 1) % items.length].focus(); })()"
        x-on:keydown.arrow-up.prevent="(() => { const items = [...$el.querySelectorAll('[role=menuitem]')].filter(e => e.offsetParent !== null); if (! items.length) return; const i = items.indexOf(document.activeElement); items[(i - 1 + items.length) % items.length].focus(); })()"
        x-transition:enter="aura-transition"
        x-transition:enter-start="opacity-0 transform scale-95 -translate-y-1"
        x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
        x-transition:leave="aura-transition-fast"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
    >
        {{ $slot }}
    </div>
</div>
