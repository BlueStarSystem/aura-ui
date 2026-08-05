@props([
    'axis' => 'both',
    'minHeight' => null,
])

@php
    // Blade maps the kebab attribute `min-height="60vh"` onto $minHeight, so
    // both spellings work from the template author's side.
    $axisClass = match($axis) {
        'horizontal' => 'flex justify-center',
        'vertical' => 'flex items-center',
        default => 'flex items-center justify-center',
    };
@endphp

<div
    {{ $attributes->class(['aura-center', $axisClass]) }}
    @if($minHeight) style="min-height: {{ $minHeight }}" @endif
>
    {{ $slot }}
</div>
