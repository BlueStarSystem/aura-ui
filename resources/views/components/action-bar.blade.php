@props([
    'count' => 0,
    'label' => null,
    'show' => null,
    'position' => 'bottom',
])

@php
    /**
     * The bar that appears when rows are selected, carrying the bulk actions.
     *
     * It arrives without warning: a screen-reader user selects a row and a set
     * of controls materialises somewhere else on the page. The count is
     * therefore announced politely as it changes, so the appearance is not
     * something only sighted users notice.
     */
    $positionClass = $position === 'top'
        ? 'top-4'
        : 'bottom-4';
@endphp

<div
    {{ $attributes->class([
        'aura-action-bar fixed left-1/2 z-aura-sticky flex -translate-x-1/2 items-center gap-3 rounded-aura-lg border border-aura-surface-200 bg-aura-surface-0 px-4 py-2.5 shadow-aura-xl',
        $positionClass,
    ]) }}
    role="region"
    aria-label="{{ $label ?? __('aura-ui::messages.bulk_actions') }}"
    @if($show !== null) x-show="{{ $show }}" x-cloak @endif
>
    <p class="aura-action-bar-count text-sm font-medium text-aura-surface-900" aria-hidden="true">
        {{ __('aura-ui::messages.selected_count', ['count' => $count]) }}
    </p>

    {{-- Politely, not assertively: it should not cut across whatever is being
         read, only be there when the reader arrives. --}}
    <span class="aura-visually-hidden" role="status" aria-live="polite">
        {{ __('aura-ui::messages.selected_count', ['count' => $count]) }}
    </span>

    <span class="aura-action-bar-divider h-5 w-px bg-aura-surface-200" aria-hidden="true"></span>

    <div class="aura-action-bar-actions flex items-center gap-2">
        {{ $slot }}
    </div>
</div>
