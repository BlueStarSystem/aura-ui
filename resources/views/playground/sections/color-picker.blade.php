<section id="color-picker" class="aura-playground-section">
    <h2 class="aura-section-title">ColorPicker</h2>

    <h3 class="aura-section-subtitle">Basic</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: '#6366f1',
            hexInput: '#6366f1',
            swatches: ['#6366f1','#06b6d4','#10b981','#f59e0b','#ef4444','#ec4899','#8b5cf6','#000000','#ffffff'],

            selectSwatch(color) { this.value = color; this.hexInput = color; },

            onHexInput() {
                let hex = this.hexInput.trim();
                if (/^#[0-9a-fA-F]{6}$/.test(hex) || /^#[0-9a-fA-F]{3}$/.test(hex)) {
                    this.value = hex;
                }
            },

            clear() { this.value = ''; this.hexInput = ''; }
        }" x-on:click.outside="open = false" class="aura-color-picker-wrapper" style="position: relative;">
            <label class="aura-label">Colore primario</label>
            <div class="aura-color-picker-trigger">
                <button type="button" class="aura-color-picker-button aura-input" x-on:click="open = !open">
                    <span class="aura-color-swatch-preview" x-bind:style="value ? 'background-color: ' + value : ''"></span>
                    <span class="aura-color-value" x-text="value || 'Seleziona colore'"></span>
                </button>
            </div>
            <div class="aura-color-picker-dropdown aura-glass" x-show="open" x-transition x-cloak>
                <div class="aura-color-swatches">
                    <template x-for="swatch in swatches" :key="swatch">
                        <button type="button" class="aura-color-swatch"
                            x-bind:style="'background-color: ' + swatch"
                            x-on:click="selectSwatch(swatch)"
                            x-bind:class="{ 'aura-color-swatch-active': value === swatch }"
                            x-bind:title="swatch"
                        ></button>
                    </template>
                </div>
                <div class="aura-color-hex-input">
                    <span class="aura-color-swatch-preview aura-color-swatch-sm" x-bind:style="'background-color: ' + hexInput"></span>
                    <input type="text" class="aura-input aura-input-sm" x-model="hexInput" x-on:input="onHexInput()" placeholder="#000000" maxlength="7" />
                </div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Custom Swatches (Brand Colors)</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: '#1877F2',
            hexInput: '#1877F2',
            swatches: ['#1877F2','#1DA1F2','#E4405F','#FF0000','#0A66C2','#25D366','#FF6900','#7B68EE','#2ECC71','#E74C3C','#9B59B6','#F39C12'],

            selectSwatch(color) { this.value = color; this.hexInput = color; },

            onHexInput() {
                let hex = this.hexInput.trim();
                if (/^#[0-9a-fA-F]{6}$/.test(hex) || /^#[0-9a-fA-F]{3}$/.test(hex)) {
                    this.value = hex;
                }
            },

            clear() { this.value = ''; this.hexInput = ''; }
        }" x-on:click.outside="open = false" class="aura-color-picker-wrapper" style="position: relative;">
            <label class="aura-label">Colore brand</label>
            <div class="aura-color-picker-trigger">
                <button type="button" class="aura-color-picker-button aura-input" x-on:click="open = !open">
                    <span class="aura-color-swatch-preview" x-bind:style="value ? 'background-color: ' + value : ''"></span>
                    <span class="aura-color-value" x-text="value || 'Seleziona colore'"></span>
                </button>
            </div>
            <div class="aura-color-picker-dropdown aura-glass" x-show="open" x-transition x-cloak>
                <div class="aura-color-swatches">
                    <template x-for="swatch in swatches" :key="swatch">
                        <button type="button" class="aura-color-swatch"
                            x-bind:style="'background-color: ' + swatch"
                            x-on:click="selectSwatch(swatch)"
                            x-bind:class="{ 'aura-color-swatch-active': value === swatch }"
                            x-bind:title="swatch"
                        ></button>
                    </template>
                </div>
                <div class="aura-color-hex-input">
                    <span class="aura-color-swatch-preview aura-color-swatch-sm" x-bind:style="'background-color: ' + hexInput"></span>
                    <input type="text" class="aura-input aura-input-sm" x-model="hexInput" x-on:input="onHexInput()" placeholder="#000000" maxlength="7" />
                </div>
            </div>
            <span class="aura-input-hint">Palette personalizzata con colori brand social.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Without Preselection</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: '',
            hexInput: '',
            swatches: ['#6366f1','#06b6d4','#10b981','#f59e0b','#ef4444','#ec4899','#8b5cf6','#000000','#ffffff'],

            selectSwatch(color) { this.value = color; this.hexInput = color; },

            onHexInput() {
                let hex = this.hexInput.trim();
                if (/^#[0-9a-fA-F]{6}$/.test(hex) || /^#[0-9a-fA-F]{3}$/.test(hex)) {
                    this.value = hex;
                }
            },

            clear() { this.value = ''; this.hexInput = ''; }
        }" x-on:click.outside="open = false" class="aura-color-picker-wrapper" style="position: relative;">
            <label class="aura-label">Sfondo</label>
            <div class="aura-color-picker-trigger">
                <button type="button" class="aura-color-picker-button aura-input" x-on:click="open = !open">
                    <span class="aura-color-swatch-preview" x-bind:style="value ? 'background-color: ' + value : ''"></span>
                    <span class="aura-color-value" x-text="value || 'Seleziona colore'"></span>
                </button>
            </div>
            <div class="aura-color-picker-dropdown aura-glass" x-show="open" x-transition x-cloak>
                <div class="aura-color-swatches">
                    <template x-for="swatch in swatches" :key="swatch">
                        <button type="button" class="aura-color-swatch"
                            x-bind:style="'background-color: ' + swatch"
                            x-on:click="selectSwatch(swatch)"
                            x-bind:class="{ 'aura-color-swatch-active': value === swatch }"
                            x-bind:title="swatch"
                        ></button>
                    </template>
                </div>
                <div class="aura-color-hex-input">
                    <span class="aura-color-swatch-preview aura-color-swatch-sm" x-bind:style="'background-color: ' + (hexInput || 'transparent')"></span>
                    <input type="text" class="aura-input aura-input-sm" x-model="hexInput" x-on:input="onHexInput()" placeholder="#000000" maxlength="7" />
                </div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Disabled</h3>
    <div class="aura-component-row">
        <div class="aura-color-picker-wrapper">
            <label class="aura-label">Colore (disabilitato)</label>
            <div class="aura-color-picker-trigger">
                <button type="button" class="aura-color-picker-button aura-input aura-input-disabled" disabled>
                    <span class="aura-color-swatch-preview" style="background-color: #6366f1;"></span>
                    <span class="aura-color-value">#6366f1</span>
                </button>
            </div>
        </div>
    </div>
</section>
