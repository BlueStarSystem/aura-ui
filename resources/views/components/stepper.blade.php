@props([
    'active' => 1,
    'orientation' => 'horizontal',
    'size' => 'md',
    'connectors' => true,
])

@php
    $orientationClass = 'aura-stepper--' . $orientation;
    $sizeClass = 'aura-stepper--' . $size;
@endphp

<div
    {{ $attributes->class([
        'aura-stepper',
        $orientationClass,
        $sizeClass,
        'aura-stepper--no-connectors' => ! $connectors,
    ]) }}
    x-data="{ active: {{ $active }}, total: 0 }"
    x-init="total = $el.querySelectorAll('.aura-stepper__step').length"
>
    {{ $slot }}
</div>
