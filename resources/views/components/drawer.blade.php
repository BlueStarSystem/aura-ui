@props([
    'name' => null,
    'title' => null,
    'position' => 'right',
    'size' => 'md',
    'overlay' => true,
    'closeable' => true,
])

@php
    $sizeClass = match($size) {
        'sm' => 'max-w-xs',
        'lg' => 'max-w-xl',
        'xl' => 'max-w-2xl',
        'full' => 'max-w-full',
        default => 'max-w-md',
    };

    $positionClasses = match($position) {
        'left' => 'left-0 top-0 bottom-0',
        'top' => 'top-0 left-0 right-0',
        'bottom' => 'bottom-0 left-0 right-0',
        default => 'right-0 top-0 bottom-0',
    };

    $isHorizontal = in_array($position, ['top', 'bottom']);

    $translateEnter = match($position) {
        'left' => '-translate-x-full',
        'top' => '-translate-y-full',
        'bottom' => 'translate-y-full',
        default => 'translate-x-full',
    };
@endphp

<div x-data="{ open: false }"
     @if($name) x-on:open-drawer.window="if ($event.detail === '{{ $name }}') open = true"
     x-on:close-drawer.window="if ($event.detail === '{{ $name }}') open = false" @endif
     x-on:keydown.escape.window="open = false"
     {{ $attributes }}>

    @if(isset($trigger))
        <div x-on:click="open = true">
            {{ $trigger }}
        </div>
    @endif

    <template x-teleport="body">
        @if($overlay)
        <div class="aura-drawer-overlay fixed inset-0 z-aura-modal bg-black/50 aura-transition"
             x-show="open"
             x-transition:enter="aura-transition-slow"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="aura-transition-fast"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @if($closeable) x-on:click="open = false" @endif
             x-cloak>
        </div>
        @endif

        <div class="aura-drawer aura-drawer-{{ $position }} fixed z-aura-modal {{ $positionClasses }} {{ $isHorizontal ? 'w-full' : 'h-full ' . $sizeClass }} bg-aura-surface-0 shadow-aura-2xl aura-transition"
             x-show="open"
             x-transition:enter="transform transition ease-out duration-300"
             x-transition:enter-start="{{ $translateEnter }}"
             x-transition:enter-end="translate-x-0 translate-y-0"
             x-transition:leave="transform transition ease-in duration-200"
             x-transition:leave-start="translate-x-0 translate-y-0"
             x-transition:leave-end="{{ $translateEnter }}"
             x-on:click.stop
             x-cloak>

            @if($title || $closeable)
            <div class="aura-drawer-header flex items-center justify-between border-b border-aura-surface-200 px-6 py-4">
                @if($title)
                    <h3 class="text-lg font-semibold text-aura-surface-900">{{ $title }}</h3>
                @else
                    <div></div>
                @endif
                @if($closeable)
                    <button x-on:click="open = false" class="rounded-aura-sm p-1 text-aura-surface-400 hover:text-aura-surface-600 aura-transition">
                        <x-aura::icon name="x" size="sm" />
                    </button>
                @endif
            </div>
            @endif

            <div class="aura-drawer-body overflow-y-auto p-6" style="{{ $isHorizontal ? 'max-height: 80vh' : 'height: calc(100% - 65px)' }}">
                {{ $slot }}
            </div>

            @if(isset($footer))
                <div class="aura-drawer-footer border-t border-aura-surface-200 px-6 py-4 flex items-center justify-end gap-2">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </template>
</div>
