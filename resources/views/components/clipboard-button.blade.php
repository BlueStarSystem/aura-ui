@props([
    'text' => '',
    'label' => null,
    'copiedLabel' => null,
    'variant' => 'secondary',
    'size' => 'md',
    'iconOnly' => false,
])

@php
    $copyLabel = $label ?? __('aura-ui::messages.copy');
    $doneLabel = $copiedLabel ?? __('aura-ui::messages.copied');
    $clipboardId = 'aura-clipboard-'.\Illuminate\Support\Str::random(8);

    $sizeClass = match ($size) {
        'sm' => 'px-2 py-1 text-xs gap-1',
        'lg' => 'px-4 py-2.5 text-base gap-2',
        default => 'px-3 py-1.5 text-sm gap-1.5',
    };

    $variantClass = match ($variant) {
        'primary' => 'bg-aura-primary-600 text-white hover:bg-aura-primary-700 border-transparent',
        'ghost' => 'bg-transparent text-aura-surface-700 hover:bg-aura-surface-100 border-transparent',
        default => 'bg-aura-surface-0 text-aura-surface-900 border-aura-surface-200 hover:bg-aura-surface-50',
    };
@endphp

<span
    class="aura-clipboard inline-flex"
    x-data="{
        copied: false,
        copy() {
            const value = {{ Js::from((string) $text) }};
            const done = () => { this.copied = true; setTimeout(() => this.copied = false, 2000); };

            if (navigator.clipboard) {
                navigator.clipboard.writeText(value).then(done);
                return;
            }

            // No clipboard API on http:// or in older browsers; without this the
            // button looks alive and quietly does nothing.
            const area = document.createElement('textarea');
            area.value = value;
            area.setAttribute('readonly', '');
            area.style.cssText = 'position:absolute;left:-9999px';
            document.body.appendChild(area);
            area.select();
            document.execCommand('copy');
            area.remove();
            done();
        }
    }"
>
    <button
        type="button"
        {{ $attributes->class(['aura-clipboard-button inline-flex items-center justify-center rounded-aura-md border font-medium cursor-pointer aura-transition-fast', $sizeClass, $variantClass]) }}
        x-on:click="copy()"
        @if($iconOnly) x-bind:aria-label="copied ? {{ Js::from($doneLabel) }} : {{ Js::from($copyLabel) }}" @endif
        aria-describedby="{{ $clipboardId }}-status"
    >
        <x-aura::icon name="copy" :size="$size === 'lg' ? 'md' : 'xs'" x-show="!copied" />
        <x-aura::icon name="check" :size="$size === 'lg' ? 'md' : 'xs'" x-show="copied" x-cloak />

        @unless($iconOnly)
            <span x-text="copied ? {{ Js::from($doneLabel) }} : {{ Js::from($copyLabel) }}"></span>
        @endunless
    </button>

    {{-- The icon swapping to a tick tells a sighted user it worked and tells a
         screen-reader user nothing. --}}
    <span id="{{ $clipboardId }}-status" class="aura-visually-hidden" role="status" aria-live="polite" x-text="copied ? {{ Js::from($doneLabel) }} : ''"></span>
</span>
