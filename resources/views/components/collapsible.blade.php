@props([
    'open' => false,
])

@php $collapsibleId = 'aura-collapsible-'.\Illuminate\Support\Str::random(8); @endphp

<div x-data="{ open: {{ $open ? 'true' : 'false' }} }"
     {{ $attributes->class(['aura-collapsible']) }}>

    @if(isset($trigger))
        {{-- A button, not a div. A div takes no focus and Enter and Space do
             nothing on it, so this could only ever be opened with a pointer.
             The state also needs announcing: aria-expanded is what tells a
             screen reader whether the section below is showing. --}}
        <button
            type="button"
            x-on:click="open = !open"
            x-bind:aria-expanded="open ? 'true' : 'false'"
            aria-controls="{{ $collapsibleId }}"
            class="aura-collapsible-trigger cursor-pointer w-full text-left"
        >
            {{ $trigger }}
        </button>
    @endif

    <div x-show="open"
         id="{{ $collapsibleId }}"
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
