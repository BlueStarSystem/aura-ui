<section class="relative overflow-hidden py-20 sm:py-28">
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-32 right-0 h-[480px] w-[480px] rounded-full bg-aura-primary-500/20 blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 h-[360px] w-[360px] rounded-full bg-aura-secondary-500/15 blur-3xl"></div>
    </div>
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
        <div>
            <x-aura::badge variant="primary" gradient rounded>New</x-aura::badge>
            <h1 class="mt-6 font-heading text-4xl font-bold tracking-tight text-aura-surface-900 sm:text-5xl dark:text-white">
                Build faster with
                <span class="bg-gradient-to-r from-aura-primary-600 to-aura-secondary-600 bg-clip-text text-transparent">Aura blocks</span>
            </h1>
            <p class="mt-6 text-lg leading-relaxed text-aura-surface-500 dark:text-aura-surface-300">
                Drop-in, fully-owned sections composed from Aura components. Copy the source, make it yours.
            </p>
            <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                <x-aura::button variant="primary" size="lg" gradient>Get started</x-aura::button>
                <x-aura::button variant="secondary" size="lg" outline>Documentation</x-aura::button>
            </div>
        </div>
        <div class="relative">
            <x-aura::card class="aura-glass">
                <div class="space-y-3">
                    <x-aura::badge variant="success" rounded>Live</x-aura::badge>
                    <div class="h-3 w-3/4 rounded-full bg-aura-surface-100 dark:bg-aura-surface-700"></div>
                    <div class="h-3 w-1/2 rounded-full bg-aura-surface-100 dark:bg-aura-surface-700"></div>
                </div>
            </x-aura::card>
        </div>
    </div>
</section>
