@props([
    'cols' => 3,
    'gap' => 'md',
    'as' => 'div',
])

@php
    $tag = \BlueStarSystem\AuraUI\Support\Html::tag($as);
    // Explicit responsive class strings, not interpolation: Tailwind scans the
    // source for literal class names and generates nothing for `grid-cols-{{ $n }}`.
    $colsClass = match((string) $cols) {
        '1' => 'grid-cols-1',
        '2' => 'grid-cols-1 sm:grid-cols-2',
        '4' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
        '5' => 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-5',
        '6' => 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-6',
        default => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
    };

    $gapClass = match($gap) {
        'none' => 'gap-0',
        'sm' => 'gap-2',
        'lg' => 'gap-6',
        'xl' => 'gap-8',
        default => 'gap-4',
    };
@endphp

<{{ $tag }} {{ $attributes->class(['aura-grid grid', $colsClass, $gapClass]) }}>
    {{ $slot }}
</{{ $tag }}>
