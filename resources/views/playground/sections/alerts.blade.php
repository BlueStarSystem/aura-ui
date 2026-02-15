<section id="alerts" class="aura-playground-section">
    <h2 class="aura-section-title">Alert</h2>

    <h3 class="aura-section-subtitle">Info</h3>
    <div class="aura-component-col aura-gap-3">
        <div class="aura-alert aura-alert-info">
            <svg class="aura-alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <div class="aura-alert-content">
                <div class="aura-alert-title">Informazione</div>
                <div class="aura-alert-message">Il sistema sara' in manutenzione programmata dalle 02:00 alle 04:00.</div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Success</h3>
    <div class="aura-component-col aura-gap-3">
        <div class="aura-alert aura-alert-success">
            <svg class="aura-alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <div class="aura-alert-content">
                <div class="aura-alert-title">Operazione completata</div>
                <div class="aura-alert-message">I dati sono stati salvati correttamente nel database.</div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Warning</h3>
    <div class="aura-component-col aura-gap-3">
        <div class="aura-alert aura-alert-warning">
            <svg class="aura-alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            <div class="aura-alert-content">
                <div class="aura-alert-title">Attenzione</div>
                <div class="aura-alert-message">Lo spazio su disco sta per esaurirsi. Libera almeno 500 MB per continuare.</div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Danger</h3>
    <div class="aura-component-col aura-gap-3">
        <div class="aura-alert aura-alert-danger">
            <svg class="aura-alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
            <div class="aura-alert-content">
                <div class="aura-alert-title">Errore critico</div>
                <div class="aura-alert-message">Impossibile connettersi al server. Verifica la connessione e riprova.</div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Dismissible</h3>
    <div class="aura-component-col aura-gap-3" x-data="{ showAlert: true }">
        <div class="aura-alert aura-alert-info" x-show="showAlert" x-transition>
            <svg class="aura-alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <div class="aura-alert-content">
                <div class="aura-alert-title">Notifica</div>
                <div class="aura-alert-message">Questo alert puo' essere chiuso cliccando la X. Prova!</div>
            </div>
            <button class="aura-alert-dismiss" @click="showAlert = false" title="Chiudi">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <button class="aura-btn aura-btn-secondary aura-btn-sm" x-show="!showAlert" @click="showAlert = true" x-transition>
            Mostra di nuovo
        </button>
    </div>
</section>
