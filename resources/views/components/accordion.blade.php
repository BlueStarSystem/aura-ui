@props([
    'multiple' => false,
    'bordered' => true,
])

@php
    $classes = ['aura-accordion'];
    if ($bordered) $classes[] = 'aura-accordion-bordered';
@endphp

<div
    class="{{ implode(' ', $classes) }}"
    x-data="{ openItems: [], multiple: {{ $multiple ? 'true' : 'false' }}, toggle(name) { if (this.openItems.includes(name)) { this.openItems = this.openItems.filter(i => i !== name); } else { if (!this.multiple) this.openItems = []; this.openItems.push(name); } } }"
    {{ $attributes }}
>
    {{ $slot }}
</div>
