@props([
    'heading' => '',
])

<div class="aura-command-group" {{ $attributes }}>
    @if($heading)
        <div class="aura-command-group-heading px-3 py-1.5 text-[11px] font-semibold uppercase tracking-wider text-aura-surface-400">{{ $heading }}</div>
    @endif
    {{ $slot }}
</div>
