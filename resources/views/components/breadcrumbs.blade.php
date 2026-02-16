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

<nav class="aura-breadcrumbs py-2" aria-label="Breadcrumbs" {{ $attributes }}>
    <ol class="aura-breadcrumbs-list flex items-center flex-wrap gap-0 list-none m-0 p-0">
        @foreach($items as $index => $item)
            @if($index > 0)
                <li class="aura-breadcrumbs-separator text-aura-surface-400 mx-2 text-sm select-none list-none" aria-hidden="true">{{ $sep }}</li>
            @endif
            <li class="aura-breadcrumbs-item flex items-center gap-1.5 text-sm {{ $loop->last ? 'aura-breadcrumbs-current text-aura-surface-900 dark:text-aura-surface-100 font-medium' : '' }}">
                @if($loop->last)
                    <span aria-current="page" class="flex items-center gap-1">
                        @if(!empty($item['icon']))
                            <x-aura::icon :name="$item['icon']" size="sm" />
                        @endif
                        {{ $item['label'] }}
                    </span>
                @else
                    <a href="{{ $item['href'] ?? '#' }}" class="aura-breadcrumbs-link text-aura-surface-500 dark:text-aura-surface-400 no-underline aura-transition-fast hover:text-aura-primary-500 dark:hover:text-aura-primary-400 flex items-center gap-1">
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
