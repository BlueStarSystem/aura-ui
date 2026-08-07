@props([
    'title' => '',
    'href' => null,
    'active' => false,
])

@php
    $itemId = 'aura-nav-item-'.\Illuminate\Support\Str::random(8);
    $hasPanel = ! $href;
@endphp

<li class="aura-navigation-menu-item relative">
    @if($hasPanel)
        {{-- A disclosure: a button that says whether its panel is open and
             which panel it controls. --}}
        <button
            type="button"
            x-ref="trigger-{{ $itemId }}"
            {{ $attributes->class([
                'aura-navigation-menu-trigger inline-flex items-center gap-1 rounded-aura-md px-3 py-2 text-sm font-medium cursor-pointer aura-transition-fast',
                $active ? 'text-aura-primary-600 dark:text-aura-primary-400' : 'text-aura-surface-700 hover:bg-aura-surface-100 hover:text-aura-surface-900',
            ]) }}
            aria-controls="{{ $itemId }}-panel"
            x-bind:aria-expanded="open === {{ Js::from($itemId) }} ? 'true' : 'false'"
            x-on:click="toggle({{ Js::from($itemId) }})"
            @if($active) aria-current="page" @endif
        >
            {{ $title }}
            <x-aura::icon name="chevron-down" size="xs" aria-hidden="true" x-bind:class="open === {{ Js::from($itemId) }} ? 'rotate-180 aura-transition-fast' : 'aura-transition-fast'" />
        </button>

        <div
            id="{{ $itemId }}-panel"
            class="aura-navigation-menu-panel absolute left-0 top-full z-aura-dropdown mt-1 min-w-[16rem] rounded-aura-lg border border-aura-surface-200 bg-aura-surface-0 p-3 shadow-aura-lg"
            x-show="open === {{ Js::from($itemId) }}"
            x-transition:enter="aura-transition"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-cloak
        >
            {{ $slot }}
        </div>
    @else
        <a
            {{ $attributes->class([
                'aura-navigation-menu-link inline-flex items-center rounded-aura-md px-3 py-2 text-sm font-medium aura-transition-fast',
                $active ? 'text-aura-primary-600 dark:text-aura-primary-400' : 'text-aura-surface-700 hover:bg-aura-surface-100 hover:text-aura-surface-900',
            ]) }}
            href="{{ \BlueStarSystem\AuraUI\Support\Html::url($href) }}"
            @if($active) aria-current="page" @endif
        >
            {{ $title }}{{ $slot }}
        </a>
    @endif
</li>
