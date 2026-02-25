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

<td {{ $attributes->class(['aura-table-cell', $alignClass, $padClass]) }}>
    {{ $slot }}
</td>
