@props([
    'label' => null,
    'placeholder' => 'Scrivi qui...',
    'toolbar' => 'bold,italic,underline,link,list-ordered,list-unordered,heading',
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'minHeight' => '150px',
])

@php
    $toolbarItems = array_map('trim', explode(',', $toolbar));
    $toolbarIcons = [
        'bold' => ['icon' => 'bold', 'cmd' => 'bold', 'label' => 'Grassetto'],
        'italic' => ['icon' => 'italic', 'cmd' => 'italic', 'label' => 'Corsivo'],
        'underline' => ['icon' => 'underline', 'cmd' => 'underline', 'label' => 'Sottolineato'],
        'strikethrough' => ['icon' => 'strikethrough', 'cmd' => 'strikeThrough', 'label' => 'Barrato'],
        'link' => ['icon' => 'link', 'cmd' => 'link', 'label' => 'Link'],
        'list-ordered' => ['icon' => 'list-ordered', 'cmd' => 'insertOrderedList', 'label' => 'Lista numerata'],
        'list-unordered' => ['icon' => 'list', 'cmd' => 'insertUnorderedList', 'label' => 'Lista puntata'],
        'heading' => ['icon' => 'type', 'cmd' => 'heading', 'label' => 'Intestazione'],
    ];
@endphp

<div
    {{ $attributes->class(['aura-editor-wrapper']) }}
    x-data="{
        value: @entangle($attributes->wire('model')),

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
                let url = prompt('URL:');
                if (url) document.execCommand('createLink', false, url);
            } else if (cmd === 'heading') {
                document.execCommand('formatBlock', false, '<h3>');
            } else {
                document.execCommand(cmd, false, null);
            }
            this.$refs.editable.focus();
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

    <div class="aura-editor {{ $error ? 'aura-editor-error' : '' }} {{ $disabled ? 'aura-editor-disabled' : '' }}">
        {{-- Toolbar --}}
        <div class="aura-editor-toolbar">
            @foreach($toolbarItems as $item)
                @if(isset($toolbarIcons[$item]))
                    @php $btn = $toolbarIcons[$item]; @endphp
                    <button
                        type="button"
                        class="aura-editor-btn"
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
            class="aura-editor-content"
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
