<section class="relative overflow-hidden py-20 sm:py-28">
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-20 left-1/3 h-[360px] w-[360px] rounded-full bg-aura-primary-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 h-[300px] w-[300px] rounded-full bg-aura-secondary-500/10 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <x-aura::badge variant="primary" rounded>FAQ</x-aura::badge>
            <h2 class="mt-4 font-heading text-3xl font-bold tracking-tight text-aura-surface-900 sm:text-4xl dark:text-white">
                Frequently asked
                <span class="bg-gradient-to-r from-aura-primary-600 to-aura-secondary-600 bg-clip-text text-transparent">questions</span>
            </h2>
            <p class="mt-4 text-lg text-aura-surface-500 dark:text-aura-surface-300">
                Everything you need to know before you start building.
            </p>
        </div>

        <div class="mt-14">
            <x-aura::accordion>
                <x-aura::accordion.item title="What is Aura UI?" :open="true">
                    Aura UI is a component library for Laravel built on Blade, Alpine.js, and Tailwind CSS 4. It ships a free open-source tier of 44+ components and a Pro tier with advanced data components, Livewire traits, and Filament admin presets.
                </x-aura::accordion.item>

                <x-aura::accordion.item title="Do I need to know Livewire or Alpine.js?">
                    Not necessarily. Most components are pure Blade + Alpine.js and require no Livewire. The Pro tier adds optional Livewire traits for real-time features like DataTables and live search — but you can use the components in any Laravel project.
                </x-aura::accordion.item>

                <x-aura::accordion.item title="How does component ownership work?">
                    Run <code>php artisan aura:add &lt;component&gt;</code> and the Blade file is copied directly into your project's <code>resources/views/components</code> folder. You own it forever — no package dependency, no upstream breakage.
                </x-aura::accordion.item>

                <x-aura::accordion.item title="Is the free version truly free?">
                    Yes. Aura UI Free is MIT-licensed and always will be. Use it in personal and commercial projects without restrictions. No attribution required.
                </x-aura::accordion.item>

                <x-aura::accordion.item title="What does the Pro license include?">
                    The Pro license unlocks 19 additional components (DataTable, Charts, Calendar, Command Palette, and more), 5 Livewire traits, and 4 Filament admin presets. It is a one-time payment with 12 months of updates and email support included.
                </x-aura::accordion.item>

                <x-aura::accordion.item title="Can I upgrade from a lower plan?">
                    Yes. Contact support and we will apply the price difference as a credit towards your upgrade. No need to repurchase the base components you already paid for.
                </x-aura::accordion.item>

                <x-aura::accordion.item title="Does Aura UI support dark mode?">
                    Every component ships with first-class dark mode variants using Tailwind's <code>dark:</code> prefix. Dark mode is toggled via Alpine.js and a <code>.dark</code> class on the root <code>&lt;html&gt;</code> element, persisted in localStorage.
                </x-aura::accordion.item>
            </x-aura::accordion>
        </div>
    </div>
</section>
