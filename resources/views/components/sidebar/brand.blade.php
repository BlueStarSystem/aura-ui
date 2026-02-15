@props([
    'href' => '/',
])

<a href="{{ $href }}" class="aura-sidebar-brand" {{ $attributes }}>
    {{ $slot }}
</a>
