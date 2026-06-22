<section class="relative overflow-hidden py-20 sm:py-28">
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-aura-primary-500/10 via-transparent to-aura-secondary-500/10"></div>
        <div class="absolute -top-20 left-1/3 h-[350px] w-[350px] rounded-full bg-aura-primary-500/15 blur-3xl"></div>
        <div class="absolute -bottom-20 right-1/4 h-[300px] w-[300px] rounded-full bg-aura-secondary-500/15 blur-3xl"></div>
    </div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-aura::card class="aura-glass mx-auto max-w-3xl text-center">
            <div class="px-4 py-4 sm:px-8 sm:py-6">
                <x-aura::badge variant="primary" gradient rounded>Limited time</x-aura::badge>
                <h2 class="mt-6 font-heading text-3xl font-bold tracking-tight text-aura-surface-900 sm:text-4xl dark:text-white">
                    Start building with
                    <span class="bg-gradient-to-r from-aura-primary-600 to-aura-secondary-600 bg-clip-text text-transparent">Aura UI today</span>
                </h2>
                <p class="mt-4 text-lg text-aura-surface-500 dark:text-aura-surface-300">
                    Free forever for personal projects. Pro plan unlocks every component, block, and theme.
                </p>
                <div class="mt-8 flex flex-col items-center gap-4 sm:flex-row sm:justify-center">
                    <x-aura::button variant="primary" size="lg" gradient>Get started free</x-aura::button>
                    <x-aura::button variant="ghost" size="lg">View pricing</x-aura::button>
                </div>
                <p class="mt-5 text-sm text-aura-surface-400 dark:text-aura-surface-500">
                    No credit card required &middot; Cancel any time
                </p>
            </div>
        </x-aura::card>
    </div>
</section>
