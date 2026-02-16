@props([
    'label' => null,
    'name' => null,
])

<fieldset class="aura-radio-group border-none p-0 m-0" {{ $attributes }}>
    @if($label)
        <legend class="aura-label text-sm font-medium text-aura-surface-700 mb-2">{{ $label }}</legend>
    @endif
    <div class="aura-radio-group-items flex flex-col gap-2">
        {{ $slot }}
    </div>
</fieldset>
