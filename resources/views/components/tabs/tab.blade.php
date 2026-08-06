@props([
    'name' => '',
])

<div
    class="aura-tabs-panel"
    role="tabpanel"
    x-show="activeTab === {{ Js::from($name) }}"
    x-cloak
    {{ $attributes }}
>
    {{ $slot }}
</div>
