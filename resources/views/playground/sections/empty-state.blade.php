<section id="empty-state" class="aura-playground-section">
    <h2 class="aura-section-title">Empty State</h2>

    <h3 class="aura-section-subtitle">Default</h3>
    <div class="aura-card">
        <x-aura::empty-state />
    </div>

    <h3 class="aura-section-subtitle">With Description</h3>
    <div class="aura-card">
        <x-aura::empty-state
            icon="inbox"
            title="Nessun risultato"
            description="Non ci sono elementi da visualizzare al momento. Prova a modificare i filtri di ricerca o aggiungi un nuovo elemento."
        />
    </div>

    <h3 class="aura-section-subtitle">With Action Button</h3>
    <div class="aura-card">
        <x-aura::empty-state
            icon="inbox"
            title="Nessun risultato"
            description="La lista e' vuota. Inizia aggiungendo il tuo primo elemento."
        >
            <button class="aura-btn aura-btn-primary aura-btn-sm">
                <x-aura::icon name="plus" size="sm" />
                Aggiungi primo elemento
            </button>
        </x-aura::empty-state>
    </div>

    <h3 class="aura-section-subtitle">Custom Icon (Users)</h3>
    <div class="aura-card">
        <x-aura::empty-state
            icon="users"
            title="Nessun cliente trovato"
            description="Non ci sono clienti corrispondenti ai criteri di ricerca. Prova con un'altra parola chiave o aggiungi un nuovo cliente."
        >
            <button class="aura-btn aura-btn-primary aura-btn-sm">
                <x-aura::icon name="plus" size="sm" />
                Nuovo cliente
            </button>
            <button class="aura-btn aura-btn-secondary aura-btn-sm">
                Reimposta filtri
            </button>
        </x-aura::empty-state>
    </div>
</section>
