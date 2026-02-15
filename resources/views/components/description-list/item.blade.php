@props([
    'label' => '',
    'value' => null,
])

<div class="aura-description-item">
    <dt class="aura-description-label">{{ $label }}</dt>
    <dd class="aura-description-value">{{ $value ?? $slot }}</dd>
</div>
