@props([
    'value' => '',
    'icon' => null,
    'description' => '',
    'shortcut' => '',
])

<button
    type="button"
    class="aura-command-item flex items-center gap-3 w-full px-3 py-2 text-sm text-aura-surface-700 rounded-aura-md cursor-pointer border-none bg-transparent text-left aura-transition-fast hover:bg-aura-surface-100"
    data-command-item
    data-value="{{ strtolower($value) }}"
    x-show="!search || '{{ strtolower($value) }}'.includes(search.toLowerCase())"
    @click="open = false; $dispatch('aura:command', '{{ $value }}')"
    {{ $attributes }}
>
    @if($icon)
        <span class="aura-command-item-icon shrink-0 text-aura-surface-400">
            <x-aura::icon :name="$icon" size="sm" />
        </span>
    @endif
    <span class="aura-command-item-content flex-1 flex flex-col">
        <span class="aura-command-item-label font-medium">{{ $value }}</span>
        @if($description)
            <span class="aura-command-item-description text-xs text-aura-surface-400">{{ $description }}</span>
        @endif
    </span>
    @if($shortcut)
        <kbd class="aura-command-item-shortcut shrink-0 px-1.5 py-0.5 text-[10px] font-mono text-aura-surface-400 bg-aura-surface-100 rounded border border-aura-surface-200">{{ $shortcut }}</kbd>
    @endif
</button>
