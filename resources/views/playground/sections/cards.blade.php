<section id="cards" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Card</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Basic Card</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-aura::card>
                <x-aura::card.title>Titolo della card</x-aura::card.title>
                <x-aura::card.description>Questo e' un esempio di card base con titolo e contenuto testuale. Utilizza i componenti del design system Aura UI.</x-aura::card.description>
            </x-aura::card>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Header, Footer & Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-aura::card>
                <x-slot:header>
                    <x-aura::card.title>Impostazioni profilo</x-aura::card.title>
                    <x-aura::card.description>Gestisci le informazioni del tuo account.</x-aura::card.description>
                </x-slot:header>

                <div class="space-y-3">
                    <x-aura::input label="Nome completo" value="Mario Rossi" />
                    <x-aura::input label="Email" type="email" value="mario@esempio.it" />
                </div>

                <x-slot:footer>
                    <x-aura::button variant="ghost" size="sm">Annulla</x-aura::button>
                    <x-aura::button variant="primary" size="sm">Salva modifiche</x-aura::button>
                </x-slot:footer>
            </x-aura::card>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Hover Effect</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-aura::card hover>
                <x-aura::card.title>Passa il mouse qui</x-aura::card.title>
                <x-aura::card.description>Questa card ha un effetto di sollevamento al passaggio del mouse. Ideale per elementi cliccabili.</x-aura::card.description>
            </x-aura::card>

            <x-aura::card hover>
                <x-aura::card.title>Elemento interattivo</x-aura::card.title>
                <x-aura::card.description>Usa la prop hover per aggiungere l'effetto di elevazione al passaggio del mouse.</x-aura::card.description>
            </x-aura::card>

            <x-aura::card hover>
                <x-aura::card.title>Dashboard widget</x-aura::card.title>
                <x-aura::card.description>Perfetto per dashboard, liste di prodotti o qualsiasi griglia di elementi navigabili.</x-aura::card.description>
            </x-aura::card>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Glass Card</h3>
        <div class="bg-gradient-to-br from-aura-primary-500 to-aura-secondary-500 p-8 rounded-aura-lg">
            <x-aura::card glass class="max-w-sm">
                <x-aura::card.title class="text-white">Effetto vetro</x-aura::card.title>
                <x-aura::card.description class="text-white/80">Card con effetto glassmorphism, ideale su sfondi gradient o con immagini di sfondo.</x-aura::card.description>
            </x-aura::card>
        </div>
    </div>
</section>
