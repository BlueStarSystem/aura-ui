<section id="buttons" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Button</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Variants</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::button variant="primary">Primary</x-aura::button>
            <x-aura::button variant="secondary">Secondary</x-aura::button>
            <x-aura::button variant="success">Success</x-aura::button>
            <x-aura::button variant="warning">Warning</x-aura::button>
            <x-aura::button variant="danger">Danger</x-aura::button>
            <x-aura::button variant="ghost">Ghost</x-aura::button>
            <x-aura::button variant="link">Link</x-aura::button>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Gradient</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::button variant="primary" gradient>Primary</x-aura::button>
            <x-aura::button variant="secondary" gradient>Secondary</x-aura::button>
            <x-aura::button variant="success" gradient>Success</x-aura::button>
            <x-aura::button variant="danger" gradient>Danger</x-aura::button>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Outline</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::button variant="primary" outline>Primary</x-aura::button>
            <x-aura::button variant="secondary" outline>Secondary</x-aura::button>
            <x-aura::button variant="success" outline>Success</x-aura::button>
            <x-aura::button variant="danger" outline>Danger</x-aura::button>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Sizes</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::button variant="primary" size="xs">Extra Small</x-aura::button>
            <x-aura::button variant="primary" size="sm">Small</x-aura::button>
            <x-aura::button variant="primary" size="md">Medium</x-aura::button>
            <x-aura::button variant="primary" size="lg">Large</x-aura::button>
            <x-aura::button variant="primary" size="xl">Extra Large</x-aura::button>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">States</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::button variant="primary">Normal</x-aura::button>
            <x-aura::button variant="primary" loading>Loading</x-aura::button>
            <x-aura::button variant="primary" disabled>Disabled</x-aura::button>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Icons</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::button variant="primary" icon="plus">Aggiungi</x-aura::button>
            <x-aura::button variant="danger" icon="trash">Elimina</x-aura::button>
            <x-aura::button variant="success" icon="check">Salva</x-aura::button>
        </div>
    </div>
</section>
