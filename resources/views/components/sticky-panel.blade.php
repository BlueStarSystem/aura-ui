@props([
    'offset' => '1rem',
    'position' => 'top',
    'as' => 'div',
])

@php
    /**
     * A panel that stays put while the page scrolls past it — a table of
     * contents, a summary, a filter column.
     *
     * position:sticky only works if no ancestor clips or scrolls it, which is
     * the usual reason it silently does nothing; the docs say so rather than
     * leaving it to be rediscovered.
     */
    $tag = in_array($as, ['div', 'aside', 'nav', 'section'], true) ? $as : 'div';

    $positionClass = $position === 'bottom' ? 'aura-sticky-bottom' : 'aura-sticky-top';
    $edge = $position === 'bottom' ? 'bottom' : 'top';
@endphp

<{{ $tag }}
    {{ $attributes->class(['aura-sticky-panel sticky z-aura-sticky', $positionClass]) }}
    {{-- cssValue sanitises the VALUE; the property name is ours, so it never
         comes from the caller. --}}
    style="{{ $edge }}: {{ \BlueStarSystem\AuraUI\Support\Html::cssValue($offset) ?? '1rem' }}"
>
    {{ $slot }}
</{{ $tag }}>
