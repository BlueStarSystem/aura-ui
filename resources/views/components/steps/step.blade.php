@props([
    'label' => '',
    'description' => '',
    'icon' => null,
    'step' => 0,
])

@php
    $stepIndex = (int)$step;
@endphp

<div
    class="aura-steps-item"
    x-bind:class="{
        'aura-steps-completed': current > {{ $stepIndex }},
        'aura-steps-active': current === {{ $stepIndex }},
        'aura-steps-pending': current < {{ $stepIndex }}
    }"
    {{ $attributes }}
>
    <div class="aura-steps-indicator">
        <template x-if="current > {{ $stepIndex }}">
            <span class="aura-steps-check">
                <x-aura::icon name="check" size="sm" />
            </span>
        </template>
        <template x-if="current <= {{ $stepIndex }}">
            <span class="aura-steps-number">
                @if($icon)
                    <x-aura::icon :name="$icon" size="sm" />
                @else
                    {{ $stepIndex + 1 }}
                @endif
            </span>
        </template>
    </div>
    @if($label || $description)
        <div class="aura-steps-content">
            @if($label)
                <span class="aura-steps-label">{{ $label }}</span>
            @endif
            @if($description)
                <span class="aura-steps-description">{{ $description }}</span>
            @endif
        </div>
    @endif
</div>
