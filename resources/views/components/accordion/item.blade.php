@props([
    'title' => '',
    'icon' => null,
    'defaultOpen' => false,
    'disabled' => false,
    'name' => null,
])

@php
    $itemName = $name ?? 'acc_' . crc32($title);
@endphp

<div
    class="aura-accordion-item"
    @if($defaultOpen) x-init="openItems.push('{{ $itemName }}')" @endif
    {{ $attributes }}
>
    <button
        type="button"
        class="aura-accordion-trigger"
        x-bind:class="{ 'aura-accordion-trigger-open': openItems.includes('{{ $itemName }}') }"
        @click="toggle('{{ $itemName }}')"
        x-bind:aria-expanded="openItems.includes('{{ $itemName }}') ? 'true' : 'false'"
        @if($disabled) disabled @endif
    >
        <span class="aura-accordion-trigger-text">
            @if($icon)
                <x-aura::icon :name="$icon" size="sm" />
            @endif
            {{ $title }}
        </span>
        <x-aura::icon name="chevron-down" size="sm" class="aura-accordion-chevron" x-bind:class="{ 'aura-accordion-chevron-open': openItems.includes('{{ $itemName }}') }" />
    </button>

    <div
        class="aura-accordion-content"
        x-show="openItems.includes('{{ $itemName }}')"
        x-collapse
        x-cloak
    >
        <div class="aura-accordion-body">
            {{ $slot }}
        </div>
    </div>
</div>
