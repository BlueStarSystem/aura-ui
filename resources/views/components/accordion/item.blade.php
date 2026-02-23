@props([
    'title' => '',
    'icon' => null,
    'open' => false,
    'disabled' => false,
    'name' => null,
])

@php
    $itemName = $name ?? 'acc_' . crc32($title);
@endphp

<div
    class="aura-accordion-item"
    @if($open) x-init="openItems.push('{{ $itemName }}')" @endif
    {{ $attributes }}
>
    <button
        type="button"
        class="aura-accordion-trigger flex items-center justify-between w-full px-4 py-3.5 text-sm font-medium text-aura-surface-900 bg-transparent border-none cursor-pointer text-left aura-transition-fast hover:bg-aura-surface-50"
        x-bind:class="{ 'aura-accordion-trigger-open bg-aura-surface-50': openItems.includes('{{ $itemName }}') }"
        @click="toggle('{{ $itemName }}')"
        x-bind:aria-expanded="openItems.includes('{{ $itemName }}') ? 'true' : 'false'"
        @if($disabled) disabled @endif
    >
        <span class="aura-accordion-trigger-text inline-flex items-center gap-2">
            @if($icon)
                <x-aura::icon :name="$icon" size="sm" />
            @endif
            {{ $title }}
        </span>
        <x-aura::icon name="chevron-down" size="sm" class="aura-accordion-chevron shrink-0 text-aura-surface-400 aura-transition-fast" x-bind:class="{ 'aura-accordion-chevron-open': openItems.includes('{{ $itemName }}') }" />
    </button>

    <div
        class="aura-accordion-content"
        x-show="openItems.includes('{{ $itemName }}')"
        x-collapse
        x-cloak
    >
        <div class="aura-accordion-body px-4 py-3 text-sm text-aura-surface-600 leading-relaxed">
            {{ $slot }}
        </div>
    </div>
</div>
