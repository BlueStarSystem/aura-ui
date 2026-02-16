<section id="select" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Select</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Default</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::select placeholder="Seleziona un paese...">
                <option value="it">Italia</option>
                <option value="de">Germania</option>
                <option value="fr">Francia</option>
                <option value="es">Spagna</option>
            </x-aura::select>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Label</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::select label="Paese" placeholder="Seleziona..." hint="Seleziona il paese di residenza.">
                <option value="it">Italia</option>
                <option value="de">Germania</option>
                <option value="fr">Francia</option>
                <option value="es">Spagna</option>
            </x-aura::select>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Error State</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::select label="Categoria" placeholder="Seleziona..." error="Seleziona una categoria.">
                <option value="1">Elettronica</option>
                <option value="2">Abbigliamento</option>
                <option value="3">Casa e Giardino</option>
            </x-aura::select>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Disabled</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::select label="Lingua" disabled>
                <option value="it" selected>Italiano</option>
                <option value="en">English</option>
            </x-aura::select>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Sizes</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::select size="sm" placeholder="Small">
                <option value="it">Italia</option>
                <option value="de">Germania</option>
            </x-aura::select>
            <x-aura::select size="md" placeholder="Medium (default)">
                <option value="it">Italia</option>
                <option value="de">Germania</option>
            </x-aura::select>
            <x-aura::select size="lg" placeholder="Large">
                <option value="it">Italia</option>
                <option value="de">Germania</option>
            </x-aura::select>
        </div>
    </div>
</section>
