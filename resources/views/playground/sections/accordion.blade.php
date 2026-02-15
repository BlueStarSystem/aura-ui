<section id="accordion" class="aura-playground-section">
    <h2 class="aura-section-title">Accordion</h2>

    <h3 class="aura-section-subtitle">Single Mode (Default)</h3>
    <div class="aura-component-row">
        <x-aura::accordion>
            <x-aura::accordion.item title="What is Aura UI?" name="q1" :defaultOpen="true">
                Aura UI is a component library for Laravel applications, built with Blade, Alpine.js, and the "Vibrant Depth" design language.
            </x-aura::accordion.item>
            <x-aura::accordion.item title="How do I install it?" name="q2" icon="download">
                Install via Composer: <code>composer require bluestarsystem/aura-ui</code>
            </x-aura::accordion.item>
            <x-aura::accordion.item title="Is it customizable?" name="q3" icon="sliders">
                Yes, all components use CSS custom properties that you can override to match your brand.
            </x-aura::accordion.item>
            <x-aura::accordion.item title="Disabled item" name="q4" :disabled="true">
                This content is not accessible.
            </x-aura::accordion.item>
        </x-aura::accordion>
    </div>

    <h3 class="aura-section-subtitle">Multiple Mode</h3>
    <div class="aura-component-row">
        <x-aura::accordion :multiple="true" :bordered="false">
            <x-aura::accordion.item title="Section A" name="a">Content for section A.</x-aura::accordion.item>
            <x-aura::accordion.item title="Section B" name="b">Content for section B.</x-aura::accordion.item>
            <x-aura::accordion.item title="Section C" name="c">Content for section C.</x-aura::accordion.item>
        </x-aura::accordion>
    </div>
</section>
