<section id="modal" class="aura-playground-section">
    <h2 class="aura-section-title">Modal</h2>

    <h3 class="aura-section-subtitle">Default Modal</h3>
    <div class="aura-component-row" x-data="{ open: false }">
        <button class="aura-btn aura-btn-primary" @click="open = true">Apri Modal</button>

        {{-- Overlay --}}
        <div class="aura-modal-overlay"
             x-show="open"
             x-transition:enter="aura-fade-in"
             x-transition:enter-start="opacity: 0"
             x-transition:leave="aura-fade-out"
             x-transition:leave-end="opacity: 0"
             @click.self="open = false"
             x-cloak>

            {{-- Modal --}}
            <div class="aura-modal"
                 x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 @keydown.escape.window="open = false">

                <div class="aura-modal-header">
                    <h3 class="aura-modal-title">Conferma operazione</h3>
                    <button class="aura-modal-close" @click="open = false">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                <div class="aura-modal-body">
                    <p>Sei sicuro di voler procedere con questa operazione? Questa azione non puo' essere annullata una volta confermata.</p>
                </div>

                <div class="aura-modal-footer">
                    <button class="aura-btn aura-btn-ghost aura-btn-sm" @click="open = false">Annulla</button>
                    <button class="aura-btn aura-btn-primary aura-btn-sm" @click="open = false">Conferma</button>
                </div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Danger Modal</h3>
    <div class="aura-component-row" x-data="{ open: false }">
        <button class="aura-btn aura-btn-danger" @click="open = true">Elimina elemento</button>

        <div class="aura-modal-overlay"
             x-show="open"
             @click.self="open = false"
             x-cloak>

            <div class="aura-modal"
                 x-show="open"
                 x-transition
                 @keydown.escape.window="open = false">

                <div class="aura-modal-header">
                    <h3 class="aura-modal-title">Eliminazione definitiva</h3>
                    <button class="aura-modal-close" @click="open = false">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                <div class="aura-modal-body">
                    <div class="aura-alert aura-alert-danger" style="margin-bottom: 16px;">
                        <svg class="aura-alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        <div class="aura-alert-content">
                            <div class="aura-alert-title">Attenzione</div>
                            <div class="aura-alert-message">Questa azione e' irreversibile. Tutti i dati associati verranno eliminati permanentemente.</div>
                        </div>
                    </div>
                    <p>Digita <strong>"ELIMINA"</strong> per confermare.</p>
                    <div class="aura-input-wrapper" style="margin-top: 12px;">
                        <input type="text" class="aura-input" placeholder="ELIMINA">
                    </div>
                </div>

                <div class="aura-modal-footer">
                    <button class="aura-btn aura-btn-ghost aura-btn-sm" @click="open = false">Annulla</button>
                    <button class="aura-btn aura-btn-danger aura-btn-sm" @click="open = false">Elimina definitivamente</button>
                </div>
            </div>
        </div>
    </div>
</section>
