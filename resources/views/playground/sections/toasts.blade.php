<section id="toasts" class="aura-playground-section">
    <h2 class="aura-section-title">Toast Notifications</h2>

    <h3 class="aura-section-subtitle">Trigger Toasts</h3>
    <div class="aura-component-row" style="flex-wrap: wrap; gap: 8px;">
        <button class="aura-btn aura-btn-success aura-btn-sm" @click="$dispatch('aura:toast', { type: 'success', title: 'Success!', message: 'Your changes have been saved.' })">Success Toast</button>
        <button class="aura-btn aura-btn-danger aura-btn-sm" @click="$dispatch('aura:toast', { type: 'danger', title: 'Error', message: 'Something went wrong. Please try again.' })">Error Toast</button>
        <button class="aura-btn aura-btn-warning aura-btn-sm" @click="$dispatch('aura:toast', { type: 'warning', title: 'Warning', message: 'Your session will expire in 5 minutes.' })">Warning Toast</button>
        <button class="aura-btn aura-btn-secondary aura-btn-sm" @click="$dispatch('aura:toast', { type: 'info', message: 'New update available. Refresh to see changes.' })">Info Toast</button>
    </div>

    <x-aura::toasts position="top-right" />
</section>
