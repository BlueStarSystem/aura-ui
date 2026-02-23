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

    $padBody = match($padding) {
        'none' => 'p-0',
        'sm' => 'px-4 py-3',
        'lg' => 'px-8 py-7',
        default => 'px-6 py-5',
    };

    $padHeader = match($padding) {
        'none' => 'px-0 pt-0 pb-0',
        'sm' => 'px-4 pt-3 pb-2',
        'lg' => 'px-8 pt-7 pb-5',
        default => 'px-6 pt-5 pb-4',
    };

    $padFooter = match($padding) {
        'none' => 'px-0 py-0',
        'sm' => 'px-4 py-2.5',
        'lg' => 'px-8 py-5',
        default => 'px-6 py-4',
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
        <div class="aura-card-header {{ $padHeader }} border-b border-aura-surface-200">
            {{ $header }}
        </div>
    @endif

    <div class="aura-card-body {{ $padBody }}">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="aura-card-footer {{ $padFooter }} border-t border-aura-surface-200 bg-aura-surface-50 flex items-center justify-end gap-2">
            {{ $footer }}
        </div>
    @endif
</div>
