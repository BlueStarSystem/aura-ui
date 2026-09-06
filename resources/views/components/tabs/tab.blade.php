@props([
    'name' => '',
])

<div
   
    role="tabpanel"
    x-show="activeTab === {{ Js::from($name) }}"
    x-cloak
    {{ $attributes->class(['aura-tabs-panel']) }}
>
    {{ $slot }}
</div>
