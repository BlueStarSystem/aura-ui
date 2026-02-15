<section id="steps" class="aura-playground-section">
    <h2 class="aura-section-title">Steps / Wizard</h2>

    <h3 class="aura-section-subtitle">Horizontal (Step 2 Active)</h3>
    <div class="aura-component-row">
        <x-aura::steps :current="1">
            <x-aura::steps.step :step="0" label="Account" description="Create your account" />
            <x-aura::steps.step :step="1" label="Profile" description="Fill in your details" />
            <x-aura::steps.step :step="2" label="Review" description="Check your info" />
            <x-aura::steps.step :step="3" label="Complete" description="All done!" />
        </x-aura::steps>
    </div>

    <h3 class="aura-section-subtitle">With Icons (Step 3 Active)</h3>
    <div class="aura-component-row">
        <x-aura::steps :current="2">
            <x-aura::steps.step :step="0" label="Cart" icon="inbox" />
            <x-aura::steps.step :step="1" label="Shipping" icon="globe" />
            <x-aura::steps.step :step="2" label="Payment" icon="lock" />
            <x-aura::steps.step :step="3" label="Confirm" icon="check" />
        </x-aura::steps>
    </div>

    <h3 class="aura-section-subtitle">Completed</h3>
    <div class="aura-component-row">
        <x-aura::steps :current="4">
            <x-aura::steps.step :step="0" label="Step 1" />
            <x-aura::steps.step :step="1" label="Step 2" />
            <x-aura::steps.step :step="2" label="Step 3" />
            <x-aura::steps.step :step="3" label="Step 4" />
        </x-aura::steps>
    </div>
</section>
