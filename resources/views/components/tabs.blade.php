@props([
    'variant' => 'default',
    'defaultTab' => null,
    'tabs' => [],
])

@php
    $variantClass = match($variant) {
        'pills' => 'aura-tabs-pills',
        'vertical' => 'aura-tabs-vertical',
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
    <div class="aura-tabs-list" role="tablist">
        @foreach($tabs as $tab)
            <button
                type="button"
                role="tab"
                class="aura-tabs-trigger"
                :class="{ 'aura-tabs-active': activeTab === '{{ $tab['name'] }}' }"
                :aria-selected="activeTab === '{{ $tab['name'] }}' ? 'true' : 'false'"
                @click="activeTab = '{{ $tab['name'] }}'"
                @if(!empty($tab['disabled'])) disabled @endif
            >
                @if(!empty($tab['icon']))
                    <x-aura::icon :name="$tab['icon']" size="sm" />
                @endif
                {{ $tab['label'] ?? $tab['name'] }}
                @if(!empty($tab['badge']))
                    <span class="aura-tabs-badge">{{ $tab['badge'] }}</span>
                @endif
            </button>
        @endforeach
    </div>

    <div class="aura-tabs-panels">
        {{ $slot }}
    </div>
</div>
