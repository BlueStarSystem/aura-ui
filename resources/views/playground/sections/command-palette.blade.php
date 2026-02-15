<section id="command-palette" class="aura-playground-section">
    <h2 class="aura-section-title">Command Palette</h2>

    <h3 class="aura-section-subtitle">Press Cmd+K or click the button</h3>
    <div class="aura-component-row">
        <button class="aura-btn aura-btn-secondary" @click="$dispatch('keydown', { key: 'k', metaKey: true })">
            <x-aura::icon name="command" size="sm" />
            Open Command Palette
        </button>

        <x-aura::command-palette>
            <x-aura::command-palette.group heading="Navigation">
                <x-aura::command-palette.item value="Go to Dashboard" icon="home" shortcut="G D" />
                <x-aura::command-palette.item value="Go to Settings" icon="settings" shortcut="G S" />
                <x-aura::command-palette.item value="Go to Profile" icon="user" shortcut="G P" />
            </x-aura::command-palette.group>
            <x-aura::command-palette.group heading="Actions">
                <x-aura::command-palette.item value="Create New Project" icon="plus" description="Start a new project from scratch" />
                <x-aura::command-palette.item value="Import Data" icon="upload" description="Import from CSV or JSON" />
                <x-aura::command-palette.item value="Export Report" icon="download" description="Download as PDF" />
            </x-aura::command-palette.group>
            <x-aura::command-palette.group heading="Help">
                <x-aura::command-palette.item value="Documentation" icon="file" />
                <x-aura::command-palette.item value="Keyboard Shortcuts" icon="command" shortcut="?" />
            </x-aura::command-palette.group>
        </x-aura::command-palette>
    </div>
</section>
