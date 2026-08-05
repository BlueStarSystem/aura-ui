@props([
    'ratio' => '16/9',
])

@php
    // Falls back rather than emitting whatever arrived: the value lands inside
    // a style attribute, where a semicolon would start a second declaration.
    $safeRatio = \BlueStarSystem\AuraUI\Support\Html::cssValue($ratio) ?? '16/9';
@endphp

{{--
    Reserves the right height before the content loads, so the page does not
    jump when an image or an iframe arrives. Any CSS aspect-ratio value works.
--}}
<div
    {{ $attributes->class(['aura-aspect-ratio relative w-full overflow-hidden']) }}
    style="aspect-ratio: {{ $safeRatio }}"
>
    {{ $slot }}
</div>
