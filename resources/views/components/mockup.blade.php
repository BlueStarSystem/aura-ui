@props([
    'variant' => 'browser',
    'url' => null,
    'title' => null,
    'shadow' => true,
])

@php
    /**
     * A browser or phone frame around a screenshot.
     *
     * The frame is scenery — the traffic-light dots, the notch, the fake
     * address bar. All of it is aria-hidden, so a screen reader is not read
     * three coloured circles before reaching the thing that matters. The
     * content inside is the content.
     */
    $isPhone = $variant === 'phone';
@endphp

<figure {{ $attributes->class([
    'aura-mockup overflow-hidden border border-aura-surface-300 bg-aura-surface-0',
    $isPhone ? 'aura-mockup-phone mx-auto w-[16rem] rounded-[2rem] p-2' : 'aura-mockup-browser rounded-aura-lg',
    $shadow ? 'shadow-aura-xl' : '',
]) }}>
    @if($isPhone)
        <div class="aura-mockup-notch mx-auto mb-2 h-1.5 w-16 rounded-full bg-aura-surface-300" aria-hidden="true"></div>

        <div class="aura-mockup-screen overflow-hidden rounded-[1.5rem] bg-aura-surface-50">
            {{ $slot }}
        </div>
    @else
        <div class="aura-mockup-chrome flex items-center gap-2 border-b border-aura-surface-200 bg-aura-surface-100 px-3 py-2" aria-hidden="true">
            <span class="flex gap-1.5">
                <span class="h-2.5 w-2.5 rounded-full bg-aura-danger-400"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-aura-warning-400"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-aura-success-400"></span>
            </span>

            @if($url)
                <span class="aura-mockup-url mx-auto max-w-[70%] truncate rounded-aura-full bg-aura-surface-0 px-3 py-0.5 font-mono text-[11px] text-aura-surface-600">{{ $url }}</span>
            @endif
        </div>

        <div class="aura-mockup-screen bg-aura-surface-50">
            {{ $slot }}
        </div>
    @endif

    @if($title)
        {{-- A real caption, not decoration: it describes the screenshot for
             everyone, which is what a figure is for. --}}
        <figcaption class="aura-mockup-caption border-t border-aura-surface-200 px-3 py-2 text-center text-xs text-aura-surface-600">{{ $title }}</figcaption>
    @endif
</figure>
