@props([
    'multiple' => false,
    'bordered' => true,
])

@php
    $classes = ['aura-accordion', 'flex flex-col'];
    if ($bordered) $classes[] = 'aura-accordion-bordered border border-aura-surface-200 rounded-aura-lg divide-y divide-aura-surface-200 overflow-hidden';
@endphp

<div
    class="{{ implode(' ', $classes) }}"
    x-data="{ openItems: [], multiple: {{ $multiple ? 'true' : 'false' }}, toggle(name) { if (this.openItems.includes(name)) { this.openItems = this.openItems.filter(i => i !== name); } else { if (!this.multiple) this.openItems = []; this.openItems.push(name); } } }"
    {{ $attributes }}
>
    {{ $slot }}
</div>
