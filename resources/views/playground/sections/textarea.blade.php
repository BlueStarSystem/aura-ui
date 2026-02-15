<section id="textarea" class="aura-playground-section">
    <h2 class="aura-section-title">Textarea</h2>

    <h3 class="aura-section-subtitle">Default</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper aura-max-w-lg">
            <textarea class="aura-textarea" placeholder="Scrivi qualcosa..."></textarea>
        </div>
    </div>

    <h3 class="aura-section-subtitle">With Label & Hint</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper aura-max-w-lg">
            <label class="aura-input-label">Descrizione <span class="aura-required">*</span></label>
            <textarea class="aura-textarea" placeholder="Inserisci una descrizione dettagliata..." rows="4"></textarea>
            <span class="aura-input-hint">Descrivi il prodotto in modo chiaro e completo.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Error State</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper aura-has-error aura-max-w-lg">
            <label class="aura-input-label">Note <span class="aura-required">*</span></label>
            <textarea class="aura-textarea" rows="3"></textarea>
            <span class="aura-input-error">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                Il campo note e' obbligatorio.
            </span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">With Character Count</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper aura-max-w-lg" x-data="{ count: 0, max: 200 }">
            <label class="aura-input-label">Messaggio</label>
            <textarea class="aura-textarea" placeholder="Scrivi il tuo messaggio..." rows="3" :maxlength="max" x-on:input="count = $event.target.value.length"></textarea>
            <span class="aura-input-hint"><span x-text="count">0</span>/<span x-text="max">200</span></span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Sizes</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper aura-input-sm aura-max-w-md">
            <label class="aura-input-label">Small</label>
            <textarea class="aura-textarea" placeholder="Textarea piccola..." rows="2"></textarea>
        </div>
        <div class="aura-input-wrapper aura-input-lg aura-max-w-md">
            <label class="aura-input-label">Large</label>
            <textarea class="aura-textarea" placeholder="Textarea grande..." rows="2"></textarea>
        </div>
    </div>
</section>
