@props([
    'colSpan' => 1,
    'rowSpan' => 1,
    'href' => null,
    'as' => 'div',
])

@php
    // Written out for the same reason as the grid: an interpolated
    // `col-span-{$n}` is a class Tailwind never sees whole, so no rule is
    // generated and the cell quietly takes one column.
    $colClass = match ((int) $colSpan) {
        2 => 'sm:col-span-2',
        3 => 'sm:col-span-2 lg:col-span-3',
        4 => 'sm:col-span-2 lg:col-span-4',
        default => '',
    };

    $rowClass = match ((int) $rowSpan) {
        2 => 'row-span-2',
        3 => 'row-span-3',
        default => '',
    };

    $tag = $href ? 'a' : (in_array($as, ['div', 'article', 'li'], true) ? $as : 'div');
@endphp

<{{ $tag }}
    {{ $attributes->class([
        'aura-bento-cell relative flex flex-col overflow-hidden rounded-aura-lg border border-aura-surface-200 bg-aura-surface-0 p-5',
        $colClass,
        $rowClass,
        $href ? 'aura-transition-fast hover:border-aura-primary-200 hover:shadow-aura-md' : '',
    ]) }}
    @if($href) href="{{ \BlueStarSystem\AuraUI\Support\Html::url($href) }}" @endif
>
    {{ $slot }}
</{{ $tag }}>
