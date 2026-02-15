<section id="tabs" class="aura-playground-section">
    <h2 class="aura-section-title">Tabs</h2>

    <h3 class="aura-section-subtitle">Default Tabs</h3>
    <div class="aura-component-row">
        <x-aura::tabs :tabs="[
            ['name' => 'overview', 'label' => 'Overview', 'icon' => 'home'],
            ['name' => 'features', 'label' => 'Features'],
            ['name' => 'pricing', 'label' => 'Pricing', 'badge' => 'New'],
            ['name' => 'disabled', 'label' => 'Disabled', 'disabled' => true],
        ]">
            <x-aura::tabs.tab name="overview">
                <p style="color: var(--aura-text-secondary); font-size: 0.9rem;">This is the overview panel. It shows a summary of all features available in the product.</p>
            </x-aura::tabs.tab>
            <x-aura::tabs.tab name="features">
                <p style="color: var(--aura-text-secondary); font-size: 0.9rem;">Feature list with detailed descriptions and screenshots.</p>
            </x-aura::tabs.tab>
            <x-aura::tabs.tab name="pricing">
                <p style="color: var(--aura-text-secondary); font-size: 0.9rem;">Flexible pricing plans for teams of all sizes.</p>
            </x-aura::tabs.tab>
        </x-aura::tabs>
    </div>

    <h3 class="aura-section-subtitle">Pills Variant</h3>
    <div class="aura-component-row">
        <x-aura::tabs variant="pills" :tabs="[
            ['name' => 'all', 'label' => 'All'],
            ['name' => 'active', 'label' => 'Active', 'badge' => '12'],
            ['name' => 'archived', 'label' => 'Archived'],
        ]">
            <x-aura::tabs.tab name="all"><p style="color: var(--aura-text-secondary); font-size: 0.9rem;">Showing all items.</p></x-aura::tabs.tab>
            <x-aura::tabs.tab name="active"><p style="color: var(--aura-text-secondary); font-size: 0.9rem;">Active items only.</p></x-aura::tabs.tab>
            <x-aura::tabs.tab name="archived"><p style="color: var(--aura-text-secondary); font-size: 0.9rem;">Archived items.</p></x-aura::tabs.tab>
        </x-aura::tabs>
    </div>

    <h3 class="aura-section-subtitle">Bordered Variant</h3>
    <div class="aura-component-row">
        <x-aura::tabs variant="bordered" :tabs="[
            ['name' => 'tab1', 'label' => 'General'],
            ['name' => 'tab2', 'label' => 'Security'],
            ['name' => 'tab3', 'label' => 'Notifications'],
        ]">
            <x-aura::tabs.tab name="tab1"><p style="color: var(--aura-text-secondary); font-size: 0.9rem;">General settings panel.</p></x-aura::tabs.tab>
            <x-aura::tabs.tab name="tab2"><p style="color: var(--aura-text-secondary); font-size: 0.9rem;">Security configuration.</p></x-aura::tabs.tab>
            <x-aura::tabs.tab name="tab3"><p style="color: var(--aura-text-secondary); font-size: 0.9rem;">Notification preferences.</p></x-aura::tabs.tab>
        </x-aura::tabs>
    </div>
</section>
