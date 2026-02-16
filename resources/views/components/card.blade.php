@props([
    'padding' => 'md',
    'shadow' => 'md',
    'hover' => false,
    'bordered' => true,
    'glass' => false,
])

@php
    $shadowClass = match($shadow) {
        'none' => '',
        'sm' => 'shadow-aura-sm',
        'lg' => 'shadow-aura-lg',
        default => 'shadow-aura-md',
    };

    $classes = [
        'aura-card',
        "aura-card-shadow-{$shadow}",
        "aura-card-padding-{$padding}",
        'bg-aura-surface-0 rounded-aura-lg overflow-visible aura-transition-slow',
        $shadowClass,
    ];
    if ($hover) $classes[] = 'aura-card-hover hover:shadow-aura-xl hover:-translate-y-0.5 hover:border-aura-surface-300';
    if ($bordered) $classes[] = 'aura-card-bordered border border-aura-surface-200';
    if ($glass) $classes[] = 'aura-glass';
@endphp

<div {{ $attributes->class($classes) }}>
    @if(isset($header))
        <div class="aura-card-header px-6 pt-5 pb-4 border-b border-aura-surface-200">
            {{ $header }}
        </div>
    @endif

    <div class="aura-card-body px-6 py-5">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="aura-card-footer px-6 py-4 border-t border-aura-surface-200 bg-aura-surface-50 flex items-center justify-end gap-2">
            {{ $footer }}
        </div>
    @endif
</div>
