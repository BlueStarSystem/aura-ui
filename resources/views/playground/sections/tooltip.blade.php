<section id="tooltip" class="aura-playground-section">
    <h2 class="aura-section-title">Tooltip</h2>

    <h3 class="aura-section-subtitle">On Hover</h3>
    <div class="aura-component-row">
        <div class="aura-tooltip-wrapper" x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false">
            <button class="aura-btn aura-btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                Copia
            </button>
            <div class="aura-tooltip" x-show="show" x-transition x-cloak>Copia negli appunti</div>
        </div>

        <div class="aura-tooltip-wrapper" x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false">
            <button class="aura-btn aura-btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12v8a2 2 0 002 2h12a2 2 0 002-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
                Condividi
            </button>
            <div class="aura-tooltip" x-show="show" x-transition x-cloak>Condividi questo elemento</div>
        </div>

        <div class="aura-tooltip-wrapper" x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false">
            <button class="aura-btn aura-btn-ghost">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            </button>
            <div class="aura-tooltip" x-show="show" x-transition x-cloak>Scrivi un commento</div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Static Preview</h3>
    <div class="aura-component-row">
        <div class="aura-tooltip-wrapper aura-tooltip-visible">
            <button class="aura-btn aura-btn-outline aura-btn-primary">Hover su di me</button>
            <div class="aura-tooltip">Copia negli appunti</div>
        </div>
    </div>
</section>
