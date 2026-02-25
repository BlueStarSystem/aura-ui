@props([
    'icon' => null,
])

<li {{ $attributes->class(['aura-list-item flex items-start gap-3 px-3 py-2 text-sm text-aura-surface-700']) }}>
    @if($icon)
        <span class="aura-list-item-icon mt-0.5 flex-shrink-0 text-aura-surface-400">
            <x-aura::icon :name="$icon" class="h-4 w-4" />
        </span>
    @endif
    <span class="aura-list-item-content flex-1">{{ $slot }}</span>
</li>
