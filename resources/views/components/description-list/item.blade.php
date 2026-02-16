@props([
    'label' => '',
    'value' => null,
])

<div class="aura-description-item flex flex-col gap-1 sm:flex-row sm:gap-4">
    <dt class="aura-description-label text-sm font-medium text-aura-surface-500 sm:w-1/3 sm:shrink-0">{{ $label }}</dt>
    <dd class="aura-description-value text-sm text-aura-surface-900 m-0">{{ $value ?? $slot }}</dd>
</div>
