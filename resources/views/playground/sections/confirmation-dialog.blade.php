<section id="confirmation-dialog" class="aura-playground-section">
    <h2 class="aura-section-title">Confirmation Dialog</h2>

    <h3 class="aura-section-subtitle">Danger Confirmation</h3>
    <div class="aura-component-row">
        <button class="aura-btn aura-btn-danger" @click="$dispatch('open-confirm', 'delete-item')">Delete Item</button>
        <x-aura::confirmation-dialog
            name="delete-item"
            variant="danger"
            title="Delete this item?"
            message="This action cannot be undone. The item and all associated data will be permanently removed."
            confirmText="Delete"
        />
    </div>

    <h3 class="aura-section-subtitle">Warning with Input</h3>
    <div class="aura-component-row">
        <button class="aura-btn aura-btn-warning" @click="$dispatch('open-confirm', 'reset-data')">Reset All Data</button>
        <x-aura::confirmation-dialog
            name="reset-data"
            variant="warning"
            title="Reset all data?"
            message="This will erase all your settings and data."
            confirmText="Reset"
            requireInput="RESET"
        />
    </div>

    <h3 class="aura-section-subtitle">Info Confirmation</h3>
    <div class="aura-component-row">
        <button class="aura-btn aura-btn-primary" @click="$dispatch('open-confirm', 'publish')">Publish Changes</button>
        <x-aura::confirmation-dialog
            name="publish"
            variant="info"
            title="Publish changes?"
            message="Your changes will be visible to all users immediately."
            confirmText="Publish"
            cancelText="Not yet"
        />
    </div>
</section>
