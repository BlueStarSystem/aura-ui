@props([
    'title' => '',
    'columnId' => '',
    'color' => null,
    'count' => null,
])

<div
    class="aura-kanban-column"
    @dragover="onDragOver($event)"
    @dragenter="onDragEnter($event, '{{ $columnId }}')"
    @dragleave="onDragLeave($event)"
    @drop="onDrop($event, '{{ $columnId }}')"
    {{ $attributes }}
>
    <div class="aura-kanban-column-header">
        @if($color)
            <span class="aura-kanban-column-dot" style="background-color: {{ $color }};"></span>
        @endif
        <span class="aura-kanban-column-title">{{ $title }}</span>
        @if($count !== null)
            <span class="aura-kanban-column-count">{{ $count }}</span>
        @endif
    </div>
    <div class="aura-kanban-column-body">
        {{ $slot }}
    </div>
</div>
