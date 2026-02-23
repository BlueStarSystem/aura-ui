@props([
    'width' => '200px',
])

<div
    {{ $attributes->class(['aura-context-menu-trigger relative inline-block']) }}
    x-data="{
        open: false,
        x: 0,
        y: 0,
        show(e) {
            e.preventDefault();
            const rect = this.$el.getBoundingClientRect();
            this.x = e.clientX - rect.left;
            this.y = e.clientY - rect.top;

            // Viewport awareness
            const menuW = {{ (int)filter_var($width, FILTER_SANITIZE_NUMBER_INT) }};
            const menuH = 200;
            if (e.clientX + menuW > window.innerWidth) {
                this.x = this.x - menuW;
            }
            if (e.clientY + menuH > window.innerHeight) {
                this.y = this.y - menuH;
            }

            this.open = true;
        }
    }"
    @contextmenu.prevent="show($event)"
    @click.outside="open = false"
    @keydown.escape.window="open = false"
>
    {{ $slot }}

    <div
        class="aura-context-menu absolute bg-aura-surface-0 border border-aura-surface-200 rounded-aura-lg shadow-aura-xl z-aura-dropdown p-1 aura-glass"
        style="width: {{ $width }};"
        x-bind:style="'left: ' + x + 'px; top: ' + y + 'px;'"
        x-show="open"
        x-transition:enter="aura-transition-fast"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="aura-transition-fast"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-cloak
        role="menu"
    >
        @if(isset($menu))
            {{ $menu }}
        @endif
    </div>
</div>
