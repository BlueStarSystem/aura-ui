@props([
    'label' => null,
    'name' => null,
])

<fieldset class="aura-radio-group" {{ $attributes }}>
    @if($label)
        <legend class="aura-label">{{ $label }}</legend>
    @endif
    <div class="aura-radio-group-items">
        {{ $slot }}
    </div>
</fieldset>
