<section id="breadcrumbs" class="aura-playground-section">
    <h2 class="aura-section-title">Breadcrumbs</h2>

    <h3 class="aura-section-subtitle">Default (Chevron)</h3>
    <div class="aura-component-row">
        <x-aura::breadcrumbs :items="[
            ['label' => 'Home', 'href' => '#', 'icon' => 'home'],
            ['label' => 'Products', 'href' => '#'],
            ['label' => 'Electronics', 'href' => '#'],
            ['label' => 'Smartphones'],
        ]" />
    </div>

    <h3 class="aura-section-subtitle">Slash Separator</h3>
    <div class="aura-component-row">
        <x-aura::breadcrumbs separator="slash" :items="[
            ['label' => 'Dashboard', 'href' => '#'],
            ['label' => 'Settings', 'href' => '#'],
            ['label' => 'Profile'],
        ]" />
    </div>

    <h3 class="aura-section-subtitle">Dot Separator</h3>
    <div class="aura-component-row">
        <x-aura::breadcrumbs separator="dot" :items="[
            ['label' => 'App', 'href' => '#'],
            ['label' => 'Users'],
        ]" />
    </div>
</section>
