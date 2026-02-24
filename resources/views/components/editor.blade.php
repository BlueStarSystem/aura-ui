@props([
    'label' => null,
    'placeholder' => 'Write here...',
    'toolbar' => 'bold,italic,underline,link,list-ordered,list-unordered,heading',
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'minHeight' => '150px',
])

@php
    $toolbarItems = array_map('trim', explode(',', $toolbar));
    $toolbarIcons = [
        'bold' => ['icon' => 'bold', 'cmd' => 'bold', 'label' => 'Bold'],
        'italic' => ['icon' => 'italic', 'cmd' => 'italic', 'label' => 'Italic'],
        'underline' => ['icon' => 'underline', 'cmd' => 'underline', 'label' => 'Underline'],
        'strikethrough' => ['icon' => 'strikethrough', 'cmd' => 'strikeThrough', 'label' => 'Strikethrough'],
        'link' => ['icon' => 'link', 'cmd' => 'link', 'label' => 'Link'],
        'list-ordered' => ['icon' => 'list-ordered', 'cmd' => 'insertOrderedList', 'label' => 'Ordered list'],
        'list-unordered' => ['icon' => 'list', 'cmd' => 'insertUnorderedList', 'label' => 'Unordered list'],
        'heading' => ['icon' => 'type', 'cmd' => 'heading', 'label' => 'Heading'],
    ];
@endphp

<div
    {{ $attributes->class(['aura-editor-wrapper flex flex-col gap-1.5']) }}
    x-data="{
        value: @if(isset($__livewire) && $attributes->wire('model')->value()) $wire.entangle('{{ $attributes->wire('model')->value() }}'){{ $attributes->wire('model')->hasModifier('live') ? '.live' : '' }} @else '' @endif,

        init() {
            this.$refs.editable.innerHTML = this.value || '';
            this.$watch('value', (v) => {
                if (this.$refs.editable.innerHTML !== v) {
                    this.$refs.editable.innerHTML = v || '';
                }
            });
        },

        exec(cmd) {
            if (cmd === 'link') {
                let sel = window.getSelection();
                let url = prompt('URL:', 'https://');
                if (url) document.execCommand('createLink', false, url);
            } else if (cmd === 'heading') {
                let sel = window.getSelection();
                let block = sel.anchorNode?.parentElement?.closest('h2, h3, h4, p, div');
                let tag = block?.tagName;
                if (tag === 'H2') {
                    document.execCommand('formatBlock', false, '<h3>');
                } else if (tag === 'H3') {
                    document.execCommand('formatBlock', false, '<p>');
                } else {
                    document.execCommand('formatBlock', false, '<h2>');
                }
            } else {
                document.execCommand(cmd, false, null);
            }
            this.sync();
        },

        sync() {
            this.value = this.$refs.editable.innerHTML;
        }
    }"
>
    @if($label)
        <label class="aura-label">{{ $label }}</label>
    @endif

    <div class="aura-editor border border-aura-surface-200 rounded-aura-md overflow-hidden {{ $error ? 'aura-editor-error border-aura-danger-500' : '' }} {{ $disabled ? 'aura-editor-disabled opacity-50 pointer-events-none' : '' }}">
        {{-- Toolbar --}}
        <div class="aura-editor-toolbar flex items-center gap-0.5 px-2 py-1.5 border-b border-aura-surface-200 bg-aura-surface-50">
            @foreach($toolbarItems as $item)
                @if(isset($toolbarIcons[$item]))
                    @php $btn = $toolbarIcons[$item]; @endphp
                    <button
                        type="button"
                        class="aura-editor-btn inline-flex items-center justify-center w-8 h-8 rounded-aura-sm bg-transparent border-none text-aura-surface-500 cursor-pointer aura-transition-fast hover:bg-aura-surface-200 hover:text-aura-surface-900 disabled:opacity-50 disabled:cursor-not-allowed"
                        x-on:mousedown.prevent
                        x-on:click="exec('{{ $btn['cmd'] }}')"
                        title="{{ $btn['label'] }}"
                        @if($disabled) disabled @endif
                    >
                        <x-aura::icon :name="$btn['icon']" size="sm" />
                    </button>
                @endif
            @endforeach
        </div>

        {{-- Editable area --}}
        <div
            x-ref="editable"
            class="aura-editor-content px-3 py-2.5 text-sm text-aura-surface-900 leading-relaxed outline-none"
            contenteditable="{{ $disabled ? 'false' : 'true' }}"
            x-on:input="sync()"
            x-on:paste.prevent="
                let text = $event.clipboardData.getData('text/plain');
                document.execCommand('insertText', false, text);
                sync();
            "
            style="min-height: {{ $minHeight }}"
            role="textbox"
            aria-multiline="true"
            @if($placeholder) data-placeholder="{{ $placeholder }}" @endif
        ></div>
    </div>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
