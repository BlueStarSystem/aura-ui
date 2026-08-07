@props([
    'label' => null,
    'fixed' => true,
])

{{-- The navigation bar phones put within thumb reach. A real <nav> with a
     name, because a page usually has more than one and "navigation" three
     times over tells a screen-reader user nothing about which is which. --}}
<nav
    {{ $attributes->class([
        'aura-bottom-nav flex items-stretch justify-around border-t border-aura-surface-200 bg-aura-surface-0',
        $fixed ? 'fixed inset-x-0 bottom-0 z-aura-sticky' : '',
    ]) }}
    aria-label="{{ $label ?? __('aura-ui::messages.primary_navigation') }}"
    {{-- Keeps the last item clear of the home indicator on iOS. --}}
    style="padding-bottom: env(safe-area-inset-bottom, 0px)"
>
    {{ $slot }}
</nav>
