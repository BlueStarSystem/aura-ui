@props([
    'label' => null,
    'accept' => null,
    'maxSize' => null,
    'multiple' => false,
    'preview' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
])

@php
    $maxBytes = null;
    if ($maxSize) {
        $unit = strtoupper(substr($maxSize, -2));
        $num = (float) $maxSize;
        $maxBytes = match($unit) {
            'KB' => $num * 1024,
            'MB' => $num * 1024 * 1024,
            'GB' => $num * 1024 * 1024 * 1024,
            default => $num,
        };
    }
@endphp

<div
    {{ $attributes->class(['aura-file-upload-wrapper']) }}
    x-data="{
        dragging: false,
        files: [],
        error: '',
        maxBytes: {{ $maxBytes ?? 'null' }},
        accept: '{{ $accept ?? '' }}',
        multiple: {{ $multiple ? 'true' : 'false' }},
        preview: {{ $preview ? 'true' : 'false' }},

        handleDrop(e) {
            this.dragging = false;
            this.addFiles(e.dataTransfer.files);
        },

        handleSelect(e) {
            this.addFiles(e.target.files);
        },

        addFiles(fileList) {
            this.error = '';
            for (let f of fileList) {
                if (this.maxBytes && f.size > this.maxBytes) {
                    this.error = f.name + ' supera la dimensione massima ({{ $maxSize }})';
                    continue;
                }
                if (this.accept && !this.matchesAccept(f)) {
                    this.error = f.name + ' tipo non consentito';
                    continue;
                }

                let entry = { name: f.name, size: this.formatSize(f.size), type: f.type, previewUrl: null };
                if (this.preview && f.type.startsWith('image/')) {
                    entry.previewUrl = URL.createObjectURL(f);
                }
                this.files.push(entry);
            }

            // Dispatch to wire:model via native input
            let input = this.$refs.fileInput;
            let dt = new DataTransfer();
            for (let f of fileList) dt.items.add(f);
            input.files = dt.files;
            input.dispatchEvent(new Event('change', { bubbles: true }));
        },

        matchesAccept(file) {
            if (!this.accept) return true;
            let types = this.accept.split(',').map(t => t.trim());
            return types.some(t => {
                if (t.endsWith('/*')) return file.type.startsWith(t.replace('/*', '/'));
                if (t.startsWith('.')) return file.name.toLowerCase().endsWith(t.toLowerCase());
                return file.type === t;
            });
        },

        removeFile(idx) {
            if (this.files[idx].previewUrl) URL.revokeObjectURL(this.files[idx].previewUrl);
            this.files.splice(idx, 1);
        },

        formatSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        },

        clear() {
            this.files.forEach(f => { if (f.previewUrl) URL.revokeObjectURL(f.previewUrl); });
            this.files = [];
            this.error = '';
            this.$refs.fileInput.value = '';
        }
    }"
>
    @if($label)
        <label class="aura-label">{{ $label }}</label>
    @endif

    <div
        class="aura-file-upload-zone"
        x-bind:class="{
            'aura-file-upload-dragging': dragging,
            'aura-file-upload-disabled': {{ $disabled ? 'true' : 'false' }},
            'aura-file-upload-error': error || '{{ $error }}'
        }"
        x-on:dragover.prevent="dragging = true"
        x-on:dragleave.prevent="dragging = false"
        x-on:drop.prevent="handleDrop($event)"
        x-on:click="if (!{{ $disabled ? 'true' : 'false' }}) $refs.fileInput.click()"
        role="button"
        tabindex="0"
        x-on:keydown.enter="$refs.fileInput.click()"
        x-on:keydown.space.prevent="$refs.fileInput.click()"
    >
        <input
            type="file"
            x-ref="fileInput"
            class="aura-file-upload-input"
            @if($accept) accept="{{ $accept }}" @endif
            @if($multiple) multiple @endif
            @if($disabled) disabled @endif
            x-on:change="handleSelect($event)"
            {{ $attributes->wire('model') }}
        />

        <div x-show="files.length === 0" class="aura-file-upload-placeholder">
            @if($slot->isNotEmpty())
                {{ $slot }}
            @else
                <x-aura::icon name="upload-cloud" size="xl" class="aura-file-upload-icon" />
                <p class="aura-file-upload-text">Trascina qui o clicca per selezionare</p>
                @if($maxSize)
                    <p class="aura-file-upload-hint">Max {{ $maxSize }}</p>
                @endif
            @endif
        </div>
    </div>

    {{-- File list --}}
    <div x-show="files.length > 0" class="aura-file-upload-list">
        <template x-for="(file, idx) in files" :key="idx">
            <div class="aura-file-upload-item">
                <template x-if="file.previewUrl">
                    <img x-bind:src="file.previewUrl" class="aura-file-upload-preview" x-bind:alt="file.name" />
                </template>
                <template x-if="!file.previewUrl">
                    <div class="aura-file-upload-file-icon">
                        <x-aura::icon name="file" size="sm" />
                    </div>
                </template>
                <div class="aura-file-upload-info">
                    <span class="aura-file-upload-name" x-text="file.name"></span>
                    <span class="aura-file-upload-size" x-text="file.size"></span>
                </div>
                <button type="button" class="aura-file-upload-remove" x-on:click.stop="removeFile(idx)" aria-label="Rimuovi">
                    <x-aura::icon name="x" size="xs" />
                </button>
            </div>
        </template>
    </div>

    {{-- JS error --}}
    <p x-show="error" x-text="error" class="aura-input-error-text"></p>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
