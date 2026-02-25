@props([
    'alternate' => false,
])

<div {{ $attributes->class(['aura-timeline']) }} style="position:relative;">
    {{-- Vertical line --}}
    <div style="position:absolute;left:1.125rem;top:0;bottom:0;width:2px;background:var(--aura-surface-200, #e5e7eb);"></div>
    {{ $slot }}
</div>
