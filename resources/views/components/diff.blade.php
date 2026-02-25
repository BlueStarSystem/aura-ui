@props([
    'layout' => 'side-by-side',
])

@php
    $layoutClass = match($layout) {
        'stacked' => 'flex-col',
        default => 'flex-col md:flex-row',
    };
@endphp

<div {{ $attributes->class(['aura-diff flex gap-4 rounded-aura-lg border border-aura-surface-200 p-4', $layoutClass]) }}>
    @if(isset($before))
        <div class="aura-diff-before flex-1 min-w-0">
            <div class="mb-2 text-xs font-semibold uppercase tracking-wider text-aura-danger-500">Before</div>
            <div class="rounded-aura border border-aura-surface-200 bg-aura-danger-50/30 p-3">
                {{ $before }}
            </div>
        </div>
    @endif
    @if(isset($after))
        <div class="aura-diff-after flex-1 min-w-0">
            <div class="mb-2 text-xs font-semibold uppercase tracking-wider text-aura-success-500">After</div>
            <div class="rounded-aura border border-aura-surface-200 bg-aura-success-50/30 p-3">
                {{ $after }}
            </div>
        </div>
    @endif
</div>
