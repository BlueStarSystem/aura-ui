@props([
    'open' => false,
])

<div x-data="{ open: {{ $open ? 'true' : 'false' }} }"
     {{ $attributes->class(['aura-collapsible']) }}>

    @if(isset($trigger))
        <div x-on:click="open = !open" class="aura-collapsible-trigger cursor-pointer">
            {{ $trigger }}
        </div>
    @endif

    <div x-show="open"
         x-transition:enter="aura-transition"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="aura-transition-fast"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak
         class="aura-collapsible-content">
        {{ $slot }}
    </div>
</div>
