<section id="textarea" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Textarea</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Default</h3>
        <div class="flex flex-col gap-3">
            <x-aura::textarea placeholder="Scrivi qualcosa..." />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Label & Hint</h3>
        <div class="flex flex-col gap-3">
            <x-aura::textarea label="Descrizione" placeholder="Inserisci una descrizione dettagliata..." hint="Descrivi il prodotto in modo chiaro e completo." :rows="4" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Error State</h3>
        <div class="flex flex-col gap-3">
            <x-aura::textarea label="Note" error="Il campo note e' obbligatorio." :rows="3" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Character Count</h3>
        <div class="flex flex-col gap-3">
            <x-aura::textarea label="Messaggio" placeholder="Scrivi il tuo messaggio..." :maxlength="200" characterCount :rows="3" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Sizes</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::textarea label="Small" size="sm" placeholder="Textarea piccola..." :rows="2" />
            <x-aura::textarea label="Large" size="lg" placeholder="Textarea grande..." :rows="2" />
        </div>
    </div>
</section>
