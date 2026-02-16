<section id="spinner" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Spinner & Skeleton</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Spinner Sizes</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::spinner size="sm" />
            <x-aura::spinner size="md" />
            <x-aura::spinner size="lg" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Skeleton - Text Lines</h3>
        <div class="flex flex-col gap-3 max-w-lg">
            <x-aura::skeleton class="h-4 w-full" />
            <x-aura::skeleton class="h-4 w-[92%]" />
            <x-aura::skeleton class="h-4 w-[85%]" />
            <x-aura::skeleton class="h-4 w-3/4" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Skeleton - Heading</h3>
        <div class="flex flex-col gap-3 max-w-lg">
            <x-aura::skeleton class="h-6 w-2/3" />
            <x-aura::skeleton class="h-4 w-full" />
            <x-aura::skeleton class="h-4 w-4/5" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Skeleton - Circle (Avatar)</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::skeleton class="h-8 w-8" rounded="full" />
            <x-aura::skeleton class="h-10 w-10" rounded="full" />
            <x-aura::skeleton class="h-12 w-12" rounded="full" />
            <x-aura::skeleton class="h-16 w-16" rounded="full" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Skeleton - Button</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::skeleton class="h-10 w-24" />
            <x-aura::skeleton class="h-10 w-36" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Skeleton - Card</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-aura::card>
                <div class="flex gap-3 items-center mb-4">
                    <x-aura::skeleton class="h-10 w-10" rounded="full" />
                    <div class="flex flex-col gap-2 flex-1">
                        <x-aura::skeleton class="h-4 w-3/5" />
                        <x-aura::skeleton class="h-3 w-2/5" />
                    </div>
                </div>
                <x-aura::skeleton class="h-40 w-full mb-4" rounded="lg" />
                <x-aura::skeleton class="h-4 w-full mb-2" />
                <x-aura::skeleton class="h-4 w-[90%] mb-2" />
                <x-aura::skeleton class="h-4 w-3/4" />
                <x-slot:footer>
                    <x-aura::skeleton class="h-8 w-20" />
                    <x-aura::skeleton class="h-8 w-24" />
                </x-slot:footer>
            </x-aura::card>

            <x-aura::card>
                <x-aura::skeleton class="h-6 w-1/2 mb-3" />
                <x-aura::skeleton class="h-4 w-full mb-2" />
                <x-aura::skeleton class="h-4 w-[95%] mb-2" />
                <x-aura::skeleton class="h-4 w-[88%] mb-2" />
                <x-aura::skeleton class="h-4 w-[70%] mb-4" />
                <div class="flex gap-2">
                    <x-aura::skeleton class="h-7 w-[70px]" />
                    <x-aura::skeleton class="h-7 w-[70px]" />
                    <x-aura::skeleton class="h-7 w-[70px]" />
                </div>
            </x-aura::card>
        </div>
    </div>
</section>
