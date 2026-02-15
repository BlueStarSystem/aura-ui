<section id="select" class="aura-playground-section">
    <h2 class="aura-section-title">Select</h2>

    <h3 class="aura-section-subtitle">Default</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper">
            <select class="aura-select">
                <option value="" disabled selected>Seleziona un paese...</option>
                <option value="it">Italia</option>
                <option value="de">Germania</option>
                <option value="fr">Francia</option>
                <option value="es">Spagna</option>
            </select>
        </div>
    </div>

    <h3 class="aura-section-subtitle">With Label</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper">
            <label class="aura-input-label">Paese <span class="aura-required">*</span></label>
            <select class="aura-select">
                <option value="" disabled selected>Seleziona...</option>
                <option value="it">Italia</option>
                <option value="de">Germania</option>
                <option value="fr">Francia</option>
                <option value="es">Spagna</option>
            </select>
            <span class="aura-input-hint">Seleziona il paese di residenza.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Error State</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper aura-has-error">
            <label class="aura-input-label">Categoria <span class="aura-required">*</span></label>
            <select class="aura-select">
                <option value="" disabled selected>Seleziona...</option>
                <option value="1">Elettronica</option>
                <option value="2">Abbigliamento</option>
                <option value="3">Casa e Giardino</option>
            </select>
            <span class="aura-input-error">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                Seleziona una categoria.
            </span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Disabled</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper">
            <label class="aura-input-label">Lingua</label>
            <select class="aura-select" disabled>
                <option value="it" selected>Italiano</option>
                <option value="en">English</option>
            </select>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Sizes</h3>
    <div class="aura-component-row aura-items-center">
        <div class="aura-input-wrapper aura-input-sm">
            <select class="aura-select">
                <option value="" disabled selected>Small</option>
                <option value="it">Italia</option>
                <option value="de">Germania</option>
            </select>
        </div>
        <div class="aura-input-wrapper">
            <select class="aura-select">
                <option value="" disabled selected>Medium (default)</option>
                <option value="it">Italia</option>
                <option value="de">Germania</option>
            </select>
        </div>
        <div class="aura-input-wrapper aura-input-lg">
            <select class="aura-select">
                <option value="" disabled selected>Large</option>
                <option value="it">Italia</option>
                <option value="de">Germania</option>
            </select>
        </div>
    </div>
</section>
