<section id="tooltip" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Tooltip</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">On Hover</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::tooltip text="Copia negli appunti">
                <x-aura::button variant="primary" icon="copy">Copia</x-aura::button>
            </x-aura::tooltip>

            <x-aura::tooltip text="Condividi questo elemento">
                <x-aura::button variant="secondary" icon="share">Condividi</x-aura::button>
            </x-aura::tooltip>

            <x-aura::tooltip text="Scrivi un commento">
                <x-aura::button variant="ghost" icon="message-circle" :iconOnly="true" />
            </x-aura::tooltip>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Positions</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::tooltip text="Tooltip in alto" position="top">
                <x-aura::button variant="secondary">Top</x-aura::button>
            </x-aura::tooltip>

            <x-aura::tooltip text="Tooltip in basso" position="bottom">
                <x-aura::button variant="secondary">Bottom</x-aura::button>
            </x-aura::tooltip>

            <x-aura::tooltip text="Tooltip a sinistra" position="left">
                <x-aura::button variant="secondary">Left</x-aura::button>
            </x-aura::tooltip>

            <x-aura::tooltip text="Tooltip a destra" position="right">
                <x-aura::button variant="secondary">Right</x-aura::button>
            </x-aura::tooltip>
        </div>
    </div>
</section>
