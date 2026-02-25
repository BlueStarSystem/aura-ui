@props([
    'striped' => false,
    'hoverable' => false,
    'bordered' => false,
    'compact' => false,
])

@php
    $classes = [
        'aura-table',
        'w-full text-left text-sm text-aura-surface-600',
    ];

    if ($striped) $classes[] = 'aura-table-striped';
    if ($hoverable) $classes[] = 'aura-table-hoverable';
    if ($bordered) $classes[] = 'aura-table-bordered';
    if ($compact) $classes[] = 'aura-table-compact';
@endphp

<div class="aura-table-wrapper overflow-x-auto rounded-aura-lg border border-aura-surface-200">
    <table {{ $attributes->class($classes) }}>
        {{ $slot }}
    </table>
</div>
