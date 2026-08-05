@props([
    'as' => 'span',
    'focusable' => false,
])

{{--
    Content for screen readers that must not appear on screen. The clip-rect
    technique keeps the text in the accessibility tree, unlike `display:none`
    or `visibility:hidden`, which remove it entirely.

    `focusable` makes it appear when it receives keyboard focus — that is how
    a skip link stays invisible until someone tabs to it.
--}}
<{{ $as }} {{ $attributes->class(['aura-visually-hidden', $focusable ? 'aura-visually-hidden-focusable' : '']) }}>
    {{ $slot }}
</{{ $as }}>
