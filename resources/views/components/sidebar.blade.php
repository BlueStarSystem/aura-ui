@props([
    'collapsible' => true,
    'collapsed' => false,
    'width' => '260px',
    'collapsedWidth' => '64px',
])

<aside
    class="aura-sidebar"
    x-data="{ collapsed: {{ $collapsed ? 'true' : 'false' }}, openGroups: [] }"
    x-bind:class="{ 'aura-sidebar-collapsed': collapsed }"
    x-bind:style="collapsed ? 'width: {{ $collapsedWidth }}' : 'width: {{ $width }}'"
    {{ $attributes }}
>
    {{ $slot }}

    @if($collapsible)
        <button
            type="button"
            class="aura-sidebar-toggle"
            @click="collapsed = !collapsed"
            x-bind:aria-label="collapsed ? 'Expand sidebar' : 'Collapse sidebar'"
        >
            <x-aura::icon name="chevrons-left" size="sm" x-bind:class="{ 'aura-sidebar-toggle-rotated': collapsed }" />
        </button>
    @endif
</aside>
