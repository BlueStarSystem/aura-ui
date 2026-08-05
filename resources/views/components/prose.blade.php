@props([
    'size' => 'base',
])

@php
    $sizeClass = match($size) {
        'sm' => 'aura-prose-sm text-sm',
        'lg' => 'aura-prose-lg text-lg',
        default => 'text-base',
    };
@endphp

{{--
    Long-form content that you do not control the markup of — a rendered
    Markdown post, a stored description. The rules live in aura.css so the
    typography follows the theme instead of a plugin's own scale.
--}}
<div {{ $attributes->class(['aura-prose max-w-none text-aura-surface-700', $sizeClass]) }}>
    {{ $slot }}
</div>
