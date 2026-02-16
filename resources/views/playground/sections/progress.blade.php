<section id="progress" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Progress</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Default (Primary, 75%)</h3>
        <div class="flex flex-col gap-3 max-w-lg">
            <x-aura::progress :value="75" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">All Colors</h3>
        <div class="flex flex-col gap-3 max-w-lg">
            <div>
                <div class="text-xs text-aura-surface-400 mb-1.5">Primary (75%)</div>
                <x-aura::progress :value="75" color="primary" />
            </div>
            <div>
                <div class="text-xs text-aura-surface-400 mb-1.5">Secondary (60%)</div>
                <x-aura::progress :value="60" color="secondary" />
            </div>
            <div>
                <div class="text-xs text-aura-surface-400 mb-1.5">Success (90%)</div>
                <x-aura::progress :value="90" color="success" />
            </div>
            <div>
                <div class="text-xs text-aura-surface-400 mb-1.5">Warning (45%)</div>
                <x-aura::progress :value="45" color="warning" />
            </div>
            <div>
                <div class="text-xs text-aura-surface-400 mb-1.5">Danger (30%)</div>
                <x-aura::progress :value="30" color="danger" />
            </div>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Sizes</h3>
        <div class="flex flex-col gap-3 max-w-lg">
            <div>
                <div class="text-xs text-aura-surface-400 mb-1.5">Small (sm)</div>
                <x-aura::progress :value="65" size="sm" />
            </div>
            <div>
                <div class="text-xs text-aura-surface-400 mb-1.5">Medium (md) - Default</div>
                <x-aura::progress :value="65" size="md" />
            </div>
            <div>
                <div class="text-xs text-aura-surface-400 mb-1.5">Large (lg)</div>
                <x-aura::progress :value="65" size="lg" />
            </div>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Label</h3>
        <div class="flex flex-col gap-3 max-w-lg">
            <x-aura::progress :value="75" size="lg" :label="true" color="primary" />
            <x-aura::progress :value="42" size="lg" :label="true" color="success" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Striped</h3>
        <div class="flex flex-col gap-3 max-w-lg">
            <x-aura::progress :value="70" size="lg" :striped="true" color="primary" />
            <x-aura::progress :value="55" size="lg" :striped="true" color="success" />
            <x-aura::progress :value="85" size="lg" :striped="true" color="warning" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Animated</h3>
        <div class="flex flex-col gap-3 max-w-lg">
            <x-aura::progress :value="60" size="lg" :animated="true" color="primary" />
            <x-aura::progress :value="80" size="lg" :animated="true" color="danger" />
        </div>
    </div>
</section>
