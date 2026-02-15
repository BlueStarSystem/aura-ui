@props([
    'align' => 'end',
])

@php
    $alignClass = match($align) {
        'start' => 'aura-form-actions-start',
        'center' => 'aura-form-actions-center',
        'between' => 'aura-form-actions-between',
        default => 'aura-form-actions-end',
    };
@endphp

<div {{ $attributes->class(['aura-form-actions', $alignClass]) }}>
    {{ $slot }}
</div>
