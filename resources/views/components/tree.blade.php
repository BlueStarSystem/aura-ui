@props([
    'items' => [],
    'labelKey' => 'label',
    'childrenKey' => 'children',
    'iconKey' => 'icon',
    'selectable' => false,
    'expandAll' => false,
    'connectors' => true,
])

<div
    class="aura-tree {{ $connectors ? 'aura-tree-connectors' : '' }}"
    x-data="{
        expandedNodes: {{ $expandAll ? 'true' : '[]' }},
        expandAll: {{ $expandAll ? 'true' : 'false' }},
        selectedNodes: [],
        selectable: {{ $selectable ? 'true' : 'false' }},
        isExpanded(id) {
            return this.expandAll === true || this.expandedNodes.includes(id);
        },
        toggleExpand(id) {
            if (this.expandAll === true) {
                this.expandAll = false;
                this.expandedNodes = [];
                return;
            }
            if (this.expandedNodes.includes(id)) {
                this.expandedNodes = this.expandedNodes.filter(n => n !== id);
            } else {
                this.expandedNodes.push(id);
            }
        },
        toggleSelect(id) {
            if (!this.selectable) return;
            if (this.selectedNodes.includes(id)) {
                this.selectedNodes = this.selectedNodes.filter(n => n !== id);
            } else {
                this.selectedNodes.push(id);
            }
        },
        isSelected(id) {
            return this.selectedNodes.includes(id);
        }
    }"
    {{ $attributes }}
>
    <ul class="aura-tree-list" role="tree">
        @foreach($items as $item)
            <x-aura::tree.node
                :item="$item"
                :labelKey="$labelKey"
                :childrenKey="$childrenKey"
                :iconKey="$iconKey"
                :depth="0"
            />
        @endforeach
    </ul>
</div>
