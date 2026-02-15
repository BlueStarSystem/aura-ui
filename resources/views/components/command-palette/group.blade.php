@props([
    'heading' => '',
])

<div class="aura-command-group" {{ $attributes }}>
    @if($heading)
        <div class="aura-command-group-heading">{{ $heading }}</div>
    @endif
    {{ $slot }}
</div>
