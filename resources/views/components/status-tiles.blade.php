@props([
    'label' => null,
    'columns' => 4,
])

@php
    $tilesId = 'aura-status-tiles-'.\Illuminate\Support\Str::random(8);

    // Written out: an interpolated grid-cols-{$n} is a class Tailwind never
    // sees whole, so no rule is generated and the grid collapses to one column.
    $columnClass = match ((int) $columns) {
        2 => 'grid-cols-2',
        3 => 'grid-cols-2 sm:grid-cols-3',
        6 => 'grid-cols-3 sm:grid-cols-6',
        default => 'grid-cols-2 sm:grid-cols-4',
    };
@endphp

{{-- A list, so the number of services is announced before they are read. --}}
<ul
    {{ $attributes->class(['aura-status-tiles grid gap-3', $columnClass]) }}
    aria-label="{{ $label ?? __('aura-ui::messages.service_status') }}"
    id="{{ $tilesId }}"
>
    {{ $slot }}
</ul>
