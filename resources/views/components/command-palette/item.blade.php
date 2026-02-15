@props([
    'value' => '',
    'icon' => null,
    'description' => '',
    'shortcut' => '',
])

<button
    type="button"
    class="aura-command-item"
    data-command-item
    data-value="{{ strtolower($value) }}"
    x-show="!search || '{{ strtolower($value) }}'.includes(search.toLowerCase())"
    @click="open = false; $dispatch('aura:command', '{{ $value }}')"
    {{ $attributes }}
>
    @if($icon)
        <span class="aura-command-item-icon">
            <x-aura::icon :name="$icon" size="sm" />
        </span>
    @endif
    <span class="aura-command-item-content">
        <span class="aura-command-item-label">{{ $value }}</span>
        @if($description)
            <span class="aura-command-item-description">{{ $description }}</span>
        @endif
    </span>
    @if($shortcut)
        <kbd class="aura-command-item-shortcut">{{ $shortcut }}</kbd>
    @endif
</button>
