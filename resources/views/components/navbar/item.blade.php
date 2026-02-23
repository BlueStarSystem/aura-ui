@props([
    'href' => '#',
    'active' => false,
])

<a
    href="{{ $href }}"
    {{ $attributes->class([
        'aura-navbar-item inline-flex items-center px-3 py-2 text-sm font-medium rounded-aura-md no-underline aura-transition-fast',
        'text-aura-primary-600 bg-aura-primary-50' => $active,
        'text-aura-surface-600 hover:text-aura-surface-900 hover:bg-aura-surface-100' => !$active,
    ]) }}
    @if($active) aria-current="page" @endif
>
    {{ $slot }}
</a>
