<section class="relative overflow-hidden py-20 sm:py-28">
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-24 left-1/2 h-[380px] w-[500px] -translate-x-1/2 rounded-full bg-aura-secondary-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 -right-20 h-[280px] w-[280px] rounded-full bg-aura-primary-500/10 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <x-aura::badge variant="primary" rounded>Testimonials</x-aura::badge>
            <h2 class="mt-4 font-heading text-3xl font-bold tracking-tight text-aura-surface-900 sm:text-4xl dark:text-white">
                Loved by
                <span class="bg-gradient-to-r from-aura-primary-600 to-aura-secondary-600 bg-clip-text text-transparent">developers</span>
            </h2>
            <p class="mt-4 text-lg text-aura-surface-500 dark:text-aura-surface-300">
                See what teams and indie hackers are building with Aura UI.
            </p>
        </div>

        <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <x-aura::card hover class="flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <x-aura::avatar name="Sofia Esposito" size="md" />
                    <div>
                        <div class="text-sm font-semibold text-aura-surface-900 dark:text-white">Sofia Esposito</div>
                        <div class="text-xs text-aura-surface-500 dark:text-aura-surface-400">Lead Developer, Nexlayer</div>
                    </div>
                </div>
                <p class="flex-1 text-sm leading-relaxed text-aura-surface-600 dark:text-aura-surface-400">
                    "Aura UI saved us weeks of work. The Vibrant Depth design language is exactly what our SaaS needed — polished, modern, and fully dark-mode ready out of the box."
                </p>
                <div class="flex gap-0.5 text-aura-warning-400">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
            </x-aura::card>

            <x-aura::card hover class="flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <x-aura::avatar name="Marcus Chen" size="md" />
                    <div>
                        <div class="text-sm font-semibold text-aura-surface-900 dark:text-white">Marcus Chen</div>
                        <div class="text-xs text-aura-surface-500 dark:text-aura-surface-400">CTO, Vaultly</div>
                    </div>
                </div>
                <p class="flex-1 text-sm leading-relaxed text-aura-surface-600 dark:text-aura-surface-400">
                    "The Filament admin presets alone are worth the Pro upgrade. Our back-office went from boring to genuinely beautiful in an afternoon."
                </p>
                <div class="flex gap-0.5 text-aura-warning-400">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
            </x-aura::card>

            <x-aura::card hover class="flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <x-aura::avatar name="Amara Osei" size="md" />
                    <div>
                        <div class="text-sm font-semibold text-aura-surface-900 dark:text-white">Amara Osei</div>
                        <div class="text-xs text-aura-surface-500 dark:text-aura-surface-400">Indie Hacker</div>
                    </div>
                </div>
                <p class="flex-1 text-sm leading-relaxed text-aura-surface-600 dark:text-aura-surface-400">
                    "I bootstrapped my SaaS with just Aura UI Free. The component depth is unbelievable for an open-source library. The accordion, tabs, and modals all just work."
                </p>
                <div class="flex gap-0.5 text-aura-warning-400">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
            </x-aura::card>

            <x-aura::card hover class="flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <x-aura::avatar name="Lena Müller" size="md" />
                    <div>
                        <div class="text-sm font-semibold text-aura-surface-900 dark:text-white">Lena Müller</div>
                        <div class="text-xs text-aura-surface-500 dark:text-aura-surface-400">Frontend Lead, Stackoria</div>
                    </div>
                </div>
                <p class="flex-1 text-sm leading-relaxed text-aura-surface-600 dark:text-aura-surface-400">
                    "The design tokens system makes theming trivial. We switched our product's accent color in five minutes and every component updated perfectly."
                </p>
                <div class="flex gap-0.5 text-aura-warning-400">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
            </x-aura::card>

            <x-aura::card hover class="flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <x-aura::avatar name="Raj Patel" size="md" />
                    <div>
                        <div class="text-sm font-semibold text-aura-surface-900 dark:text-white">Raj Patel</div>
                        <div class="text-xs text-aura-surface-500 dark:text-aura-surface-400">Full-Stack Dev, Lumio</div>
                    </div>
                </div>
                <p class="flex-1 text-sm leading-relaxed text-aura-surface-600 dark:text-aura-surface-400">
                    "Copy-owning the source via <code class="rounded bg-aura-surface-100 px-1 py-0.5 text-xs dark:bg-aura-surface-800">aura:add</code> is a genius idea. No black-box components — I own every pixel in production."
                </p>
                <div class="flex gap-0.5 text-aura-warning-400">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
            </x-aura::card>

            <x-aura::card hover class="flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <x-aura::avatar name="Chloe Dubois" size="md" />
                    <div>
                        <div class="text-sm font-semibold text-aura-surface-900 dark:text-white">Chloe Dubois</div>
                        <div class="text-xs text-aura-surface-500 dark:text-aura-surface-400">Product Designer, Nodus</div>
                    </div>
                </div>
                <p class="flex-1 text-sm leading-relaxed text-aura-surface-600 dark:text-aura-surface-400">
                    "Finally, a Laravel UI kit that designers actually like. The glass morphism and gradient system hits exactly the right balance of modern without being overdone."
                </p>
                <div class="flex gap-0.5 text-aura-warning-400">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
            </x-aura::card>
        </div>
    </div>
</section>
