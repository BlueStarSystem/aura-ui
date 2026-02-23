@props([
    'align' => 'end',
])

@php
    $alignClass = match($align) {
        'start' => 'aura-form-actions-start justify-start',
        'center' => 'aura-form-actions-center justify-center',
        'between' => 'aura-form-actions-between justify-between',
        default => 'aura-form-actions-end justify-end',
    };
@endphp

<div {{ $attributes->class(['aura-form-actions', 'flex items-center gap-2 pt-4', $alignClass]) }}>
    {{ $slot }}
</div>
