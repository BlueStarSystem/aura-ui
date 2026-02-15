<section id="tree-view" class="aura-playground-section">
    <h2 class="aura-section-title">Tree View</h2>

    <h3 class="aura-section-subtitle">File System Tree</h3>
    <div class="aura-component-row">
        <div style="max-width: 360px;">
            <x-aura::tree :items="[
                ['id' => 'src', 'label' => 'src', 'icon' => 'folder', 'children' => [
                    ['id' => 'components', 'label' => 'Components', 'icon' => 'folder', 'children' => [
                        ['id' => 'btn', 'label' => 'Button.vue', 'icon' => 'file'],
                        ['id' => 'input', 'label' => 'Input.vue', 'icon' => 'file'],
                        ['id' => 'modal', 'label' => 'Modal.vue', 'icon' => 'file'],
                    ]],
                    ['id' => 'utils', 'label' => 'utils', 'icon' => 'folder', 'children' => [
                        ['id' => 'helpers', 'label' => 'helpers.ts', 'icon' => 'file'],
                    ]],
                    ['id' => 'app', 'label' => 'App.vue', 'icon' => 'file'],
                    ['id' => 'main', 'label' => 'main.ts', 'icon' => 'file'],
                ]],
                ['id' => 'pkg', 'label' => 'package.json', 'icon' => 'file'],
                ['id' => 'readme', 'label' => 'README.md', 'icon' => 'file'],
            ]" :selectable="true" />
        </div>
    </div>

    <h3 class="aura-section-subtitle">Expand All, No Connectors</h3>
    <div class="aura-component-row">
        <div style="max-width: 360px;">
            <x-aura::tree :items="[
                ['id' => 'a', 'label' => 'Animals', 'children' => [
                    ['id' => 'b', 'label' => 'Mammals', 'children' => [
                        ['id' => 'c', 'label' => 'Dog'],
                        ['id' => 'd', 'label' => 'Cat'],
                    ]],
                    ['id' => 'e', 'label' => 'Birds', 'children' => [
                        ['id' => 'f', 'label' => 'Eagle'],
                    ]],
                ]],
            ]" :expandAll="true" :connectors="false" />
        </div>
    </div>
</section>
