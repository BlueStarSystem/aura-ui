@props([
    'placeholder' => 'Search commands...',
    'emptyText' => 'No results found.',
    'shortcut' => 'Cmd+K',
])

<div
    class="aura-command-palette"
    style="z-index: var(--aura-z-command, 75);"
    x-data="{
        open: false,
        search: '',
        activeIndex: 0,
        get flatItems() {
            const items = this.$refs.groups ? Array.from(this.$refs.groups.querySelectorAll('[data-command-item]')) : [];
            return items.filter(el => el.style.display !== 'none');
        },
        navigate(dir) {
            const items = this.flatItems;
            if (!items.length) return;
            this.activeIndex = (this.activeIndex + dir + items.length) % items.length;
            items[this.activeIndex]?.scrollIntoView({ block: 'nearest' });
        },
        execute() {
            const items = this.flatItems;
            if (items[this.activeIndex]) items[this.activeIndex].click();
        },
        reset() { this.search = ''; this.activeIndex = 0; }
    }"
    x-on:keydown.meta.k.window.prevent="open = !open; if (open) reset();"
    x-on:keydown.ctrl.k.window.prevent="open = !open; if (open) reset();"
    x-on:keydown.escape.window="open = false"
    {{ $attributes }}
>
    <template x-teleport="body">
        <div
            class="aura-command-overlay"
            x-show="open"
            x-transition:enter="aura-transition-fast"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="aura-transition-fast"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="open = false"
            style="display: none;"
        >
            <div
                class="aura-command-dialog"
                x-show="open"
                x-transition:enter="aura-transition"
                x-transition:enter-start="opacity-0 transform scale-95 -translate-y-4"
                x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                x-transition:leave="aura-transition-fast"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                @click.stop
                @keydown.arrow-up.prevent="navigate(-1)"
                @keydown.arrow-down.prevent="navigate(1)"
                @keydown.enter.prevent="execute()"
            >
                <div class="aura-command-input-wrapper">
                    <x-aura::icon name="search" size="md" class="aura-command-input-icon" />
                    <input
                        type="text"
                        class="aura-command-input"
                        placeholder="{{ $placeholder }}"
                        x-model="search"
                        x-ref="commandInput"
                        x-init="$watch('open', v => { if (v) $nextTick(() => $refs.commandInput.focus()) })"
                    />
                    <kbd class="aura-command-kbd">ESC</kbd>
                </div>

                <div class="aura-command-list" x-ref="groups">
                    {{ $slot }}
                </div>

                <div class="aura-command-empty" x-show="search.length > 0 && flatItems.length === 0" x-cloak>
                    {{ $emptyText }}
                </div>

                <div class="aura-command-footer">
                    <span class="aura-command-hint"><kbd>&uarr;&darr;</kbd> navigate</span>
                    <span class="aura-command-hint"><kbd>&crarr;</kbd> select</span>
                    <span class="aura-command-hint"><kbd>esc</kbd> close</span>
                </div>
            </div>
        </div>
    </template>
</div>
