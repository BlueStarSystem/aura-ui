@props([
    'title' => null,
])

@php $columnId = 'aura-footer-column-'.\Illuminate\Support\Str::random(8); @endphp

{{-- A list of links inside a <nav> named by its own heading, so a screen
     reader announces "Product, navigation, 4 items" rather than reading four
     loose links with nothing to group them. --}}
<nav {{ $attributes->class(['aura-footer-column']) }} @if($title) aria-labelledby="{{ $columnId }}" @endif>
    @if($title)
        <h2 id="{{ $columnId }}" class="aura-footer-column-title text-sm font-semibold text-aura-surface-900">{{ $title }}</h2>
    @endif

    <ul class="aura-footer-column-links mt-3 space-y-2">
        {{ $slot }}
    </ul>
</nav>
