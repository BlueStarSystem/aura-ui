@props([
    'item' => [],
    'labelKey' => 'label',
    'childrenKey' => 'children',
    'iconKey' => 'icon',
    'depth' => 0,
])

@php
    $label = $item[$labelKey] ?? '';
    $children = $item[$childrenKey] ?? [];
    $icon = $item[$iconKey] ?? null;
    $hasChildren = !empty($children);
    $nodeId = $item['id'] ?? md5(json_encode($item));
@endphp

<li class="aura-tree-node" role="treeitem" style="--depth: {{ $depth }}">
    <div
        class="aura-tree-node-content"
        x-bind:class="{
            'aura-tree-node-selected': isSelected('{{ $nodeId }}'),
            'aura-tree-node-expanded': isExpanded('{{ $nodeId }}')
        }"
    >
        @if($hasChildren)
            <button type="button" class="aura-tree-node-toggle" @click="toggleExpand('{{ $nodeId }}')" aria-label="Toggle">
                <x-aura::icon name="chevron-right" size="xs" class="aura-tree-chevron" x-bind:class="{ 'aura-tree-chevron-open': isExpanded('{{ $nodeId }}') }" />
            </button>
        @else
            <span class="aura-tree-node-spacer"></span>
        @endif

        @if($icon)
            <span class="aura-tree-node-icon">
                <x-aura::icon :name="$icon" size="sm" />
            </span>
        @endif

        <span
            class="aura-tree-node-label"
            @click="toggleSelect('{{ $nodeId }}')"
        >
            {{ $label }}
        </span>
    </div>

    @if($hasChildren)
        <ul class="aura-tree-children" x-show="isExpanded('{{ $nodeId }}')" x-collapse x-cloak role="group">
            @foreach($children as $child)
                <x-aura::tree.node
                    :item="$child"
                    :labelKey="$labelKey"
                    :childrenKey="$childrenKey"
                    :iconKey="$iconKey"
                    :depth="$depth + 1"
                />
            @endforeach
        </ul>
    @endif
</li>
