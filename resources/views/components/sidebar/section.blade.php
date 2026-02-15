@props([
    'label' => '',
])

<div class="aura-sidebar-section" {{ $attributes }}>
    @if($label)
        <div class="aura-sidebar-section-label" x-show="!collapsed" x-cloak>{{ $label }}</div>
    @endif
    <nav class="aura-sidebar-section-items">
        {{ $slot }}
    </nav>
</div>
