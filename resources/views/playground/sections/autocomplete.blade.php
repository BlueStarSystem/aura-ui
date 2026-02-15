<section id="autocomplete" class="aura-playground-section">
    <h2 class="aura-section-title">Autocomplete</h2>

    <h3 class="aura-section-subtitle">Basic</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: '',
            search: '',
            highlightIndex: -1,
            options: [
                { label: 'Italia', value: 'it' },
                { label: 'Germania', value: 'de' },
                { label: 'Francia', value: 'fr' },
                { label: 'Spagna', value: 'es' },
                { label: 'Portogallo', value: 'pt' },
                { label: 'Irlanda', value: 'ie' },
                { label: 'Inghilterra', value: 'gb' },
                { label: 'Islanda', value: 'is' },
            ],

            get filtered() {
                if (!this.search) return this.options;
                let q = this.search.toLowerCase();
                return this.options.filter(o => o.label.toLowerCase().includes(q));
            },

            select(opt) { this.value = opt.value; this.search = opt.label; this.open = false; this.highlightIndex = -1; },
            clear() { this.value = ''; this.search = ''; this.open = false; this.highlightIndex = -1; },

            onInput() {
                this.open = true;
                this.highlightIndex = -1;
                if (this.search === '') this.value = '';
            },

            onKeydown(e) {
                if (!this.open) return;
                let items = this.filtered;
                if (e.key === 'ArrowDown') { e.preventDefault(); this.highlightIndex = Math.min(this.highlightIndex + 1, items.length - 1); }
                else if (e.key === 'ArrowUp') { e.preventDefault(); this.highlightIndex = Math.max(this.highlightIndex - 1, 0); }
                else if (e.key === 'Enter' && this.highlightIndex >= 0) { e.preventDefault(); this.select(items[this.highlightIndex]); }
            }
        }" x-on:click.outside="open = false" class="aura-autocomplete-wrapper" style="position: relative;">
            <label class="aura-label">Paese</label>
            <div class="aura-autocomplete-input-wrap">
                <input type="text" class="aura-input" x-model="search" x-on:input="onInput()" x-on:focus="open = true" x-on:keydown="onKeydown($event)" placeholder="Cerca un paese..." autocomplete="off" />
                <div class="aura-datepicker-icons">
                    <button type="button" class="aura-datepicker-clear" x-show="value" x-on:click.stop="clear()" aria-label="Cancella">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
            </div>
            <div class="aura-autocomplete-dropdown aura-glass" x-show="open && filtered.length > 0" x-transition x-cloak>
                <template x-for="(opt, idx) in filtered" :key="opt.value">
                    <button type="button" class="aura-autocomplete-option"
                        x-text="opt.label"
                        x-bind:class="{
                            'aura-autocomplete-option-selected': value === opt.value,
                            'aura-autocomplete-option-highlighted': highlightIndex === idx,
                        }"
                        x-on:click="select(opt)"
                    ></button>
                </template>
            </div>
            <div class="aura-autocomplete-dropdown aura-glass" x-show="open && search.length > 0 && filtered.length === 0" x-cloak>
                <div class="aura-autocomplete-no-results">Nessun risultato</div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Clearable with Hint</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: 'it',
            search: 'Italia',
            highlightIndex: -1,
            options: [
                { label: 'Italia', value: 'it' },
                { label: 'Germania', value: 'de' },
                { label: 'Francia', value: 'fr' },
                { label: 'Spagna', value: 'es' },
                { label: 'Portogallo', value: 'pt' },
            ],

            get filtered() {
                if (!this.search) return this.options;
                let q = this.search.toLowerCase();
                return this.options.filter(o => o.label.toLowerCase().includes(q));
            },

            select(opt) { this.value = opt.value; this.search = opt.label; this.open = false; this.highlightIndex = -1; },
            clear() { this.value = ''; this.search = ''; this.open = false; this.highlightIndex = -1; },

            onInput() {
                this.open = true;
                this.highlightIndex = -1;
                if (this.search === '') this.value = '';
            },

            onKeydown(e) {
                if (!this.open) return;
                let items = this.filtered;
                if (e.key === 'ArrowDown') { e.preventDefault(); this.highlightIndex = Math.min(this.highlightIndex + 1, items.length - 1); }
                else if (e.key === 'ArrowUp') { e.preventDefault(); this.highlightIndex = Math.max(this.highlightIndex - 1, 0); }
                else if (e.key === 'Enter' && this.highlightIndex >= 0) { e.preventDefault(); this.select(items[this.highlightIndex]); }
            }
        }" x-on:click.outside="open = false" class="aura-autocomplete-wrapper" style="position: relative;">
            <label class="aura-label">Paese (preselezionato)</label>
            <div class="aura-autocomplete-input-wrap">
                <input type="text" class="aura-input" x-model="search" x-on:input="onInput()" x-on:focus="open = true" x-on:keydown="onKeydown($event)" placeholder="Cerca un paese..." autocomplete="off" />
                <div class="aura-datepicker-icons">
                    <button type="button" class="aura-datepicker-clear" x-show="value" x-on:click.stop="clear()" aria-label="Cancella">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
            </div>
            <div class="aura-autocomplete-dropdown aura-glass" x-show="open && filtered.length > 0" x-transition x-cloak>
                <template x-for="(opt, idx) in filtered" :key="opt.value">
                    <button type="button" class="aura-autocomplete-option"
                        x-text="opt.label"
                        x-bind:class="{
                            'aura-autocomplete-option-selected': value === opt.value,
                            'aura-autocomplete-option-highlighted': highlightIndex === idx,
                        }"
                        x-on:click="select(opt)"
                    ></button>
                </template>
            </div>
            <span class="aura-input-hint">Clicca la X per cancellare la selezione.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Min 2 Characters</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: '',
            search: '',
            highlightIndex: -1,
            minChars: 2,
            options: [
                { label: 'React', value: 'react' },
                { label: 'Vue.js', value: 'vue' },
                { label: 'Angular', value: 'angular' },
                { label: 'Svelte', value: 'svelte' },
                { label: 'Alpine.js', value: 'alpine' },
                { label: 'Laravel', value: 'laravel' },
                { label: 'Livewire', value: 'livewire' },
            ],

            get filtered() {
                if (this.search.length < this.minChars) return [];
                let q = this.search.toLowerCase();
                return this.options.filter(o => o.label.toLowerCase().includes(q));
            },

            select(opt) { this.value = opt.value; this.search = opt.label; this.open = false; this.highlightIndex = -1; },
            clear() { this.value = ''; this.search = ''; this.open = false; this.highlightIndex = -1; },

            onInput() {
                this.open = this.search.length >= this.minChars;
                this.highlightIndex = -1;
                if (this.search === '') this.value = '';
            },

            onKeydown(e) {
                if (!this.open) return;
                let items = this.filtered;
                if (e.key === 'ArrowDown') { e.preventDefault(); this.highlightIndex = Math.min(this.highlightIndex + 1, items.length - 1); }
                else if (e.key === 'ArrowUp') { e.preventDefault(); this.highlightIndex = Math.max(this.highlightIndex - 1, 0); }
                else if (e.key === 'Enter' && this.highlightIndex >= 0) { e.preventDefault(); this.select(items[this.highlightIndex]); }
            }
        }" x-on:click.outside="open = false" class="aura-autocomplete-wrapper" style="position: relative;">
            <label class="aura-label">Framework (min 2 caratteri)</label>
            <div class="aura-autocomplete-input-wrap">
                <input type="text" class="aura-input" x-model="search" x-on:input="onInput()" x-on:focus="if (search.length >= minChars) open = true" x-on:keydown="onKeydown($event)" placeholder="Cerca un framework..." autocomplete="off" />
                <div class="aura-datepicker-icons">
                    <button type="button" class="aura-datepicker-clear" x-show="value" x-on:click.stop="clear()" aria-label="Cancella">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
            </div>
            <div class="aura-autocomplete-dropdown aura-glass" x-show="open && filtered.length > 0" x-transition x-cloak>
                <template x-for="(opt, idx) in filtered" :key="opt.value">
                    <button type="button" class="aura-autocomplete-option"
                        x-text="opt.label"
                        x-bind:class="{
                            'aura-autocomplete-option-selected': value === opt.value,
                            'aura-autocomplete-option-highlighted': highlightIndex === idx,
                        }"
                        x-on:click="select(opt)"
                    ></button>
                </template>
            </div>
            <div class="aura-autocomplete-dropdown aura-glass" x-show="open && search.length >= minChars && filtered.length === 0" x-cloak>
                <div class="aura-autocomplete-no-results">Nessun risultato</div>
            </div>
            <span class="aura-input-hint">Inizia a digitare almeno 2 caratteri per vedere i suggerimenti.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Error State</h3>
    <div class="aura-component-row">
        <div class="aura-autocomplete-wrapper">
            <label class="aura-label">Categoria <span class="aura-required">*</span></label>
            <div class="aura-autocomplete-input-wrap">
                <input type="text" class="aura-input aura-input-error" placeholder="Cerca una categoria..." autocomplete="off" />
            </div>
            <span class="aura-input-error-text">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                Seleziona una categoria valida.
            </span>
        </div>
    </div>
</section>
