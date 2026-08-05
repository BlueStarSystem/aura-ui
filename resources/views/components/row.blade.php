@props([
    'gap' => 'md',
    'align' => 'center',
    'justify' => null,
    'wrap' => true,
    'as' => 'div',
])

@php
    $tag = \BlueStarSystem\AuraUI\Support\Html::tag($as);
    $gapClass = match($gap) {
        'none' => 'gap-0',
        'xs' => 'gap-1',
        'sm' => 'gap-2',
        'lg' => 'gap-6',
        'xl' => 'gap-8',
        default => 'gap-4',
    };

    $alignClass = match($align) {
        'start' => 'items-start',
        'end' => 'items-end',
        'baseline' => 'items-baseline',
        'stretch' => 'items-stretch',
        default => 'items-center',
    };

    $justifyClass = match($justify) {
        'start' => 'justify-start',
        'center' => 'justify-center',
        'end' => 'justify-end',
        'between' => 'justify-between',
        'around' => 'justify-around',
        default => '',
    };
@endphp

<{{ $tag }} {{ $attributes->class(['aura-row flex', $wrap ? 'flex-wrap' : 'flex-nowrap', $gapClass, $alignClass, $justifyClass]) }}>
    {{ $slot }}
</{{ $tag }}>
