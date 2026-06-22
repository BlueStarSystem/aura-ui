<section class="relative overflow-hidden py-20 sm:py-28">
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-20 right-1/4 h-[400px] w-[400px] rounded-full bg-aura-primary-500/15 blur-3xl"></div>
        <div class="absolute top-10 -left-20 h-[300px] w-[300px] rounded-full bg-aura-secondary-500/10 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <x-aura::badge variant="primary" gradient rounded>Pricing</x-aura::badge>
            <h2 class="mt-4 font-heading text-3xl font-bold tracking-tight text-aura-surface-900 sm:text-4xl dark:text-white">
                Simple, transparent
                <span class="bg-gradient-to-r from-aura-primary-600 to-aura-secondary-600 bg-clip-text text-transparent">pricing</span>
            </h2>
            <p class="mt-4 text-lg text-aura-surface-500 dark:text-aura-surface-300">
                Pay once, use forever. No subscriptions, no hidden fees.
            </p>
        </div>

        <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            {{-- Free --}}
            <x-aura::card class="flex flex-col">
                <x-slot:header>
                    <div>
                        <h3 class="text-lg font-semibold text-aura-surface-900 dark:text-white">Free</h3>
                        <p class="mt-1 text-sm text-aura-surface-500 dark:text-aura-surface-400">Open-source essentials</p>
                    </div>
                    <div class="mt-4">
                        <span class="font-heading text-4xl font-bold text-aura-surface-900 dark:text-white">&euro;0</span>
                        <span class="text-sm text-aura-surface-500 dark:text-aura-surface-400">forever</span>
                    </div>
                </x-slot:header>

                <ul class="flex-1 space-y-3 text-sm text-aura-surface-600 dark:text-aura-surface-400">
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>44 Blade components</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Dark mode support</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>MIT License</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-surface-300 dark:text-aura-surface-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                        <span class="text-aura-surface-400 dark:text-aura-surface-500">Pro components</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-surface-300 dark:text-aura-surface-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                        <span class="text-aura-surface-400 dark:text-aura-surface-500">Priority support</span>
                    </li>
                </ul>

                <x-slot:footer>
                    <x-aura::button variant="secondary" outline class="w-full">
                        Get Started Free
                    </x-aura::button>
                </x-slot:footer>
            </x-aura::card>

            {{-- Starter --}}
            <x-aura::card class="flex flex-col">
                <x-slot:header>
                    <div>
                        <h3 class="text-lg font-semibold text-aura-surface-900 dark:text-white">Starter</h3>
                        <p class="mt-1 text-sm text-aura-surface-500 dark:text-aura-surface-400">For a single project</p>
                    </div>
                    <div class="mt-4">
                        <span class="font-heading text-4xl font-bold text-aura-surface-900 dark:text-white">&euro;99</span>
                        <span class="text-sm text-aura-surface-500 dark:text-aura-surface-400">one-time</span>
                    </div>
                </x-slot:header>

                <ul class="flex-1 space-y-3 text-sm text-aura-surface-600 dark:text-aura-surface-400">
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Everything in Free</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Pro components</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>1 project</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Email support</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-surface-300 dark:text-aura-surface-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                        <span class="text-aura-surface-400 dark:text-aura-surface-500">Priority support</span>
                    </li>
                </ul>

                <x-slot:footer>
                    <x-aura::button variant="primary" class="w-full">
                        Buy Starter
                    </x-aura::button>
                </x-slot:footer>
            </x-aura::card>

            {{-- Pro (highlighted) --}}
            <x-aura::card class="relative flex flex-col ring-2 ring-aura-primary-500">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                    <x-aura::badge variant="primary" gradient>Most Popular</x-aura::badge>
                </div>
                <x-slot:header>
                    <div>
                        <h3 class="text-lg font-semibold text-aura-surface-900 dark:text-white">Pro</h3>
                        <p class="mt-1 text-sm text-aura-surface-500 dark:text-aura-surface-400">For solo developers</p>
                    </div>
                    <div class="mt-4">
                        <span class="font-heading text-4xl font-bold text-aura-surface-900 dark:text-white">&euro;249</span>
                        <span class="text-sm text-aura-surface-500 dark:text-aura-surface-400">one-time</span>
                    </div>
                </x-slot:header>

                <ul class="flex-1 space-y-3 text-sm text-aura-surface-600 dark:text-aura-surface-400">
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-primary-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Everything in Starter</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-primary-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Unlimited projects</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-primary-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Priority support</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-primary-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>1 year of updates</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-surface-300 dark:text-aura-surface-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                        <span class="text-aura-surface-400 dark:text-aura-surface-500">Team seats</span>
                    </li>
                </ul>

                <x-slot:footer>
                    <x-aura::button variant="primary" gradient class="w-full">
                        Buy Pro
                    </x-aura::button>
                </x-slot:footer>
            </x-aura::card>

            {{-- Team --}}
            <x-aura::card class="flex flex-col">
                <x-slot:header>
                    <div>
                        <h3 class="text-lg font-semibold text-aura-surface-900 dark:text-white">Team</h3>
                        <p class="mt-1 text-sm text-aura-surface-500 dark:text-aura-surface-400">For teams &amp; agencies</p>
                    </div>
                    <div class="mt-4">
                        <span class="font-heading text-4xl font-bold text-aura-surface-900 dark:text-white">&euro;699</span>
                        <span class="text-sm text-aura-surface-500 dark:text-aura-surface-400">one-time</span>
                    </div>
                </x-slot:header>

                <ul class="flex-1 space-y-3 text-sm text-aura-surface-600 dark:text-aura-surface-400">
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Everything in Pro</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Unlimited team seats</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Early access to new features</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Dedicated support</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-aura-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Unlimited projects</span>
                    </li>
                </ul>

                <x-slot:footer>
                    <x-aura::button variant="primary" class="w-full">
                        Buy Team License
                    </x-aura::button>
                </x-slot:footer>
            </x-aura::card>
        </div>
    </div>
</section>
