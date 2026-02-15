@props([
    'rounded' => 'md',
])

<div {{ $attributes->class(['aura-skeleton', "aura-skeleton-rounded-{$rounded}"]) }} aria-hidden="true"></div>
