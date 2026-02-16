@props([
    'icon' => 'inbox',
    'title' => 'Nessun risultato',
    'description' => null,
])

<div {{ $attributes->class(['aura-empty-state', 'flex flex-col items-center justify-center py-12 px-6 text-center']) }}>
    <div class="aura-empty-state-icon flex items-center justify-center w-16 h-16 mb-4 bg-aura-surface-100 dark:bg-aura-surface-200 rounded-aura-full text-aura-surface-400">
        <x-aura::icon :name="$icon" size="xl" />
    </div>
    <h3 class="aura-empty-state-title m-0 mb-2 text-base font-semibold text-aura-surface-900">{{ $title }}</h3>
    @if($description)
        <p class="aura-empty-state-description m-0 mb-5 text-sm text-aura-surface-400 max-w-[360px] leading-normal">{{ $description }}</p>
    @endif
    @if($slot->isNotEmpty())
        <div class="aura-empty-state-actions flex items-center gap-2">
            {{ $slot }}
        </div>
    @endif
</div>
