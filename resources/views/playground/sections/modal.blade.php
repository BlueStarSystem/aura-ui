<section id="modal" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Modal</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Default Modal</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::button variant="primary" @click="$dispatch('open-modal', 'demo-modal')">Apri Modal</x-aura::button>

            <x-aura::modal name="demo-modal">
                <x-slot:title>Conferma operazione</x-slot:title>

                <p>Sei sicuro di voler procedere con questa operazione? Questa azione non puo' essere annullata una volta confermata.</p>

                <x-slot:footer>
                    <x-aura::button variant="ghost" size="sm" @click="$dispatch('close-modal', 'demo-modal')">Annulla</x-aura::button>
                    <x-aura::button variant="primary" size="sm" @click="$dispatch('close-modal', 'demo-modal')">Conferma</x-aura::button>
                </x-slot:footer>
            </x-aura::modal>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Danger Modal</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::button variant="danger" @click="$dispatch('open-modal', 'danger-modal')">Elimina elemento</x-aura::button>

            <x-aura::modal name="danger-modal">
                <x-slot:title>Eliminazione definitiva</x-slot:title>

                <div class="space-y-4">
                    <x-aura::alert variant="danger">
                        <x-slot:title>Attenzione</x-slot:title>
                        Questa azione e' irreversibile. Tutti i dati associati verranno eliminati permanentemente.
                    </x-aura::alert>

                    <p>Digita <strong>"ELIMINA"</strong> per confermare.</p>

                    <x-aura::input placeholder="ELIMINA" />
                </div>

                <x-slot:footer>
                    <x-aura::button variant="ghost" size="sm" @click="$dispatch('close-modal', 'danger-modal')">Annulla</x-aura::button>
                    <x-aura::button variant="danger" size="sm" @click="$dispatch('close-modal', 'danger-modal')">Elimina definitivamente</x-aura::button>
                </x-slot:footer>
            </x-aura::modal>
        </div>
    </div>
</section>
