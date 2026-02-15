@props([
    'name' => '',
])

<div
    class="aura-tabs-panel"
    role="tabpanel"
    x-show="activeTab === '{{ $name }}'"
    x-cloak
    {{ $attributes }}
>
    {{ $slot }}
</div>
