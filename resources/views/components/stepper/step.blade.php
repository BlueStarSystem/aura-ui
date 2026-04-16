@props([
    'label' => '',
    'icon' => null,
    'description' => null,
])

@php
    static $stepIndex = 0;
    $stepIndex++;
    $currentIndex = $stepIndex;
@endphp

<div
    {{ $attributes->class(['aura-stepper__step']) }}
    x-data="{ index: {{ $currentIndex }} }"
    :class="{
        'aura-stepper__step--completed': active > index,
        'aura-stepper__step--active': active === index,
        'aura-stepper__step--pending': active < index,
    }"
>
    <div class="aura-stepper__indicator">
        <template x-if="active > index">
            <svg class="aura-stepper__check" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd"/>
            </svg>
        </template>
        <template x-if="active <= index">
            @if ($icon)
                <x-aura::icon :name="$icon" class="aura-stepper__icon" />
            @else
                <span class="aura-stepper__number" x-text="index"></span>
            @endif
        </template>
    </div>

    <div class="aura-stepper__content">
        <span class="aura-stepper__label">{{ $label }}</span>
        @if ($description)
            <span class="aura-stepper__description">{{ $description }}</span>
        @endif
    </div>
</div>
