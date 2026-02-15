@props([
    'label' => '',
    'href' => '#',
    'active' => false,
])

<a
    href="{{ $href }}"
    class="aura-sidebar-subitem {{ $active ? 'aura-sidebar-subitem-active' : '' }}"
    {{ $attributes }}
>
    {{ $label }}
</a>
