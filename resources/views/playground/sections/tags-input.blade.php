<section id="tags-input" class="aura-playground-section">
    <h2 class="aura-section-title">TagsInput</h2>

    <h3 class="aura-section-subtitle">Basic</h3>
    <div class="aura-component-row">
        <div x-data="{
            tags: ['Laravel', 'PHP'],
            input: '',

            addTag(tag) {
                tag = tag.trim();
                if (!tag || this.tags.includes(tag)) return;
                this.tags.push(tag);
                this.input = '';
            },

            removeTag(idx) { this.tags.splice(idx, 1); },

            removeLast() { if (this.input === '' && this.tags.length > 0) this.tags.pop(); },

            onKeydown(e) {
                if (e.key === 'Enter') { e.preventDefault(); this.addTag(this.input); }
                else if (e.key === 'Backspace') { this.removeLast(); }
            }
        }" class="aura-tags-wrapper">
            <label class="aura-label">Competenze</label>
            <div class="aura-tags-container">
                <template x-for="(tag, idx) in tags" :key="idx">
                    <span class="aura-tag">
                        <span x-text="tag"></span>
                        <button type="button" class="aura-tag-remove" x-on:click="removeTag(idx)" aria-label="Rimuovi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </span>
                </template>
                <input type="text" class="aura-tags-input-field" x-model="input" x-on:keydown="onKeydown($event)" x-bind:placeholder="tags.length > 0 ? '' : 'Aggiungi tag...'" autocomplete="off" />
            </div>
            <span class="aura-input-hint">Premi Invio per aggiungere un tag. Backspace per rimuovere l'ultimo.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">With Suggestions</h3>
    <div class="aura-component-row">
        <div x-data="{
            tags: [],
            input: '',
            showSuggestions: false,
            highlightIndex: -1,
            suggestions: ['JavaScript', 'TypeScript', 'Python', 'PHP', 'Ruby', 'Go', 'Rust', 'Java', 'C#', 'Swift'],

            get filteredSuggestions() {
                if (!this.input) return [];
                let q = this.input.toLowerCase();
                return this.suggestions.filter(s => s.toLowerCase().includes(q) && !this.tags.includes(s));
            },

            addTag(tag) {
                tag = tag.trim();
                if (!tag || this.tags.includes(tag)) return;
                this.tags.push(tag);
                this.input = '';
                this.showSuggestions = false;
                this.highlightIndex = -1;
            },

            removeTag(idx) { this.tags.splice(idx, 1); },

            removeLast() { if (this.input === '' && this.tags.length > 0) this.tags.pop(); },

            onKeydown(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (this.highlightIndex >= 0 && this.filteredSuggestions[this.highlightIndex]) {
                        this.addTag(this.filteredSuggestions[this.highlightIndex]);
                    } else if (this.input) {
                        this.addTag(this.input);
                    }
                } else if (e.key === 'Backspace') {
                    this.removeLast();
                } else if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    this.highlightIndex = Math.min(this.highlightIndex + 1, this.filteredSuggestions.length - 1);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    this.highlightIndex = Math.max(this.highlightIndex - 1, 0);
                } else if (e.key === 'Escape') {
                    this.showSuggestions = false;
                }
            },

            onInput() {
                this.showSuggestions = this.input.length > 0 && this.filteredSuggestions.length > 0;
                this.highlightIndex = -1;
            }
        }" x-on:click.outside="showSuggestions = false" class="aura-tags-wrapper" style="position: relative;">
            <label class="aura-label">Linguaggi di programmazione</label>
            <div class="aura-tags-container">
                <template x-for="(tag, idx) in tags" :key="idx">
                    <span class="aura-tag">
                        <span x-text="tag"></span>
                        <button type="button" class="aura-tag-remove" x-on:click="removeTag(idx)" aria-label="Rimuovi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </span>
                </template>
                <input type="text" class="aura-tags-input-field" x-model="input" x-on:input="onInput()" x-on:keydown="onKeydown($event)" x-on:focus="if (input) showSuggestions = true" x-bind:placeholder="tags.length > 0 ? '' : 'Digita per suggerimenti...'" autocomplete="off" />
            </div>
            <div class="aura-tags-suggestions aura-glass" x-show="showSuggestions" x-transition x-cloak>
                <template x-for="(sug, idx) in filteredSuggestions" :key="sug">
                    <button type="button" class="aura-tags-suggestion"
                        x-text="sug"
                        x-bind:class="{ 'aura-tags-suggestion-highlighted': highlightIndex === idx }"
                        x-on:click="addTag(sug)"
                    ></button>
                </template>
            </div>
            <span class="aura-input-hint">Digita per vedere i suggerimenti. Puoi anche creare tag liberi.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">With Max (5 tags)</h3>
    <div class="aura-component-row">
        <div x-data="{
            tags: ['Design', 'UX', 'Frontend'],
            input: '',
            max: 5,

            get canAdd() { return this.tags.length < this.max; },

            addTag(tag) {
                tag = tag.trim();
                if (!tag || !this.canAdd || this.tags.includes(tag)) return;
                this.tags.push(tag);
                this.input = '';
            },

            removeTag(idx) { this.tags.splice(idx, 1); },

            removeLast() { if (this.input === '' && this.tags.length > 0) this.tags.pop(); },

            onKeydown(e) {
                if (e.key === 'Enter') { e.preventDefault(); this.addTag(this.input); }
                else if (e.key === 'Backspace') { this.removeLast(); }
            }
        }" class="aura-tags-wrapper">
            <label class="aura-label">Interessi (max 5)</label>
            <div class="aura-tags-container">
                <template x-for="(tag, idx) in tags" :key="idx">
                    <span class="aura-tag">
                        <span x-text="tag"></span>
                        <button type="button" class="aura-tag-remove" x-on:click="removeTag(idx)" aria-label="Rimuovi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </span>
                </template>
                <input type="text" class="aura-tags-input-field" x-model="input" x-on:keydown="onKeydown($event)" x-bind:placeholder="tags.length >= max ? 'Max raggiunto' : (tags.length > 0 ? '' : 'Aggiungi tag...')" x-bind:disabled="tags.length >= max" autocomplete="off" />
            </div>
            <p class="aura-tags-count" x-show="tags.length > 0">
                <span x-text="tags.length"></span>/<span x-text="max"></span>
            </p>
            <span class="aura-input-hint">Puoi aggiungere fino a 5 tag.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Disabled</h3>
    <div class="aura-component-row">
        <div class="aura-tags-wrapper">
            <label class="aura-label">Tag (disabilitato)</label>
            <div class="aura-tags-container aura-tags-disabled">
                <span class="aura-tag">
                    <span>Fisso</span>
                </span>
                <span class="aura-tag">
                    <span>Non modificabile</span>
                </span>
                <input type="text" class="aura-tags-input-field" placeholder="" disabled />
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Error State</h3>
    <div class="aura-component-row">
        <div class="aura-tags-wrapper">
            <label class="aura-label">Categorie <span class="aura-required">*</span></label>
            <div class="aura-tags-container" style="border-color: var(--aura-danger, #ef4444);">
                <input type="text" class="aura-tags-input-field aura-input-error" placeholder="Aggiungi almeno una categoria..." autocomplete="off" />
            </div>
            <span class="aura-input-error-text">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                Aggiungi almeno una categoria.
            </span>
        </div>
    </div>
</section>
