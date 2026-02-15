<section id="time-picker" class="aura-playground-section">
    <h2 class="aura-section-title">TimePicker</h2>

    <h3 class="aura-section-subtitle">Basic (step 15 min)</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: '',
            search: '',
            slots: [],

            init() {
                for (let m = 0; m <= 23 * 60 + 45; m += 15) {
                    let h = Math.floor(m / 60);
                    let mi = m % 60;
                    this.slots.push(String(h).padStart(2,'0') + ':' + String(mi).padStart(2,'0'));
                }
            },

            get filteredSlots() {
                if (!this.search) return this.slots;
                return this.slots.filter(s => s.includes(this.search));
            },

            select(time) { this.value = time; this.open = false; this.search = ''; },
            clear() { this.value = ''; this.open = false; }
        }" x-on:click.outside="open = false" class="aura-timepicker-wrapper" style="position: relative;">
            <label class="aura-label">Orario</label>
            <div class="aura-timepicker-input-wrap">
                <input type="text" class="aura-input aura-timepicker-input" x-bind:value="value" placeholder="HH:MM" readonly x-on:click="open = !open" />
                <div class="aura-datepicker-icons">
                    <button type="button" class="aura-datepicker-clear" x-show="value" x-on:click.stop="clear()" aria-label="Cancella">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                    <span class="aura-datepicker-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </span>
                </div>
            </div>
            <div class="aura-timepicker-dropdown aura-glass" x-show="open" x-transition x-cloak>
                <div class="aura-timepicker-search">
                    <input type="text" class="aura-input aura-input-sm" placeholder="Filtra..." x-model="search" x-on:click.stop />
                </div>
                <div class="aura-timepicker-list">
                    <template x-for="slot in filteredSlots" :key="slot">
                        <button type="button" class="aura-timepicker-option"
                            x-text="slot"
                            x-bind:class="{ 'aura-timepicker-option-selected': value === slot }"
                            x-on:click="select(slot)"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Custom Step (30 min)</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: '',
            search: '',
            slots: [],

            init() {
                for (let m = 0; m <= 23 * 60 + 30; m += 30) {
                    let h = Math.floor(m / 60);
                    let mi = m % 60;
                    this.slots.push(String(h).padStart(2,'0') + ':' + String(mi).padStart(2,'0'));
                }
            },

            get filteredSlots() {
                if (!this.search) return this.slots;
                return this.slots.filter(s => s.includes(this.search));
            },

            select(time) { this.value = time; this.open = false; this.search = ''; },
            clear() { this.value = ''; this.open = false; }
        }" x-on:click.outside="open = false" class="aura-timepicker-wrapper" style="position: relative;">
            <label class="aura-label">Orario (ogni 30 min)</label>
            <div class="aura-timepicker-input-wrap">
                <input type="text" class="aura-input aura-timepicker-input" x-bind:value="value" placeholder="HH:MM" readonly x-on:click="open = !open" />
                <div class="aura-datepicker-icons">
                    <button type="button" class="aura-datepicker-clear" x-show="value" x-on:click.stop="clear()" aria-label="Cancella">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                    <span class="aura-datepicker-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </span>
                </div>
            </div>
            <div class="aura-timepicker-dropdown aura-glass" x-show="open" x-transition x-cloak>
                <div class="aura-timepicker-search">
                    <input type="text" class="aura-input aura-input-sm" placeholder="Filtra..." x-model="search" x-on:click.stop />
                </div>
                <div class="aura-timepicker-list">
                    <template x-for="slot in filteredSlots" :key="slot">
                        <button type="button" class="aura-timepicker-option"
                            x-text="slot"
                            x-bind:class="{ 'aura-timepicker-option-selected': value === slot }"
                            x-on:click="select(slot)"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Min / Max Range (09:00 - 18:00)</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: '',
            search: '',
            slots: [],

            init() {
                for (let m = 9 * 60; m <= 18 * 60; m += 15) {
                    let h = Math.floor(m / 60);
                    let mi = m % 60;
                    this.slots.push(String(h).padStart(2,'0') + ':' + String(mi).padStart(2,'0'));
                }
            },

            get filteredSlots() {
                if (!this.search) return this.slots;
                return this.slots.filter(s => s.includes(this.search));
            },

            select(time) { this.value = time; this.open = false; this.search = ''; },
            clear() { this.value = ''; this.open = false; }
        }" x-on:click.outside="open = false" class="aura-timepicker-wrapper" style="position: relative;">
            <label class="aura-label">Orario lavorativo</label>
            <div class="aura-timepicker-input-wrap">
                <input type="text" class="aura-input aura-timepicker-input" x-bind:value="value" placeholder="HH:MM" readonly x-on:click="open = !open" />
                <div class="aura-datepicker-icons">
                    <button type="button" class="aura-datepicker-clear" x-show="value" x-on:click.stop="clear()" aria-label="Cancella">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                    <span class="aura-datepicker-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </span>
                </div>
            </div>
            <div class="aura-timepicker-dropdown aura-glass" x-show="open" x-transition x-cloak>
                <div class="aura-timepicker-search">
                    <input type="text" class="aura-input aura-input-sm" placeholder="Filtra..." x-model="search" x-on:click.stop />
                </div>
                <div class="aura-timepicker-list">
                    <template x-for="slot in filteredSlots" :key="slot">
                        <button type="button" class="aura-timepicker-option"
                            x-text="slot"
                            x-bind:class="{ 'aura-timepicker-option-selected': value === slot }"
                            x-on:click="select(slot)"
                        ></button>
                    </template>
                </div>
            </div>
            <span class="aura-input-hint">Solo orari tra le 09:00 e le 18:00.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Disabled</h3>
    <div class="aura-component-row">
        <div class="aura-timepicker-wrapper">
            <label class="aura-label">Orario (disabilitato)</label>
            <div class="aura-timepicker-input-wrap">
                <input type="text" class="aura-input aura-timepicker-input aura-input-disabled" value="14:30" placeholder="HH:MM" readonly disabled />
                <div class="aura-datepicker-icons">
                    <span class="aura-datepicker-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
