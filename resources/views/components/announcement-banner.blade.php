@props([
    'variant' => 'primary',
    'dismissible' => true,
    'storageKey' => null,
    'href' => null,
    'linkText' => null,
    'icon' => null,
    'label' => null,
])

@php
    /**
     * The strip above the header: a release, a sale, a maintenance window.
     *
     * Deliberately not role="alert". That interrupts whatever a screen reader
     * is saying mid-sentence, which is right for something that just went
     * wrong and wrong for a marketing line that was there before the page
     * loaded. It is a labelled region instead, so it can be found and skipped.
     */
    $bannerId = 'aura-announcement-'.\Illuminate\Support\Str::random(8);

    $variantClass = match ($variant) {
        'success' => 'bg-aura-success-700 text-white',
        'warning' => 'bg-aura-warning-700 text-white',
        'danger' => 'bg-aura-danger-700 text-white',
        'dark' => 'bg-aura-surface-900 text-aura-surface-0',
        default => 'bg-aura-primary-700 text-white',
    };
@endphp

<div
    {{ $attributes->class(['aura-announcement-banner relative w-full', $variantClass]) }}
    role="region"
    aria-label="{{ $label ?? __('aura-ui::messages.announcement') }}"
    @if($dismissible)
        x-data="{
            shown: true,
            key: {{ Js::from($storageKey ?? '') }},

            init() {
                // Only remembered when a key is given: a banner that vanishes
                // for good after one accidental click, with no way back, is
                // worse than one that returns.
                if (this.key && localStorage.getItem('aura-dismissed-' + this.key) === '1') {
                    this.shown = false;
                }
            },

            dismiss() {
                this.shown = false;
                if (this.key) localStorage.setItem('aura-dismissed-' + this.key, '1');
            }
        }"
        x-show="shown"
        x-cloak
    @endif
>
    <div class="aura-announcement-inner mx-auto flex w-full max-w-7xl items-center justify-center gap-3 px-6 py-2.5 text-sm {{ $dismissible ? 'pr-12' : '' }}">
        @if($icon)
            <x-aura::icon :name="$icon" size="sm" aria-hidden="true" class="shrink-0" />
        @endif

        <p class="aura-announcement-text text-center">
            {{ $slot }}

            @if($href)
                <a
                    href="{{ \BlueStarSystem\AuraUI\Support\Html::url($href) }}"
                    class="aura-announcement-link ml-1 font-semibold underline underline-offset-2 hover:no-underline"
                >{{ $linkText ?? __('aura-ui::messages.learn_more') }}</a>
            @endif
        </p>
    </div>

    @if($dismissible)
        <button
            type="button"
            class="aura-announcement-dismiss absolute right-3 top-1/2 inline-flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-aura-sm cursor-pointer opacity-80 aura-transition-fast hover:bg-white/15 hover:opacity-100"
            x-on:click="dismiss()"
            aria-label="{{ __('aura-ui::messages.dismiss_announcement') }}"
        >
            <x-aura::icon name="x" size="sm" aria-hidden="true" />
        </button>
    @endif
</div>
