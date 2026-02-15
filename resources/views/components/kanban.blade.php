@props([])

<div
    class="aura-kanban"
    x-data="{
        dragItem: null,
        dragSource: null,
        onDragStart(e, itemId, columnId) {
            this.dragItem = itemId;
            this.dragSource = columnId;
            e.dataTransfer.effectAllowed = 'move';
            e.target.classList.add('aura-kanban-card-dragging');
        },
        onDragEnd(e) {
            e.target.classList.remove('aura-kanban-card-dragging');
            this.dragItem = null;
            this.dragSource = null;
            document.querySelectorAll('.aura-kanban-column-over').forEach(el => el.classList.remove('aura-kanban-column-over'));
        },
        onDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
        },
        onDragEnter(e, columnId) {
            e.currentTarget.classList.add('aura-kanban-column-over');
        },
        onDragLeave(e) {
            e.currentTarget.classList.remove('aura-kanban-column-over');
        },
        onDrop(e, targetColumnId) {
            e.currentTarget.classList.remove('aura-kanban-column-over');
            if (this.dragItem && this.dragSource !== targetColumnId) {
                this.$dispatch('aura:kanban-moved', {
                    item: this.dragItem,
                    from: this.dragSource,
                    to: targetColumnId
                });
            }
        }
    }"
    {{ $attributes }}
>
    <div class="aura-kanban-board">
        {{ $slot }}
    </div>
</div>
