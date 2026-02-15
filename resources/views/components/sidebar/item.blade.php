@props([
    'icon' => null,
    'label' => '',
    'href' => null,
    'active' => false,
    'badge' => null,
    'badgeVariant' => 'primary',
    'expandable' => false,
    'name' => null,
])

@php
    $tag = $href ? 'a' : 'button';
    $classes = ['aura-sidebar-item'];
    if ($active) $classes[] = 'aura-sidebar-item-active';
    $itemName = $name ?? md5($label);
@endphp

<div class="aura-sidebar-item-wrapper">
    <{{ $tag }}
        @if($href) href="{{ $href }}" @else type="button" @endif
        class="{{ implode(' ', $classes) }}"
        @if($expandable)
            @click="openGroups.includes('{{ $itemName }}') ? openGroups = openGroups.filter(g => g !== '{{ $itemName }}') : openGroups.push('{{ $itemName }}')"
        @endif
        {{ $attributes }}
    >
        @if($icon)
            <span class="aura-sidebar-item-icon">
                <x-aura::icon :name="$icon" size="sm" />
            </span>
        @endif
        <span class="aura-sidebar-item-label" x-show="!collapsed" x-cloak>{{ $label }}</span>
        @if($badge)
            <span class="aura-badge aura-badge-{{ $badgeVariant }} aura-badge-sm" x-show="!collapsed" x-cloak>{{ $badge }}</span>
        @endif
        @if($expandable)
            <x-aura::icon name="chevron-down" size="xs" class="aura-sidebar-item-arrow" x-show="!collapsed" x-bind:class="{ 'aura-sidebar-item-arrow-open': openGroups.includes('{{ $itemName }}') }" />
        @endif
    </{{ $tag }}>

    @if($expandable)
        <div class="aura-sidebar-subitems" x-show="openGroups.includes('{{ $itemName }}') && !collapsed" x-collapse x-cloak>
            {{ $slot }}
        </div>
    @endif
</div>
