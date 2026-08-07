@props([
    'columns' => 3,
    'gap' => 'md',
    'as' => 'div',
])

@php
    /**
     * The asymmetric grid behind a feature section: cells claim two columns or
     * two rows and the layout stays even.
     *
     * Both maps are written out. Tailwind reads source files as text and
     * generates nothing for a class it never sees whole, so `grid-cols-{$n}`
     * would produce no rule at all — the failure is silent and the grid simply
     * collapses to one column.
     */
    $columnClass = match ((int) $columns) {
        1 => 'grid-cols-1',
        2 => 'grid-cols-1 sm:grid-cols-2',
        4 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
        default => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
    };

    $gapClass = match ($gap) {
        'sm' => 'gap-2',
        'lg' => 'gap-6',
        default => 'gap-4',
    };

    $tag = in_array($as, ['div', 'section', 'ul'], true) ? $as : 'div';
@endphp

<{{ $tag }} {{ $attributes->class(['aura-bento-grid grid auto-rows-[minmax(8rem,auto)]', $columnClass, $gapClass]) }}>
    {{ $slot }}
</{{ $tag }}>
