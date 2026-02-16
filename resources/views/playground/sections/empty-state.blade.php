<section id="empty-state" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Empty State</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Default</h3>
        <x-aura::card>
            <x-aura::empty-state />
        </x-aura::card>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Description</h3>
        <x-aura::card>
            <x-aura::empty-state
                icon="inbox"
                title="Nessun risultato"
                description="Non ci sono elementi da visualizzare al momento. Prova a modificare i filtri di ricerca o aggiungi un nuovo elemento."
            />
        </x-aura::card>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Action Button</h3>
        <x-aura::card>
            <x-aura::empty-state
                icon="inbox"
                title="Nessun risultato"
                description="La lista e' vuota. Inizia aggiungendo il tuo primo elemento."
            >
                <x-aura::button variant="primary" size="sm" icon="plus">
                    Aggiungi primo elemento
                </x-aura::button>
            </x-aura::empty-state>
        </x-aura::card>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Custom Icon (Users)</h3>
        <x-aura::card>
            <x-aura::empty-state
                icon="users"
                title="Nessun cliente trovato"
                description="Non ci sono clienti corrispondenti ai criteri di ricerca. Prova con un'altra parola chiave o aggiungi un nuovo cliente."
            >
                <x-aura::button variant="primary" size="sm" icon="plus">
                    Nuovo cliente
                </x-aura::button>
                <x-aura::button variant="secondary" size="sm">
                    Reimposta filtri
                </x-aura::button>
            </x-aura::empty-state>
        </x-aura::card>
    </div>
</section>
