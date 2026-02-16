<section id="toggle" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Toggle</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Default</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::toggle />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Label</h3>
        <div class="flex flex-col gap-3">
            <x-aura::toggle label="Modalita' scura" />
            <x-aura::toggle label="Notifiche attive" checked />
            <x-aura::toggle label="Manutenzione programmata" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Disabled</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::toggle label="Disabilitato (off)" disabled />
            <x-aura::toggle label="Disabilitato (on)" disabled checked />
        </div>
    </div>
</section>
