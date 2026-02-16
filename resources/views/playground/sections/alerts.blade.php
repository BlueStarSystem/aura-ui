<section id="alerts" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Alert</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Info</h3>
        <div class="flex flex-col gap-3">
            <x-aura::alert variant="info">
                <x-slot:title>Informazione</x-slot:title>
                Il sistema sara' in manutenzione programmata dalle 02:00 alle 04:00.
            </x-aura::alert>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Success</h3>
        <div class="flex flex-col gap-3">
            <x-aura::alert variant="success">
                <x-slot:title>Operazione completata</x-slot:title>
                I dati sono stati salvati correttamente nel database.
            </x-aura::alert>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Warning</h3>
        <div class="flex flex-col gap-3">
            <x-aura::alert variant="warning">
                <x-slot:title>Attenzione</x-slot:title>
                Lo spazio su disco sta per esaurirsi. Libera almeno 500 MB per continuare.
            </x-aura::alert>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Danger</h3>
        <div class="flex flex-col gap-3">
            <x-aura::alert variant="danger">
                <x-slot:title>Errore critico</x-slot:title>
                Impossibile connettersi al server. Verifica la connessione e riprova.
            </x-aura::alert>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Dismissible</h3>
        <div class="flex flex-col gap-3">
            <x-aura::alert variant="info" dismissible>
                <x-slot:title>Notifica</x-slot:title>
                Questo alert puo' essere chiuso cliccando la X. Prova!
            </x-aura::alert>
        </div>
    </div>
</section>
