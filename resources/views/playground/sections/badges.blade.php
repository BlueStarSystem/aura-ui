<section id="badges" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Badge</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Variants</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::badge variant="primary">Primary</x-aura::badge>
            <x-aura::badge variant="secondary">Secondary</x-aura::badge>
            <x-aura::badge variant="success">Success</x-aura::badge>
            <x-aura::badge variant="warning">Warning</x-aura::badge>
            <x-aura::badge variant="danger">Danger</x-aura::badge>
            <x-aura::badge variant="info">Info</x-aura::badge>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Outline</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::badge variant="primary" outline>Primary</x-aura::badge>
            <x-aura::badge variant="secondary" outline>Secondary</x-aura::badge>
            <x-aura::badge variant="success" outline>Success</x-aura::badge>
            <x-aura::badge variant="warning" outline>Warning</x-aura::badge>
            <x-aura::badge variant="danger" outline>Danger</x-aura::badge>
            <x-aura::badge variant="info" outline>Info</x-aura::badge>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Dot Indicator</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::badge variant="success" dot>Attivo</x-aura::badge>
            <x-aura::badge variant="warning" dot>In attesa</x-aura::badge>
            <x-aura::badge variant="danger" dot>Errore</x-aura::badge>
            <x-aura::badge variant="info" dot>In corso</x-aura::badge>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Sizes</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::badge variant="primary" size="sm">Small</x-aura::badge>
            <x-aura::badge variant="primary">Default</x-aura::badge>
            <x-aura::badge variant="primary" size="lg">Large</x-aura::badge>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Pill / Rounded</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::badge variant="primary" rounded>Primary</x-aura::badge>
            <x-aura::badge variant="success" rounded>Completato</x-aura::badge>
            <x-aura::badge variant="warning" rounded>Bozza</x-aura::badge>
            <x-aura::badge variant="danger" rounded>Scaduto</x-aura::badge>
            <x-aura::badge variant="info" rounded dot>Online</x-aura::badge>
        </div>
    </div>
</section>
