@props([
    'size' => 'md',
    'color' => 'primary',
])

<div {{ $attributes->class(['aura-spinner', "aura-spinner-{$size}", "aura-spinner-{$color}"]) }} role="status" aria-label="Loading">
    <span class="sr-only">Loading...</span>
</div>
