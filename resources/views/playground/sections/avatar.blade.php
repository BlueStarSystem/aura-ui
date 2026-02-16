<section id="avatar" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Avatar</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Image</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::avatar src="https://i.pravatar.cc/150?img=1" name="User 1" size="sm" />
            <x-aura::avatar src="https://i.pravatar.cc/150?img=2" name="User 2" size="md" />
            <x-aura::avatar src="https://i.pravatar.cc/150?img=3" name="User 3" size="lg" />
            <x-aura::avatar src="https://i.pravatar.cc/150?img=4" name="User 4" size="xl" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Initials</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::avatar name="Mario Rossi" />
            <x-aura::avatar name="Juri Kraft" />
            <x-aura::avatar name="Anna Bianchi" />
            <x-aura::avatar name="Luca Terni" />
            <x-aura::avatar name="Francesca Sera" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Sizes</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::avatar src="https://i.pravatar.cc/150?img=5" name="User XS" size="xs" />
            <x-aura::avatar src="https://i.pravatar.cc/150?img=5" name="User SM" size="sm" />
            <x-aura::avatar src="https://i.pravatar.cc/150?img=5" name="User MD" size="md" />
            <x-aura::avatar src="https://i.pravatar.cc/150?img=5" name="User LG" size="lg" />
            <x-aura::avatar src="https://i.pravatar.cc/150?img=5" name="User XL" size="xl" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">With Status Dot</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::avatar src="https://i.pravatar.cc/150?img=6" name="Online User" size="lg" status="online" />
            <x-aura::avatar src="https://i.pravatar.cc/150?img=7" name="Busy User" size="lg" status="busy" />
            <x-aura::avatar src="https://i.pravatar.cc/150?img=8" name="Offline User" size="lg" status="offline" />
            <x-aura::avatar name="Mario Rossi" size="lg" status="online" />
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Avatar Group</h3>
        <div class="flex flex-wrap gap-3 items-center">
            <x-aura::avatar.group>
                <x-aura::avatar src="https://i.pravatar.cc/150?img=10" name="User 5" />
                <x-aura::avatar src="https://i.pravatar.cc/150?img=9" name="User 4" />
                <x-aura::avatar src="https://i.pravatar.cc/150?img=3" name="User 3" />
                <x-aura::avatar src="https://i.pravatar.cc/150?img=2" name="User 2" />
                <x-aura::avatar src="https://i.pravatar.cc/150?img=1" name="User 1" />
            </x-aura::avatar.group>

            <x-aura::avatar.group>
                <x-aura::avatar name="Mario Rossi" />
                <x-aura::avatar name="Juri Kraft" />
                <x-aura::avatar name="Anna Bianchi" />
            </x-aura::avatar.group>
        </div>
    </div>
</section>
