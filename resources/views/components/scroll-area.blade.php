@props([
    'height' => '300px',
    'maxHeight' => null,
    'axis' => 'vertical',
    'label' => null,
    'fade' => true,
])

@php
    /**
     * A scrollable region has to be reachable by keyboard: someone who cannot
     * use a pointer needs to focus it before the arrow keys will scroll it.
     * That is WCAG 2.1.1, and it is the single thing most custom scroll
     * containers get wrong. tabindex="0" plus a name is the whole fix.
     */
    $axisClass = match ($axis) {
        'horizontal' => 'overflow-x-auto overflow-y-hidden',
        'both' => 'overflow-auto',
        default => 'overflow-y-auto overflow-x-hidden',
    };

    // cssValue sanitises the VALUE; the property name is ours and never comes
    // from the caller.
    $sizeProperty = $maxHeight ? 'max-height' : 'height';
    $sizeValue = \BlueStarSystem\AuraUI\Support\Html::cssValue($maxHeight ?? $height) ?? '300px';
@endphp

<div class="aura-scroll-area relative">
    <div
        {{ $attributes->class(['aura-scroll-area-viewport rounded-aura-md', $axisClass]) }}
        style="{{ $sizeProperty }}: {{ $sizeValue }}"
        tabindex="0"
        role="region"
        aria-label="{{ $label ?? __('aura-ui::messages.scrollable_region') }}"
    >
        {{ $slot }}
    </div>

    @if($fade)
        {{-- Decoration only, and it must not swallow the scroll gesture. --}}
        <div class="aura-scroll-area-fade pointer-events-none absolute inset-x-0 bottom-0 h-6 bg-gradient-to-t from-aura-surface-0 to-transparent" aria-hidden="true"></div>
    @endif
</div>
