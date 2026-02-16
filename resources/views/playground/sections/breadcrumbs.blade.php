<section id="breadcrumbs" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Breadcrumbs</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Default (Chevron)</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::breadcrumbs :items="[
                ['label' => 'Home', 'href' => '#', 'icon' => 'home'],
                ['label' => 'Products', 'href' => '#'],
                ['label' => 'Electronics', 'href' => '#'],
                ['label' => 'Smartphones'],
            ]" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Slash Separator</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::breadcrumbs separator="slash" :items="[
                ['label' => 'Dashboard', 'href' => '#'],
                ['label' => 'Settings', 'href' => '#'],
                ['label' => 'Profile'],
            ]" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Dot Separator</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::breadcrumbs separator="dot" :items="[
                ['label' => 'App', 'href' => '#'],
                ['label' => 'Users'],
            ]" />
        </div>
    </div>
</section>
