@props([
    'orientation' => 'horizontal',
    'label' => null,
    'variant' => 'default',
])

@php
    $variantClass = match($variant) {
        'dashed' => 'border-dashed',
        'dotted' => 'border-dotted',
        default => 'border-solid',
    };

    $isVertical = $orientation === 'vertical';
@endphp

@if($label)
    <div {{ $attributes->class(['aura-separator aura-separator-labeled flex items-center gap-3', $isVertical ? 'flex-col' : '']) }}>
        <div class="aura-separator-line flex-1 {{ $isVertical ? 'w-px border-l h-full' : 'h-px border-t w-full' }} border-aura-surface-200 {{ $variantClass }}"></div>
        <span class="aura-separator-label text-xs font-medium text-aura-surface-400 uppercase tracking-wider shrink-0">{{ $label }}</span>
        <div class="aura-separator-line flex-1 {{ $isVertical ? 'w-px border-l h-full' : 'h-px border-t w-full' }} border-aura-surface-200 {{ $variantClass }}"></div>
    </div>
@else
    <div {{ $attributes->class([
        'aura-separator',
        $isVertical ? 'w-px border-l h-full' : 'h-px border-t w-full',
        'border-aura-surface-200',
        $variantClass,
    ]) }}></div>
@endif
