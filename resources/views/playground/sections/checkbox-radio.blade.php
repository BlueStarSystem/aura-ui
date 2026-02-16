<section id="checkbox-radio" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Checkbox & Radio</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Single Checkbox</h3>
        <div class="flex flex-col gap-3">
            <x-aura::checkbox label="Accetto i termini e le condizioni" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Checkbox with Description</h3>
        <div class="flex flex-col gap-3">
            <x-aura::checkbox label="Notifiche email" description="Ricevi aggiornamenti e promozioni via email." checked />
            <x-aura::checkbox label="Notifiche SMS" description="Ricevi avvisi importanti tramite SMS." />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Checkbox Group</h3>
        <div class="flex flex-col gap-3">
            <x-aura::checkbox label="Design" checked />
            <x-aura::checkbox label="Sviluppo" checked />
            <x-aura::checkbox label="Marketing" />
            <x-aura::checkbox label="Vendite" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Radio Group</h3>
        <x-aura::radio-group label="Piano">
            <x-aura::radio name="plan" value="free" label="Free" checked />
            <x-aura::radio name="plan" value="pro" label="Pro" />
            <x-aura::radio name="plan" value="enterprise" label="Enterprise" />
        </x-aura::radio-group>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Radio with Descriptions</h3>
        <x-aura::radio-group label="Piano">
            <x-aura::radio name="plan-desc" value="free" label="Free" description="Fino a 5 progetti, 1 GB di spazio." checked />
            <x-aura::radio name="plan-desc" value="pro" label="Pro &mdash; 9,99 &euro;/mese" description="Progetti illimitati, 100 GB, supporto prioritario." />
            <x-aura::radio name="plan-desc" value="enterprise" label="Enterprise &mdash; Personalizzato" description="SLA dedicato, spazio illimitato, account manager." />
        </x-aura::radio-group>
    </div>
</section>
