<section id="inputs" class="aura-playground-section">
    <h2 class="aura-section-title">Input</h2>

    <h3 class="aura-section-subtitle">Default</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper">
            <input type="text" class="aura-input" placeholder="Inserisci testo...">
        </div>
    </div>

    <h3 class="aura-section-subtitle">With Label</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper">
            <label class="aura-input-label">Nome <span class="aura-required">*</span></label>
            <input type="text" class="aura-input" placeholder="Mario Rossi">
        </div>
        <div class="aura-input-wrapper">
            <label class="aura-input-label">Email</label>
            <input type="email" class="aura-input" placeholder="mario@esempio.it">
        </div>
    </div>

    <h3 class="aura-section-subtitle">With Hint</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper">
            <label class="aura-input-label">Password</label>
            <input type="password" class="aura-input" placeholder="Inserisci password">
            <span class="aura-input-hint">Minimo 8 caratteri, almeno un numero e un simbolo.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Error State</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper aura-has-error">
            <label class="aura-input-label">Email <span class="aura-required">*</span></label>
            <input type="email" class="aura-input" value="indirizzo-non-valido">
            <span class="aura-input-error">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                Inserisci un indirizzo email valido.
            </span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Prefix & Suffix</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper">
            <label class="aura-input-label">Sito web</label>
            <div class="aura-input-group">
                <span class="aura-input-prefix">https://</span>
                <input type="text" class="aura-input" placeholder="www.esempio.it">
            </div>
        </div>
        <div class="aura-input-wrapper">
            <label class="aura-input-label">Importo</label>
            <div class="aura-input-group">
                <input type="number" class="aura-input" placeholder="0.00">
                <span class="aura-input-suffix">EUR</span>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Sizes</h3>
    <div class="aura-component-row aura-items-center">
        <div class="aura-input-wrapper aura-input-sm">
            <input type="text" class="aura-input" placeholder="Small">
        </div>
        <div class="aura-input-wrapper">
            <input type="text" class="aura-input" placeholder="Medium (default)">
        </div>
        <div class="aura-input-wrapper aura-input-lg">
            <input type="text" class="aura-input" placeholder="Large">
        </div>
    </div>

    <h3 class="aura-section-subtitle">Disabled & Readonly</h3>
    <div class="aura-component-row">
        <div class="aura-input-wrapper">
            <label class="aura-input-label">Disabled</label>
            <input type="text" class="aura-input" placeholder="Non modificabile" disabled>
        </div>
        <div class="aura-input-wrapper">
            <label class="aura-input-label">Readonly</label>
            <input type="text" class="aura-input" value="Valore di sola lettura" readonly>
        </div>
    </div>
</section>
