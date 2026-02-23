@props([
    'variant' => 'default',
    'defaultTab' => null,
    'tabs' => [],
])

@php
    $variantClass = match($variant) {
        'pills' => 'aura-tabs-pills',
        'vertical' => 'aura-tabs-vertical flex flex-row gap-4',
        'bordered' => 'aura-tabs-bordered',
        default => 'aura-tabs-default',
    };
    $defaultActive = $defaultTab ?? (count($tabs) > 0 ? ($tabs[0]['name'] ?? '') : '');
@endphp

<div
    class="aura-tabs {{ $variantClass }}"
    x-data="{ activeTab: '{{ $defaultActive }}' }"
    {{ $attributes }}
>
    <div class="aura-tabs-list flex {{ $variant === 'vertical' ? 'flex-col border-r border-aura-surface-200 pr-4' : 'border-b border-aura-surface-200' }} gap-0" role="tablist">
        @foreach($tabs as $tab)
            <button
                type="button"
                role="tab"
                class="aura-tabs-trigger inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-aura-surface-500 border-b-2 border-transparent cursor-pointer bg-transparent aura-transition-fast hover:text-aura-surface-900 hover:border-aura-surface-300 disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap"
                :class="{ 'aura-tabs-active !text-aura-primary-600 !border-aura-primary-500 !font-semibold': activeTab === '{{ $tab['name'] }}' }"
                :aria-selected="activeTab === '{{ $tab['name'] }}' ? 'true' : 'false'"
                @click="activeTab = '{{ $tab['name'] }}'"
                @if(!empty($tab['disabled'])) disabled @endif
            >
                @if(!empty($tab['icon']))
                    <x-aura::icon :name="$tab['icon']" size="sm" />
                @endif
                {{ $tab['label'] ?? $tab['name'] }}
                @if(!empty($tab['badge']))
                    <span class="aura-tabs-badge inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-semibold rounded-aura-full bg-aura-surface-100 text-aura-surface-600">{{ $tab['badge'] }}</span>
                @endif
            </button>
        @endforeach
    </div>

    <div class="aura-tabs-panels flex-1 pt-4">
        {{ $slot }}
    </div>
</div>
