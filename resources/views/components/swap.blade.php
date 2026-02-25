@props([
    'active' => false,
    'rotate' => false,
    'flip' => false,
])

@php
    $effect = $rotate ? 'rotate' : ($flip ? 'flip' : 'fade');
@endphp

<div x-data="{ swapped: {{ $active ? 'true' : 'false' }} }"
     x-on:click="swapped = !swapped"
     {{ $attributes->class(['aura-swap relative inline-flex cursor-pointer items-center justify-center']) }}
     role="switch"
     :aria-checked="swapped">

    @if(isset($on) && isset($off))
        @if($effect === 'rotate')
            <span class="aura-swap-on aura-transition-slow" style="transition-property:color,background-color,border-color,box-shadow,transform,opacity,rotate,scale,translate;transition-duration:250ms;transition-timing-function:cubic-bezier(0.16,1,0.3,1)" :class="swapped ? 'rotate-0 opacity-100' : 'rotate-180 opacity-0 absolute'">{{ $on }}</span>
            <span class="aura-swap-off aura-transition-slow" style="transition-property:color,background-color,border-color,box-shadow,transform,opacity,rotate,scale,translate;transition-duration:250ms;transition-timing-function:cubic-bezier(0.16,1,0.3,1)" :class="swapped ? '-rotate-180 opacity-0 absolute' : 'rotate-0 opacity-100'">{{ $off }}</span>
        @elseif($effect === 'flip')
            <span class="aura-swap-on aura-transition" style="transition-property:color,background-color,border-color,box-shadow,transform,opacity,rotate,scale,translate;transition-duration:150ms;transition-timing-function:cubic-bezier(0.16,1,0.3,1)" :class="swapped ? 'scale-100 opacity-100' : 'scale-0 opacity-0 absolute'">{{ $on }}</span>
            <span class="aura-swap-off aura-transition" style="transition-property:color,background-color,border-color,box-shadow,transform,opacity,rotate,scale,translate;transition-duration:150ms;transition-timing-function:cubic-bezier(0.16,1,0.3,1)" :class="swapped ? 'scale-0 opacity-0 absolute' : 'scale-100 opacity-100'">{{ $off }}</span>
        @else
            <span class="aura-swap-on aura-transition" :class="swapped ? 'opacity-100' : 'opacity-0 absolute'">{{ $on }}</span>
            <span class="aura-swap-off aura-transition" :class="swapped ? 'opacity-0 absolute' : 'opacity-100'">{{ $off }}</span>
        @endif
    @endif
</div>
