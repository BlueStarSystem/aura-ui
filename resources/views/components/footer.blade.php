@props([
    'brand' => null,
    'tagline' => null,
    'copyright' => null,
    'columns' => 4,
    'bordered' => true,
])

@php
    /**
     * A real <footer>. It is a landmark, so a screen-reader user can jump
     * straight to it; a styled <div> is invisible to that shortcut.
     *
     * Column counts are written out because Tailwind reads source files as
     * text and generates nothing for `sm:grid-cols-{$columns}`.
     */
    $columnClass = match ((int) $columns) {
        1 => 'sm:grid-cols-1',
        2 => 'sm:grid-cols-2',
        3 => 'sm:grid-cols-2 lg:grid-cols-3',
        5 => 'sm:grid-cols-3 lg:grid-cols-5',
        default => 'sm:grid-cols-2 lg:grid-cols-4',
    };
@endphp

<footer {{ $attributes->class(['aura-footer', $bordered ? 'border-t border-aura-surface-200' : '']) }}>
    <div class="aura-footer-inner mx-auto w-full max-w-7xl px-6 py-10">
        @if($brand || $tagline || isset($start))
            <div class="aura-footer-head mb-8 max-w-sm">
                @if($brand)
                    <p class="aura-footer-brand text-lg font-semibold text-aura-surface-900">{{ $brand }}</p>
                @endif

                @if($tagline)
                    <p class="aura-footer-tagline mt-1 text-sm text-aura-surface-600">{{ $tagline }}</p>
                @endif

                {{ $start ?? '' }}
            </div>
        @endif

        @if(trim($slot) !== '')
            <div class="aura-footer-columns grid grid-cols-1 gap-8 {{ $columnClass }}">
                {{ $slot }}
            </div>
        @endif

        @if($copyright || isset($end))
            <div class="aura-footer-foot mt-10 flex flex-col gap-3 border-t border-aura-surface-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                @if($copyright)
                    <p class="aura-footer-copyright text-sm text-aura-surface-600">{{ $copyright }}</p>
                @endif

                {{ $end ?? '' }}
            </div>
        @endif
    </div>
</footer>
