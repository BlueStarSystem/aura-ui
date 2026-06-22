<section class="relative overflow-hidden py-20 sm:py-28">
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-24 left-1/2 h-[400px] w-[600px] -translate-x-1/2 rounded-full bg-aura-primary-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-[300px] w-[300px] rounded-full bg-aura-secondary-500/10 blur-3xl"></div>
    </div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <x-aura::badge variant="primary" rounded>Features</x-aura::badge>
            <h2 class="mt-4 font-heading text-3xl font-bold tracking-tight text-aura-surface-900 sm:text-4xl dark:text-white">
                Everything you need to
                <span class="bg-gradient-to-r from-aura-primary-600 to-aura-secondary-600 bg-clip-text text-transparent">ship faster</span>
            </h2>
            <p class="mt-4 text-lg text-aura-surface-500 dark:text-aura-surface-300">
                Beautifully crafted components, thoughtfully composed into blocks you can drop into any project.
            </p>
        </div>
        <div class="mt-16 grid gap-6 sm:grid-cols-2 md:grid-cols-3">
            <x-aura::card hover class="group">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-aura-md bg-aura-primary-100 text-aura-primary-600 dark:bg-aura-primary-500/15 dark:text-aura-primary-400">
                    <x-aura::icon name="zap" size="md" />
                </div>
                <h3 class="font-heading text-base font-semibold text-aura-surface-900 dark:text-white">Instant Velocity</h3>
                <p class="mt-2 text-sm leading-relaxed text-aura-surface-500 dark:text-aura-surface-400">
                    Pre-built, production-ready sections. Drop in and customise — no scaffolding required.
                </p>
            </x-aura::card>
            <x-aura::card hover class="group">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-aura-md bg-aura-secondary-100 text-aura-secondary-600 dark:bg-aura-secondary-500/15 dark:text-aura-secondary-400">
                    <x-aura::icon name="palette" size="md" />
                </div>
                <h3 class="font-heading text-base font-semibold text-aura-surface-900 dark:text-white">Design Tokens</h3>
                <p class="mt-2 text-sm leading-relaxed text-aura-surface-500 dark:text-aura-surface-400">
                    Consistent colour, spacing, and radius scales. Change your theme once, update everywhere.
                </p>
            </x-aura::card>
            <x-aura::card hover class="group">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-aura-md bg-aura-success-100 text-aura-success-600 dark:bg-aura-success-500/15 dark:text-aura-success-400">
                    <x-aura::icon name="moon" size="md" />
                </div>
                <h3 class="font-heading text-base font-semibold text-aura-surface-900 dark:text-white">Dark Mode Ready</h3>
                <p class="mt-2 text-sm leading-relaxed text-aura-surface-500 dark:text-aura-surface-400">
                    Every block ships with first-class dark mode variants. Zero extra effort on your part.
                </p>
            </x-aura::card>
            <x-aura::card hover class="group">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-aura-md bg-aura-warning-100 text-aura-warning-600 dark:bg-aura-warning-500/15 dark:text-aura-warning-400">
                    <x-aura::icon name="shield" size="md" />
                </div>
                <h3 class="font-heading text-base font-semibold text-aura-surface-900 dark:text-white">Accessible by Default</h3>
                <p class="mt-2 text-sm leading-relaxed text-aura-surface-500 dark:text-aura-surface-400">
                    ARIA attributes, keyboard navigation, and focus rings baked into every component.
                </p>
            </x-aura::card>
            <x-aura::card hover class="group">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-aura-md bg-aura-info-100 text-aura-info-600 dark:bg-aura-info-500/15 dark:text-aura-info-400">
                    <x-aura::icon name="code" size="md" />
                </div>
                <h3 class="font-heading text-base font-semibold text-aura-surface-900 dark:text-white">Own the Source</h3>
                <p class="mt-2 text-sm leading-relaxed text-aura-surface-500 dark:text-aura-surface-400">
                    Run <code class="rounded bg-aura-surface-100 px-1 py-0.5 text-xs dark:bg-aura-surface-800">aura:add</code> and the file lands in your project. Yours to edit forever.
                </p>
            </x-aura::card>
            <x-aura::card hover class="group">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-aura-md bg-aura-danger-100 text-aura-danger-600 dark:bg-aura-danger-500/15 dark:text-aura-danger-400">
                    <x-aura::icon name="layers" size="md" />
                </div>
                <h3 class="font-heading text-base font-semibold text-aura-surface-900 dark:text-white">Composable Blocks</h3>
                <p class="mt-2 text-sm leading-relaxed text-aura-surface-500 dark:text-aura-surface-400">
                    Combine hero, feature, stats, and CTA sections freely. Blocks are self-contained by design.
                </p>
            </x-aura::card>
        </div>
    </div>
</section>
