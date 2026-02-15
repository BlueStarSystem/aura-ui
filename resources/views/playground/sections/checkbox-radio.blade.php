<section id="checkbox-radio" class="aura-playground-section">
    <h2 class="aura-section-title">Checkbox & Radio</h2>

    <h3 class="aura-section-subtitle">Single Checkbox</h3>
    <div class="aura-component-col">
        <label class="aura-checkbox">
            <input type="checkbox">
            <span class="aura-checkbox-box">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span class="aura-checkbox-label">Accetto i termini e le condizioni</span>
        </label>
    </div>

    <h3 class="aura-section-subtitle">Checkbox with Description</h3>
    <div class="aura-component-col">
        <label class="aura-checkbox">
            <input type="checkbox" checked>
            <span class="aura-checkbox-box">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span class="aura-checkbox-content">
                <span class="aura-checkbox-label">Notifiche email</span>
                <span class="aura-checkbox-description">Ricevi aggiornamenti e promozioni via email.</span>
            </span>
        </label>
        <label class="aura-checkbox">
            <input type="checkbox">
            <span class="aura-checkbox-box">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span class="aura-checkbox-content">
                <span class="aura-checkbox-label">Notifiche SMS</span>
                <span class="aura-checkbox-description">Ricevi avvisi importanti tramite SMS.</span>
            </span>
        </label>
    </div>

    <h3 class="aura-section-subtitle">Checkbox Group</h3>
    <div class="aura-component-col">
        <label class="aura-checkbox">
            <input type="checkbox" checked>
            <span class="aura-checkbox-box">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span class="aura-checkbox-label">Design</span>
        </label>
        <label class="aura-checkbox">
            <input type="checkbox" checked>
            <span class="aura-checkbox-box">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span class="aura-checkbox-label">Sviluppo</span>
        </label>
        <label class="aura-checkbox">
            <input type="checkbox">
            <span class="aura-checkbox-box">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span class="aura-checkbox-label">Marketing</span>
        </label>
        <label class="aura-checkbox">
            <input type="checkbox">
            <span class="aura-checkbox-box">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span class="aura-checkbox-label">Vendite</span>
        </label>
    </div>

    <h3 class="aura-section-subtitle">Radio Group</h3>
    <div class="aura-radio-group">
        <label class="aura-radio">
            <input type="radio" name="plan" checked>
            <span class="aura-radio-circle">
                <span class="aura-radio-dot"></span>
            </span>
            <span class="aura-radio-label">Free</span>
        </label>
        <label class="aura-radio">
            <input type="radio" name="plan">
            <span class="aura-radio-circle">
                <span class="aura-radio-dot"></span>
            </span>
            <span class="aura-radio-label">Pro</span>
        </label>
        <label class="aura-radio">
            <input type="radio" name="plan">
            <span class="aura-radio-circle">
                <span class="aura-radio-dot"></span>
            </span>
            <span class="aura-radio-label">Enterprise</span>
        </label>
    </div>

    <h3 class="aura-section-subtitle">Radio with Descriptions</h3>
    <div class="aura-radio-group">
        <label class="aura-radio">
            <input type="radio" name="plan-desc" checked>
            <span class="aura-radio-circle">
                <span class="aura-radio-dot"></span>
            </span>
            <span class="aura-checkbox-content">
                <span class="aura-checkbox-label">Free</span>
                <span class="aura-checkbox-description">Fino a 5 progetti, 1 GB di spazio.</span>
            </span>
        </label>
        <label class="aura-radio">
            <input type="radio" name="plan-desc">
            <span class="aura-radio-circle">
                <span class="aura-radio-dot"></span>
            </span>
            <span class="aura-checkbox-content">
                <span class="aura-checkbox-label">Pro &mdash; 9,99 &euro;/mese</span>
                <span class="aura-checkbox-description">Progetti illimitati, 100 GB, supporto prioritario.</span>
            </span>
        </label>
        <label class="aura-radio">
            <input type="radio" name="plan-desc">
            <span class="aura-radio-circle">
                <span class="aura-radio-dot"></span>
            </span>
            <span class="aura-checkbox-content">
                <span class="aura-checkbox-label">Enterprise &mdash; Personalizzato</span>
                <span class="aura-checkbox-description">SLA dedicato, spazio illimitato, account manager.</span>
            </span>
        </label>
    </div>
</section>
