@props([
    'label' => null,
    'orientation' => 'horizontal',
])

@php
    /**
     * Buttons that belong together, joined into one control.
     *
     * The grouping is announced, not only drawn: a set of buttons with a shared
     * purpose is a `group` with a name, so a screen reader says what the row is
     * before reading the buttons in it. Without that it is three unrelated
     * controls that happen to touch.
     *
     * The joining itself is CSS on `.aura-button-group`, which squares off the
     * inner corners and pulls the borders together — done here with classes it
     * would depend on which utilities each child button happened to carry.
     */
    $isVertical = $orientation === 'vertical';

    $layout = $isVertical ? 'aura-button-group-vertical inline-flex flex-col' : 'inline-flex flex-row';
@endphp

<div
    {{ $attributes->class(['aura-button-group', $layout]) }}
    role="group"
    @if($label) aria-label="{{ $label }}" @endif
>
    {{ $slot }}
</div>
