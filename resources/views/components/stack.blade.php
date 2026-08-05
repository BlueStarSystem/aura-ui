@props([
    'gap' => 'md',
    'align' => null,
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
        'center' => 'items-center',
        'end' => 'items-end',
        'stretch' => 'items-stretch',
        default => '',
    };
@endphp

<{{ $tag }} {{ $attributes->class(['aura-stack flex flex-col', $gapClass, $alignClass]) }}>
    {{ $slot }}
</{{ $tag }}>
