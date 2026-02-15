<section id="cards" class="aura-playground-section">
    <h2 class="aura-section-title">Card</h2>

    <h3 class="aura-section-subtitle">Basic Card</h3>
    <div class="aura-example-grid">
        <div class="aura-card">
            <div class="aura-card-body">
                <h3 class="aura-card-header-title">Titolo della card</h3>
                <p class="aura-card-header-subtitle">Questo e' un esempio di card base con titolo e contenuto testuale. Utilizza le classi del design system Aura UI.</p>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">With Header, Footer & Actions</h3>
    <div class="aura-example-grid">
        <div class="aura-card">
            <div class="aura-card-header">
                <h3 class="aura-card-header-title">Impostazioni profilo</h3>
                <p class="aura-card-header-subtitle">Gestisci le informazioni del tuo account.</p>
            </div>
            <div class="aura-card-body">
                <div class="aura-input-wrapper">
                    <label class="aura-input-label">Nome completo</label>
                    <input type="text" class="aura-input" value="Mario Rossi">
                </div>
                <div class="aura-input-wrapper" style="margin-top: 12px;">
                    <label class="aura-input-label">Email</label>
                    <input type="email" class="aura-input" value="mario@esempio.it">
                </div>
            </div>
            <div class="aura-card-footer">
                <button class="aura-btn aura-btn-ghost aura-btn-sm">Annulla</button>
                <button class="aura-btn aura-btn-primary aura-btn-sm">Salva modifiche</button>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Hover Effect</h3>
    <div class="aura-example-grid">
        <div class="aura-card aura-card-hover">
            <div class="aura-card-body">
                <h3 class="aura-card-header-title">Passa il mouse qui</h3>
                <p class="aura-card-header-subtitle">Questa card ha un effetto di sollevamento al passaggio del mouse. Ideale per elementi cliccabili.</p>
            </div>
        </div>
        <div class="aura-card aura-card-hover">
            <div class="aura-card-body">
                <h3 class="aura-card-header-title">Elemento interattivo</h3>
                <p class="aura-card-header-subtitle">Usa la classe aura-card-hover per aggiungere l'effetto di elevazione al passaggio del mouse.</p>
            </div>
        </div>
        <div class="aura-card aura-card-hover">
            <div class="aura-card-body">
                <h3 class="aura-card-header-title">Dashboard widget</h3>
                <p class="aura-card-header-subtitle">Perfetto per dashboard, liste di prodotti o qualsiasi griglia di elementi navigabili.</p>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Glass Card</h3>
    <div class="aura-component-row" style="background: linear-gradient(135deg, var(--aura-primary-500), var(--aura-secondary-500)); padding: 32px; border-radius: var(--aura-radius-lg);">
        <div class="aura-card aura-card-glass" style="max-width: 360px;">
            <div class="aura-card-body">
                <h3 class="aura-card-header-title" style="color: #fff;">Effetto vetro</h3>
                <p class="aura-card-header-subtitle" style="color: rgba(255,255,255,0.8);">Card con effetto glassmorphism, ideale su sfondi gradient o con immagini di sfondo.</p>
            </div>
        </div>
    </div>
</section>
