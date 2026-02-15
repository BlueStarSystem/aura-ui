@props([
    'items' => [],
    'separator' => 'chevron',
])

@php
    $separatorMap = [
        'chevron' => '›',
        'slash' => '/',
        'dot' => '·',
    ];
    $sep = $separatorMap[$separator] ?? '›';
@endphp

<nav class="aura-breadcrumbs" aria-label="Breadcrumbs" {{ $attributes }}>
    <ol class="aura-breadcrumbs-list">
        @foreach($items as $index => $item)
            @if($index > 0)
                <li class="aura-breadcrumbs-separator" aria-hidden="true">{{ $sep }}</li>
            @endif
            <li class="aura-breadcrumbs-item {{ $loop->last ? 'aura-breadcrumbs-current' : '' }}">
                @if($loop->last)
                    <span aria-current="page">
                        @if(!empty($item['icon']))
                            <x-aura::icon :name="$item['icon']" size="sm" />
                        @endif
                        {{ $item['label'] }}
                    </span>
                @else
                    <a href="{{ $item['href'] ?? '#' }}" class="aura-breadcrumbs-link">
                        @if(!empty($item['icon']))
                            <x-aura::icon :name="$item['icon']" size="sm" />
                        @endif
                        {{ $item['label'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
