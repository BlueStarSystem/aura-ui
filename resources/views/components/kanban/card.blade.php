@props([
    'cardId' => '',
    'columnId' => '',
    'draggable' => true,
])

<div
    class="aura-kanban-card"
    @if($draggable)
        draggable="true"
        @dragstart="onDragStart($event, '{{ $cardId }}', '{{ $columnId }}')"
        @dragend="onDragEnd($event)"
    @endif
    {{ $attributes }}
>
    {{ $slot }}
</div>
