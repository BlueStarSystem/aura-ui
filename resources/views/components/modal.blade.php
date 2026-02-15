@props([
    'name' => null,
    'title' => null,
    'maxWidth' => 'lg',
    'glass' => false,
    'closeable' => true,
    'slideOver' => false,
    'position' => 'right',
])

@php
    $maxWidthClass = match($maxWidth) {
        'sm' => 'aura-modal-sm',
        'md' => 'aura-modal-md',
        'lg' => 'aura-modal-lg',
        'xl' => 'aura-modal-xl',
        '2xl' => 'aura-modal-2xl',
        'full' => 'aura-modal-full',
        default => 'aura-modal-lg',
    };
    $contentClass = ['aura-modal-content', $maxWidthClass];
    if ($glass) $contentClass[] = 'aura-glass';
@endphp

<div
    x-data="{ open: false }"
    @if($name) x-on:open-modal.window="if ($event.detail === '{{ $name }}') open = true"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') open = false" @endif
    x-on:keydown.escape.window="open = false"
    {{ $attributes }}
>
    @if(isset($trigger))
        <div x-on:click="open = true">
            {{ $trigger }}
        </div>
    @endif

    <template x-teleport="body">
        <div
            class="aura-modal-overlay aura-glass-overlay"
            x-show="open"
            x-transition:enter="aura-transition-slow"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="aura-transition-fast"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @if($closeable) x-on:click="open = false" @endif
            style="display: none;"
        >
            <div
                class="{{ implode(' ', $contentClass) }}"
                x-show="open"
                x-transition:enter="aura-transition"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="aura-transition-fast"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                x-on:click.stop
            >
                @if(isset($title))
                    <div class="aura-modal-header">
                        <h3 class="aura-modal-title">{{ $title }}</h3>
                        @if($closeable)
                            <button type="button" class="aura-modal-close" x-on:click="open = false" aria-label="Chiudi">
                                <x-aura::icon name="x" size="md" />
                            </button>
                        @endif
                    </div>
                @endif

                <div class="aura-modal-body">
                    {{ $slot }}
                </div>

                @if(isset($footer))
                    <div class="aura-modal-footer">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </template>
</div>
