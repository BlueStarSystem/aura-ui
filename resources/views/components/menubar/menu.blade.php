@props([
    'label' => '',
    'index' => 0,
])

@php
    use Illuminate\Support\Str;

    $menuId = 'aura-menubar-menu-'.Str::random(8);

    /**
     * One menu in the bar. The index is what tells the bar which menu is open,
     * so it has to be passed: two menus that both think they are the first
     * would open together.
     */
@endphp

<div class="aura-menubar-menu relative" x-data="{ index: {{ (int) $index }} }">
    <button
        type="button"
        data-aura-menubar-trigger
        class="aura-menubar-trigger flex h-8 items-center rounded-aura-sm px-3 text-sm font-medium text-aura-surface-800 cursor-pointer hover:bg-aura-surface-100"
        role="menuitem"
        aria-haspopup="true"
        aria-controls="{{ $menuId }}"
        {{-- Only the first trigger starts in the tab order; the bar moves it
             from there as the focus moves. --}}
        tabindex="{{ (int) $index === 0 ? '0' : '-1' }}"
        x-bind:aria-expanded="openIndex === index ? 'true' : 'false'"
        x-bind:class="{ 'bg-aura-surface-100': openIndex === index }"
        x-on:click="toggle(index)"
        x-on:keydown.arrow-down.prevent="openIndex = index; $nextTick(() => $refs.items?.querySelector('[role=menuitem]')?.focus())"
        x-on:keydown.enter.prevent="toggle(index)"
        x-on:keydown.space.prevent="toggle(index)"
    >{{ $label }}</button>

    <div
        id="{{ $menuId }}"
        x-ref="items"
        role="menu"
        aria-label="{{ $label }}"
        class="aura-menubar-items absolute left-0 top-full z-aura-dropdown mt-1 min-w-[200px] rounded-aura-lg border border-aura-surface-200 bg-aura-surface-0 p-1 shadow-aura-xl"
        x-show="openIndex === index"
        x-cloak
        {{-- Up and Down walk the items; the bar's own Left/Right keep working
             because this listens on itself, not on the window. --}}
        x-on:keydown.arrow-down.prevent="$focus.wrap().next()"
        x-on:keydown.arrow-up.prevent="$focus.wrap().previous()"
    >
        {{ $slot }}
    </div>
</div>
