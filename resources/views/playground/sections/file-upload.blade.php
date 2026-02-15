<section id="file-upload" class="aura-playground-section">
    <h2 class="aura-section-title">FileUpload</h2>

    <h3 class="aura-section-subtitle">Basic</h3>
    <div class="aura-component-row">
        <div x-data="{
            dragging: false,
            files: [],

            handleSelect(e) {
                for (let f of e.target.files) {
                    this.files.push({ name: f.name, size: this.formatSize(f.size), type: f.type, previewUrl: null });
                }
            },

            removeFile(idx) { this.files.splice(idx, 1); },

            formatSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
            }
        }" class="aura-file-upload-wrapper">
            <label class="aura-label">Documento</label>
            <div class="aura-file-upload-zone"
                x-bind:class="{ 'aura-file-upload-dragging': dragging }"
                x-on:dragover.prevent="dragging = true"
                x-on:dragleave.prevent="dragging = false"
                x-on:drop.prevent="dragging = false"
                x-on:click="$refs.input.click()"
            >
                <input type="file" x-ref="input" style="display: none;" x-on:change="handleSelect($event)" />
                <div x-show="files.length === 0" class="aura-file-upload-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="aura-file-upload-icon"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/></svg>
                    <p class="aura-file-upload-text">Trascina qui o clicca per selezionare</p>
                </div>
            </div>
            <div x-show="files.length > 0" class="aura-file-upload-list">
                <template x-for="(file, idx) in files" :key="idx">
                    <div class="aura-file-upload-item">
                        <div class="aura-file-upload-file-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                        </div>
                        <div class="aura-file-upload-info">
                            <span class="aura-file-upload-name" x-text="file.name"></span>
                            <span class="aura-file-upload-size" x-text="file.size"></span>
                        </div>
                        <button type="button" class="aura-file-upload-remove" x-on:click.stop="removeFile(idx)" aria-label="Rimuovi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Image with Preview</h3>
    <div class="aura-component-row">
        <div x-data="{
            dragging: false,
            files: [],

            handleSelect(e) {
                for (let f of e.target.files) {
                    let entry = { name: f.name, size: this.formatSize(f.size), type: f.type, previewUrl: null };
                    if (f.type.startsWith('image/')) {
                        entry.previewUrl = URL.createObjectURL(f);
                    }
                    this.files.push(entry);
                }
            },

            removeFile(idx) {
                if (this.files[idx].previewUrl) URL.revokeObjectURL(this.files[idx].previewUrl);
                this.files.splice(idx, 1);
            },

            formatSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
            }
        }" class="aura-file-upload-wrapper">
            <label class="aura-label">Immagine profilo</label>
            <div class="aura-file-upload-zone"
                x-bind:class="{ 'aura-file-upload-dragging': dragging }"
                x-on:dragover.prevent="dragging = true"
                x-on:dragleave.prevent="dragging = false"
                x-on:drop.prevent="dragging = false"
                x-on:click="$refs.input.click()"
            >
                <input type="file" x-ref="input" accept="image/*" style="display: none;" x-on:change="handleSelect($event)" />
                <div x-show="files.length === 0" class="aura-file-upload-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="aura-file-upload-icon"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <p class="aura-file-upload-text">Trascina un'immagine o clicca per selezionare</p>
                    <p class="aura-file-upload-hint">Accetta: JPG, PNG, GIF, WebP</p>
                </div>
            </div>
            <div x-show="files.length > 0" class="aura-file-upload-list">
                <template x-for="(file, idx) in files" :key="idx">
                    <div class="aura-file-upload-item">
                        <template x-if="file.previewUrl">
                            <img x-bind:src="file.previewUrl" class="aura-file-upload-preview" x-bind:alt="file.name" />
                        </template>
                        <div class="aura-file-upload-info">
                            <span class="aura-file-upload-name" x-text="file.name"></span>
                            <span class="aura-file-upload-size" x-text="file.size"></span>
                        </div>
                        <button type="button" class="aura-file-upload-remove" x-on:click.stop="removeFile(idx)" aria-label="Rimuovi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Max Size (2 MB)</h3>
    <div class="aura-component-row">
        <div x-data="{
            dragging: false,
            files: [],
            error: '',
            maxBytes: 2 * 1024 * 1024,

            handleSelect(e) {
                this.error = '';
                for (let f of e.target.files) {
                    if (f.size > this.maxBytes) {
                        this.error = f.name + ' supera la dimensione massima (2 MB)';
                        continue;
                    }
                    this.files.push({ name: f.name, size: this.formatSize(f.size), type: f.type, previewUrl: null });
                }
            },

            removeFile(idx) { this.files.splice(idx, 1); },

            formatSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
            }
        }" class="aura-file-upload-wrapper">
            <label class="aura-label">Documento (max 2 MB)</label>
            <div class="aura-file-upload-zone"
                x-bind:class="{ 'aura-file-upload-dragging': dragging }"
                x-on:dragover.prevent="dragging = true"
                x-on:dragleave.prevent="dragging = false"
                x-on:drop.prevent="dragging = false"
                x-on:click="$refs.input.click()"
            >
                <input type="file" x-ref="input" style="display: none;" x-on:change="handleSelect($event)" />
                <div x-show="files.length === 0" class="aura-file-upload-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="aura-file-upload-icon"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/></svg>
                    <p class="aura-file-upload-text">Trascina qui o clicca per selezionare</p>
                    <p class="aura-file-upload-hint">Max 2 MB</p>
                </div>
            </div>
            <p x-show="error" x-text="error" class="aura-input-error-text"></p>
            <div x-show="files.length > 0" class="aura-file-upload-list">
                <template x-for="(file, idx) in files" :key="idx">
                    <div class="aura-file-upload-item">
                        <div class="aura-file-upload-file-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                        </div>
                        <div class="aura-file-upload-info">
                            <span class="aura-file-upload-name" x-text="file.name"></span>
                            <span class="aura-file-upload-size" x-text="file.size"></span>
                        </div>
                        <button type="button" class="aura-file-upload-remove" x-on:click.stop="removeFile(idx)" aria-label="Rimuovi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Multiple Files</h3>
    <div class="aura-component-row">
        <div x-data="{
            dragging: false,
            files: [],

            handleSelect(e) {
                for (let f of e.target.files) {
                    this.files.push({ name: f.name, size: this.formatSize(f.size), type: f.type, previewUrl: null });
                }
            },

            removeFile(idx) { this.files.splice(idx, 1); },
            clear() { this.files = []; },

            formatSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
            }
        }" class="aura-file-upload-wrapper">
            <label class="aura-label">Allegati (multipli)</label>
            <div class="aura-file-upload-zone"
                x-bind:class="{ 'aura-file-upload-dragging': dragging }"
                x-on:dragover.prevent="dragging = true"
                x-on:dragleave.prevent="dragging = false"
                x-on:drop.prevent="dragging = false"
                x-on:click="$refs.input.click()"
            >
                <input type="file" x-ref="input" multiple style="display: none;" x-on:change="handleSelect($event)" />
                <div class="aura-file-upload-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="aura-file-upload-icon"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/></svg>
                    <p class="aura-file-upload-text">Trascina i file qui o clicca per selezionare</p>
                    <p class="aura-file-upload-hint">Puoi selezionare piu' file contemporaneamente</p>
                </div>
            </div>
            <div x-show="files.length > 0" class="aura-file-upload-list">
                <template x-for="(file, idx) in files" :key="idx">
                    <div class="aura-file-upload-item">
                        <div class="aura-file-upload-file-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                        </div>
                        <div class="aura-file-upload-info">
                            <span class="aura-file-upload-name" x-text="file.name"></span>
                            <span class="aura-file-upload-size" x-text="file.size"></span>
                        </div>
                        <button type="button" class="aura-file-upload-remove" x-on:click.stop="removeFile(idx)" aria-label="Rimuovi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Disabled</h3>
    <div class="aura-component-row">
        <div class="aura-file-upload-wrapper">
            <label class="aura-label">Upload (disabilitato)</label>
            <div class="aura-file-upload-zone aura-file-upload-disabled">
                <div class="aura-file-upload-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="aura-file-upload-icon"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/></svg>
                    <p class="aura-file-upload-text">Upload non disponibile</p>
                </div>
            </div>
        </div>
    </div>
</section>
