<section id="toggle" class="aura-playground-section">
    <h2 class="aura-section-title">Toggle</h2>

    <h3 class="aura-section-subtitle">Default</h3>
    <div class="aura-component-row">
        <label class="aura-toggle">
            <input type="checkbox">
            <span class="aura-toggle-track">
                <span class="aura-toggle-knob"></span>
            </span>
        </label>
    </div>

    <h3 class="aura-section-subtitle">With Label</h3>
    <div class="aura-component-col">
        <label class="aura-toggle">
            <input type="checkbox">
            <span class="aura-toggle-track">
                <span class="aura-toggle-knob"></span>
            </span>
            <span class="aura-toggle-label">Modalita' scura</span>
        </label>
        <label class="aura-toggle">
            <input type="checkbox" checked>
            <span class="aura-toggle-track">
                <span class="aura-toggle-knob"></span>
            </span>
            <span class="aura-toggle-label">Notifiche attive</span>
        </label>
        <label class="aura-toggle">
            <input type="checkbox">
            <span class="aura-toggle-track">
                <span class="aura-toggle-knob"></span>
            </span>
            <span class="aura-toggle-label">Manutenzione programmata</span>
        </label>
    </div>

    <h3 class="aura-section-subtitle">Sizes</h3>
    <div class="aura-component-row aura-items-center">
        <label class="aura-toggle aura-toggle-sm">
            <input type="checkbox" checked>
            <span class="aura-toggle-track">
                <span class="aura-toggle-knob"></span>
            </span>
            <span class="aura-toggle-label">Small</span>
        </label>
        <label class="aura-toggle">
            <input type="checkbox" checked>
            <span class="aura-toggle-track">
                <span class="aura-toggle-knob"></span>
            </span>
            <span class="aura-toggle-label">Medium</span>
        </label>
        <label class="aura-toggle aura-toggle-lg">
            <input type="checkbox" checked>
            <span class="aura-toggle-track">
                <span class="aura-toggle-knob"></span>
            </span>
            <span class="aura-toggle-label">Large</span>
        </label>
    </div>

    <h3 class="aura-section-subtitle">Disabled</h3>
    <div class="aura-component-row">
        <label class="aura-toggle" aria-disabled="true">
            <input type="checkbox" disabled>
            <span class="aura-toggle-track">
                <span class="aura-toggle-knob"></span>
            </span>
            <span class="aura-toggle-label">Disabilitato (off)</span>
        </label>
        <label class="aura-toggle" aria-disabled="true">
            <input type="checkbox" checked disabled>
            <span class="aura-toggle-track">
                <span class="aura-toggle-knob"></span>
            </span>
            <span class="aura-toggle-label">Disabilitato (on)</span>
        </label>
    </div>

    <h3 class="aura-section-subtitle">Checked by Default</h3>
    <div class="aura-component-row">
        <label class="aura-toggle">
            <input type="checkbox" checked>
            <span class="aura-toggle-track">
                <span class="aura-toggle-knob"></span>
            </span>
            <span class="aura-toggle-label">Attivo per default</span>
        </label>
    </div>
</section>
