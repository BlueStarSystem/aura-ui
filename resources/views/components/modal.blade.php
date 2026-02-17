@props([
    'name' => null,
    'title' => null,
    'maxWidth' => 'lg',
    'glass' => false,
    'closeable' => true,
])

@php
    $maxWidthClass = match($maxWidth) {
        'sm' => 'aura-modal-sm max-w-sm',
        'md' => 'aura-modal-md max-w-md',
        'lg' => 'aura-modal-lg max-w-lg',
        'xl' => 'aura-modal-xl max-w-xl',
        '2xl' => 'aura-modal-2xl max-w-3xl',
        'full' => 'aura-modal-full max-w-full',
        default => 'aura-modal-lg max-w-lg',
    };
    $contentClasses = ['aura-modal-content', $maxWidthClass, 'relative w-full max-h-[calc(100vh-48px)] bg-aura-surface-0 border border-aura-surface-200 rounded-aura-xl shadow-aura-2xl overflow-hidden flex flex-col'];
    if ($glass) $contentClasses[] = 'aura-glass';
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
            class="aura-modal-overlay aura-glass-overlay fixed inset-0 z-aura-modal flex items-center justify-center p-6"
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
                class="{{ implode(' ', $contentClasses) }}"
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
                    <div class="aura-modal-header px-6 pt-5 pb-4 border-b border-aura-surface-200 flex items-center justify-between gap-4">
                        <h3 class="aura-modal-title text-[17px] font-bold text-aura-surface-900 m-0 tracking-tight">{{ $title }}</h3>
                        @if($closeable)
                            <button type="button" class="aura-modal-close shrink-0 w-8 h-8 flex items-center justify-center border-none bg-transparent text-aura-surface-400 rounded-aura-sm cursor-pointer aura-transition-fast hover:bg-aura-surface-100 hover:text-aura-surface-900" x-on:click="open = false" aria-label="Close">
                                <x-aura::icon name="x" size="md" />
                            </button>
                        @endif
                    </div>
                @endif

                <div class="aura-modal-body px-6 py-5 overflow-y-auto text-sm text-aura-surface-500 leading-relaxed">
                    {{ $slot }}
                </div>

                @if(isset($footer))
                    <div class="aura-modal-footer px-6 py-4 border-t border-aura-surface-200 bg-aura-surface-50 flex items-center justify-end gap-2">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </template>
</div>
