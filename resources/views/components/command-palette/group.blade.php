@props([
    'heading' => '',
])

<div {{ $attributes->class(['aura-command-group']) }}>
    @if($heading)
        <div class="aura-command-group-heading px-3 py-1.5 text-[11px] font-semibold uppercase tracking-wider text-aura-surface-400">{{ $heading }}</div>
    @endif
    {{ $slot }}
</div>
