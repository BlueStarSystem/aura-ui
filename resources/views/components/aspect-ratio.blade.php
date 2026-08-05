@props([
    'ratio' => '16/9',
])

{{--
    Reserves the right height before the content loads, so the page does not
    jump when an image or an iframe arrives. Any CSS aspect-ratio value works.
--}}
<div
    {{ $attributes->class(['aura-aspect-ratio relative w-full overflow-hidden']) }}
    style="aspect-ratio: {{ $ratio }}"
>
    {{ $slot }}
</div>
