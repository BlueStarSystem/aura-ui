<section id="dropdown" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Dropdown</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Default Dropdown</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::dropdown>
                <x-slot:trigger>
                    <x-aura::button variant="secondary">
                        Azioni
                        <x-aura::icon name="chevron-down" size="xs" />
                    </x-aura::button>
                </x-slot:trigger>
                <x-aura::dropdown.item icon="pencil">Modifica</x-aura::dropdown.item>
                <x-aura::dropdown.item icon="copy">Duplica</x-aura::dropdown.item>
                <x-aura::dropdown.separator />
                <x-aura::dropdown.item icon="trash" variant="danger">Elimina</x-aura::dropdown.item>
            </x-aura::dropdown>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With More Items</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::dropdown>
                <x-slot:trigger>
                    <x-aura::button variant="primary">
                        Menu completo
                        <x-aura::icon name="chevron-down" size="xs" />
                    </x-aura::button>
                </x-slot:trigger>
                <x-aura::dropdown.item icon="settings">Impostazioni</x-aura::dropdown.item>
                <x-aura::dropdown.item icon="user">Profilo</x-aura::dropdown.item>
                <x-aura::dropdown.item icon="message-circle">Messaggi</x-aura::dropdown.item>
                <x-aura::dropdown.separator />
                <x-aura::dropdown.item icon="info">Guida</x-aura::dropdown.item>
                <x-aura::dropdown.separator />
                <x-aura::dropdown.item icon="log-out" variant="danger">Esci</x-aura::dropdown.item>
            </x-aura::dropdown>
        </div>
    </div>
</section>
