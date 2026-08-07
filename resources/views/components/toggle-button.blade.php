@props([
    'pressed' => false,
    'label' => null,
    'pressedLabel' => null,
    'icon' => null,
    'size' => 'md',
    'variant' => 'secondary',
])

@php
    /**
     * A button that stays down — bold, mute, pin, favourite.
     *
     * Not a toggle switch: a switch is on or off as a setting, this performs an
     * action whose state persists. aria-pressed is what tells them apart, and
     * without it a screen reader announces a plain button that appears to do
     * nothing.
     */
    $sizeClass = match ($size) {
        'sm' => 'h-8 min-w-8 px-2 text-xs gap-1',
        'lg' => 'h-11 min-w-11 px-4 text-base gap-2',
        default => 'h-9 min-w-9 px-3 text-sm gap-1.5',
    };

    $variantClass = match ($variant) {
        'ghost' => 'border-transparent bg-transparent hover:bg-aura-surface-100',
        default => 'border-aura-surface-200 bg-aura-surface-0 hover:bg-aura-surface-50',
    };
@endphp

<button
    type="button"
    {{ $attributes->class([
        'aura-toggle-button inline-flex items-center justify-center rounded-aura-md border font-medium text-aura-surface-800 cursor-pointer aura-transition-fast',
        $sizeClass,
        $variantClass,
    ]) }}
    x-data="{ pressed: {{ $pressed ? 'true' : 'false' }} }"
    x-on:click="pressed = !pressed; $dispatch('aura-toggled', { pressed })"
    x-bind:aria-pressed="pressed ? 'true' : 'false'"
    x-bind:class="pressed ? 'aura-toggle-button-pressed !bg-aura-primary-600 !border-aura-primary-600 !text-white' : ''"
    @if($label || $pressedLabel)
        x-bind:aria-label="pressed ? {{ Js::from($pressedLabel ?? $label) }} : {{ Js::from($label ?? $pressedLabel) }}"
    @endif
>
    @if($icon)
        <x-aura::icon :name="$icon" :size="$size === 'lg' ? 'md' : 'sm'" aria-hidden="true" />
    @endif

    {{ $slot }}
</button>
