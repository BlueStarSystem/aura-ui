@props([
    'language' => null,
    'filename' => null,
    'copyable' => true,
    'lines' => false,
])

@php
    /**
     * The slot arrives as literal source. Trimming the common indentation lets
     * a caller keep the snippet aligned with the surrounding Blade without that
     * indentation showing up in the copied text.
     */
    $raw = trim($slot->toHtml(), "\r\n");
    $codeLines = preg_split('/\r\n|\r|\n/', $raw) ?: [];

    $indents = array_map(
        fn (string $line): int => strlen($line) - strlen(ltrim($line)),
        array_filter($codeLines, fn (string $line): bool => trim($line) !== '')
    );

    $strip = $indents === [] ? 0 : min($indents);
    $codeLines = array_map(fn (string $line): string => substr($line, $strip), $codeLines);
    $code = implode("\n", $codeLines);

    $blockId = 'aura-code-block-'.\Illuminate\Support\Str::random(8);
@endphp

<div
    {{ $attributes->class(['aura-code-block overflow-hidden rounded-aura-lg border border-aura-surface-200 bg-aura-surface-50']) }}
    @if($copyable)
        x-data="{
            copied: false,
            copy() {
                const text = this.$refs.source.textContent;
                const done = () => { this.copied = true; setTimeout(() => this.copied = false, 2000); };

                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text).then(done);
                    return;
                }

                // http:// and older browsers have no clipboard API; without this
                // the button looks alive and silently does nothing.
                const area = document.createElement('textarea');
                area.value = text;
                area.setAttribute('readonly', '');
                area.style.cssText = 'position:absolute;left:-9999px';
                document.body.appendChild(area);
                area.select();
                document.execCommand('copy');
                area.remove();
                done();
            }
        }"
    @endif
>
    @if($language || $filename || $copyable)
        <div class="aura-code-block-header flex items-center justify-between gap-3 border-b border-aura-surface-200 bg-aura-surface-100 px-3 py-2">
            <div class="flex min-w-0 items-center gap-2">
                @if($filename)
                    <span class="aura-code-block-filename truncate font-mono text-xs text-aura-surface-700">{{ $filename }}</span>
                @endif

                @if($language)
                    <span class="aura-code-block-language shrink-0 rounded-aura-sm bg-aura-surface-200 px-1.5 py-0.5 font-mono text-[10px] uppercase tracking-wide text-aura-surface-700">{{ $language }}</span>
                @endif
            </div>

            @if($copyable)
                <button
                    type="button"
                    class="aura-code-block-copy inline-flex shrink-0 items-center gap-1.5 rounded-aura-sm border border-aura-surface-200 bg-aura-surface-0 px-2 py-1 text-xs font-medium text-aura-surface-700 cursor-pointer aura-transition-fast hover:bg-aura-surface-100 hover:text-aura-surface-900"
                    x-on:click="copy()"
                    aria-describedby="{{ $blockId }}-status"
                >
                    <x-aura::icon name="copy" size="xs" x-show="!copied" />
                    <x-aura::icon name="check" size="xs" x-show="copied" x-cloak />
                    <span x-text="copied ? {{ Js::from(__('aura-ui::messages.copied')) }} : {{ Js::from(__('aura-ui::messages.copy')) }}"></span>
                </button>
            @endif
        </div>
    @endif

    {{-- A snippet wider than its box scrolls, and a scrollable region has to be
         focusable or the arrow keys never reach it. Exactly what scroll-area
         exists to get right, and exactly what this got wrong first time. --}}
    <div
        class="aura-code-block-body overflow-x-auto"
        tabindex="0"
        role="region"
        aria-label="{{ $filename ?? ($language ? $language.' '.__('aura-ui::messages.code') : __('aura-ui::messages.code')) }}"
    >
        <pre class="m-0 p-3 font-mono text-[13px] leading-relaxed text-aura-surface-900"><code
            x-ref="source"
            @if($language) class="language-{{ $language }}" @endif
        >@if($lines)@foreach($codeLines as $i => $line)<span class="aura-code-block-line block"><span class="aura-code-block-lineno mr-4 inline-block w-6 select-none text-right text-aura-surface-600" aria-hidden="true">{{ $i + 1 }}</span>{{ $line }}</span>@endforeach @else{{ $code }}@endif</code></pre>
    </div>

    @if($copyable)
        {{-- A visual tick tells a sighted user the copy worked and tells a
             screen-reader user nothing; this says it out loud. --}}
        <span id="{{ $blockId }}-status" class="aura-visually-hidden" role="status" aria-live="polite" x-text="copied ? {{ Js::from(__('aura-ui::messages.copied')) }} : ''"></span>
    @endif
</div>
