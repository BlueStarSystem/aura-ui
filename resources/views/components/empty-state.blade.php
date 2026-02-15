@props([
    'icon' => 'inbox',
    'title' => 'Nessun risultato',
    'description' => null,
])

<div {{ $attributes->class(['aura-empty-state']) }}>
    <div class="aura-empty-state-icon">
        <x-aura::icon :name="$icon" size="xl" />
    </div>
    <h3 class="aura-empty-state-title">{{ $title }}</h3>
    @if($description)
        <p class="aura-empty-state-description">{{ $description }}</p>
    @endif
    @if($slot->isNotEmpty())
        <div class="aura-empty-state-actions">
            {{ $slot }}
        </div>
    @endif
</div>
