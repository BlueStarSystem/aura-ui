@props([])

<form {{ $attributes->class(['aura-form', 'flex flex-col gap-6']) }}>
    {{ $slot }}
</form>
