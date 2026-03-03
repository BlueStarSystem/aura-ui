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
     {{ $attributes->class(['aura-swap inline-grid cursor-pointer place-items-center [&>*]:col-start-1 [&>*]:row-start-1']) }}
     role="switch"
     :aria-checked="swapped">

    @if(isset($on) && isset($off))
        @if($effect === 'rotate')
            <span class="aura-swap-on" style="transition-property:opacity,rotate;transition-duration:500ms;transition-timing-function:cubic-bezier(0.16,1,0.3,1)" :class="swapped ? 'rotate-0 opacity-100' : 'rotate-180 opacity-0 pointer-events-none'">{{ $on }}</span>
            <span class="aura-swap-off" style="transition-property:opacity,rotate;transition-duration:500ms;transition-timing-function:cubic-bezier(0.16,1,0.3,1)" :class="swapped ? '-rotate-180 opacity-0 pointer-events-none' : 'rotate-0 opacity-100'">{{ $off }}</span>
        @elseif($effect === 'flip')
            <span class="aura-swap-on" style="transition-property:opacity,scale;transition-duration:400ms;transition-timing-function:cubic-bezier(0.16,1,0.3,1);backface-visibility:hidden" :class="swapped ? 'scale-100 opacity-100' : 'scale-0 opacity-0 pointer-events-none'">{{ $on }}</span>
            <span class="aura-swap-off" style="transition-property:opacity,scale;transition-duration:400ms;transition-timing-function:cubic-bezier(0.16,1,0.3,1);backface-visibility:hidden" :class="swapped ? 'scale-0 opacity-0 pointer-events-none' : 'scale-100 opacity-100'">{{ $off }}</span>
        @else
            <span class="aura-swap-on" style="transition-property:opacity;transition-duration:200ms;transition-timing-function:ease" :class="swapped ? 'opacity-100' : 'opacity-0 pointer-events-none'">{{ $on }}</span>
            <span class="aura-swap-off" style="transition-property:opacity;transition-duration:200ms;transition-timing-function:ease" :class="swapped ? 'opacity-0 pointer-events-none' : 'opacity-100'">{{ $off }}</span>
        @endif
    @endif
</div>
