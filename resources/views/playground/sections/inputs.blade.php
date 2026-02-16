<section id="inputs" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Input</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Default</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::input placeholder="Inserisci testo..." />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Label</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::input label="Nome" placeholder="Mario Rossi" />
            <x-aura::input label="Email" type="email" placeholder="mario@esempio.it" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Hint</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::input label="Password" type="password" placeholder="Inserisci password" hint="Minimo 8 caratteri, almeno un numero e un simbolo." />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Error State</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::input label="Email" type="email" value="indirizzo-non-valido" error="Inserisci un indirizzo email valido." />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Prefix & Suffix</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::input label="Sito web" prefix="https://" placeholder="www.esempio.it" />
            <x-aura::input label="Importo" suffix="EUR" type="number" placeholder="0.00" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Sizes</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::input size="sm" placeholder="Small" />
            <x-aura::input size="md" placeholder="Medium (default)" />
            <x-aura::input size="lg" placeholder="Large" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Disabled & Readonly</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::input label="Disabled" placeholder="Non modificabile" disabled />
            <x-aura::input label="Readonly" value="Valore di sola lettura" readonly />
        </div>
    </div>
</section>
