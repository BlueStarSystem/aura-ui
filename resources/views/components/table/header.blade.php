@props([
    'align' => 'left',
])

@php
    $alignClass = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };

    $padClass = 'px-4 py-3';
@endphp

<th {{ $attributes->class(['aura-table-header font-semibold', $alignClass, $padClass]) }}>
    {{ $slot }}
</th>
