@props([
    'alternate' => false,
])

<div {{ $attributes->class(['aura-timeline relative', $alternate ? 'aura-timeline-alternate' : '']) }}>
    <div class="absolute left-4 top-0 bottom-0 w-px bg-aura-surface-200 {{ $alternate ? 'lg:left-1/2' : '' }}"></div>
    {{ $slot }}
</div>
