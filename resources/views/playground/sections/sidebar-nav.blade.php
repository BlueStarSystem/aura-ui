<section id="sidebar-nav" class="aura-playground-section">
    <h2 class="aura-section-title">Sidebar Navigation</h2>

    <h3 class="aura-section-subtitle">Collapsible Sidebar</h3>
    <div class="aura-component-row">
        <div style="height: 400px; border: 1px solid var(--aura-border-light); border-radius: var(--aura-radius-lg); overflow: hidden; display: flex;">
            <x-aura::sidebar width="240px">
                <x-aura::sidebar.brand>
                    <svg width="28" height="28" viewBox="0 0 32 32" fill="none"><circle cx="16" cy="16" r="14" stroke="url(#sg)" stroke-width="3"/><circle cx="16" cy="16" r="6" fill="url(#sg)"/><defs><linearGradient id="sg" x1="4" y1="4" x2="28" y2="28"><stop stop-color="#6366f1"/><stop offset="1" stop-color="#06b6d4"/></linearGradient></defs></svg>
                    <span x-show="!collapsed" x-cloak>Aura App</span>
                </x-aura::sidebar.brand>
                <x-aura::sidebar.section label="Main">
                    <x-aura::sidebar.item icon="home" label="Dashboard" href="#" :active="true" />
                    <x-aura::sidebar.item icon="inbox" label="Inbox" href="#" badge="3" badgeVariant="danger" />
                    <x-aura::sidebar.item icon="users" label="Customers" href="#" />
                </x-aura::sidebar.section>
                <x-aura::sidebar.section label="Settings">
                    <x-aura::sidebar.item icon="settings" label="Configuration" :expandable="true" name="config">
                        <x-aura::sidebar.sub-item label="General" href="#" :active="true" />
                        <x-aura::sidebar.sub-item label="Security" href="#" />
                        <x-aura::sidebar.sub-item label="API Keys" href="#" />
                    </x-aura::sidebar.item>
                    <x-aura::sidebar.item icon="user" label="Profile" href="#" />
                </x-aura::sidebar.section>
            </x-aura::sidebar>
            <div style="flex: 1; padding: 16px; display: flex; align-items: center; justify-content: center; color: var(--aura-text-tertiary); font-size: 0.9rem;">
                Main content area
            </div>
        </div>
    </div>
</section>
