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
    // Falls back rather than emitting whatever arrived: this lands inside a
    // style attribute, where a semicolon starts a second declaration.
    $safeMinHeight = \BlueStarSystem\AuraUI\Support\Html::cssValue($minHeight) ?? '150px';
    $toolbarItems = is_array($toolbar) ? $toolbar : array_map('trim', explode(',', $toolbar));
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
        value: @if(isset($__livewire) && $attributes->wire('model')->value()) $wire.entangle({{ Js::from($attributes->wire('model')->value()) }}){{ $attributes->wire('model')->hasModifier('live') ? '.live' : '' }} @else '' @endif,

        sanitize(html) {
            const temp = document.createElement('div');
            temp.textContent = '';
            temp.innerHTML = html;
            temp.querySelectorAll('script,iframe,object,embed').forEach(el => el.remove());
            [...temp.querySelectorAll('*')].forEach(el => {
                [...el.attributes].forEach(attr => {
                    if (attr.name.startsWith('on')) el.removeAttribute(attr.name);
                });
            });
            return temp.innerHTML;
        },

        init() {
            this.$refs.editable.innerHTML = this.sanitize(this.value || '');
            this.$watch('value', (v) => {
                if (this.$refs.editable.innerHTML !== v) {
                    this.$refs.editable.innerHTML = this.sanitize(v || '');
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
    @php
        $editorId = 'aura-editor-'.\Illuminate\Support\Str::random(8);
        $editorDescribedBy = $error ? $editorId.'-error' : ($hint ? $editorId.'-hint' : null);
    @endphp

    @if($label)
        {{-- A contenteditable div is not a form control, so `for` would not bind
             to it. aria-labelledby is what names a role="textbox". --}}
        <span class="aura-label" id="{{ $editorId }}-label">{{ $label }}</span>
    @endif

    <div class="aura-editor border border-aura-surface-500 rounded-aura-md overflow-hidden {{ $error ? 'aura-editor-error border-aura-danger-500' : '' }} {{ $disabled ? 'aura-editor-disabled opacity-50 pointer-events-none' : '' }}">
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
            style="min-height: {{ $safeMinHeight }}"
            role="textbox"
            aria-multiline="true"
            @if($label) aria-labelledby="{{ $editorId }}-label" @else aria-label="{{ __('aura-ui::messages.editor_content') }}" @endif
            @if($editorDescribedBy) aria-describedby="{{ $editorDescribedBy }}" @endif
            @if($error) aria-invalid="true" @endif
            @if($disabled) aria-disabled="true" @endif
            @if($placeholder) data-placeholder="{{ $placeholder }}" @endif
        ></div>
    </div>

    @if($error)
        <p role="alert" class="aura-input-error-text" id="{{ $editorId }}-error">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint" id="{{ $editorId }}-hint">{{ $hint }}</p>
    @endif
</div>
