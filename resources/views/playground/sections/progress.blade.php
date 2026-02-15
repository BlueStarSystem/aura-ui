<section id="progress" class="aura-playground-section">
    <h2 class="aura-section-title">Progress</h2>

    <h3 class="aura-section-subtitle">Default (Primary, 75%)</h3>
    <div class="aura-component-col aura-gap-3" style="max-width: 480px;">
        <x-aura::progress :value="75" />
    </div>

    <h3 class="aura-section-subtitle">All Colors</h3>
    <div class="aura-component-col aura-gap-3" style="max-width: 480px;">
        <div>
            <div style="font-size: 12px; color: var(--aura-text-tertiary); margin-bottom: 6px;">Primary (75%)</div>
            <x-aura::progress :value="75" color="primary" />
        </div>
        <div>
            <div style="font-size: 12px; color: var(--aura-text-tertiary); margin-bottom: 6px;">Secondary (60%)</div>
            <x-aura::progress :value="60" color="secondary" />
        </div>
        <div>
            <div style="font-size: 12px; color: var(--aura-text-tertiary); margin-bottom: 6px;">Success (90%)</div>
            <x-aura::progress :value="90" color="success" />
        </div>
        <div>
            <div style="font-size: 12px; color: var(--aura-text-tertiary); margin-bottom: 6px;">Warning (45%)</div>
            <x-aura::progress :value="45" color="warning" />
        </div>
        <div>
            <div style="font-size: 12px; color: var(--aura-text-tertiary); margin-bottom: 6px;">Danger (30%)</div>
            <x-aura::progress :value="30" color="danger" />
        </div>
    </div>

    <h3 class="aura-section-subtitle">Sizes</h3>
    <div class="aura-component-col aura-gap-3" style="max-width: 480px;">
        <div>
            <div style="font-size: 12px; color: var(--aura-text-tertiary); margin-bottom: 6px;">Small (sm)</div>
            <x-aura::progress :value="65" size="sm" />
        </div>
        <div>
            <div style="font-size: 12px; color: var(--aura-text-tertiary); margin-bottom: 6px;">Medium (md) - Default</div>
            <x-aura::progress :value="65" size="md" />
        </div>
        <div>
            <div style="font-size: 12px; color: var(--aura-text-tertiary); margin-bottom: 6px;">Large (lg)</div>
            <x-aura::progress :value="65" size="lg" />
        </div>
    </div>

    <h3 class="aura-section-subtitle">With Label</h3>
    <div class="aura-component-col aura-gap-3" style="max-width: 480px;">
        <x-aura::progress :value="75" size="lg" :label="true" color="primary" />
        <x-aura::progress :value="42" size="lg" :label="true" color="success" />
    </div>

    <h3 class="aura-section-subtitle">Striped</h3>
    <div class="aura-component-col aura-gap-3" style="max-width: 480px;">
        <x-aura::progress :value="70" size="lg" :striped="true" color="primary" />
        <x-aura::progress :value="55" size="lg" :striped="true" color="success" />
        <x-aura::progress :value="85" size="lg" :striped="true" color="warning" />
    </div>

    <h3 class="aura-section-subtitle">Animated</h3>
    <div class="aura-component-col aura-gap-3" style="max-width: 480px;">
        <x-aura::progress :value="60" size="lg" :animated="true" color="primary" />
        <x-aura::progress :value="80" size="lg" :animated="true" color="danger" />
    </div>
</section>
