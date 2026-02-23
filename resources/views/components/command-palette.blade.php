@props([
    'placeholder' => 'Search commands...',
    'emptyText' => 'No results found.',
    'shortcut' => 'Cmd+K',
])

<div
    class="aura-command-palette"
    style="z-index: var(--z-aura-toast);"
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
            class="aura-command-overlay fixed inset-0 z-aura-modal flex items-start justify-center pt-[15vh] bg-black/50"
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
                class="aura-command-dialog w-full max-w-lg bg-aura-surface-0 border border-aura-surface-200 rounded-aura-xl shadow-aura-2xl overflow-hidden"
                x-show="open"
                x-transition:enter="aura-transition"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="aura-transition-fast"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.stop
                @keydown.arrow-up.prevent="navigate(-1)"
                @keydown.arrow-down.prevent="navigate(1)"
                @keydown.enter.prevent="execute()"
            >
                <div class="aura-command-input-wrapper flex items-center gap-3 px-4 border-b border-aura-surface-200">
                    <x-aura::icon name="search" size="md" class="aura-command-input-icon shrink-0 text-aura-surface-400" />
                    <input
                        type="text"
                        class="aura-command-input flex-1 py-3.5 border-none bg-transparent text-sm text-aura-surface-900 outline-none placeholder:text-aura-surface-400"
                        placeholder="{{ $placeholder }}"
                        x-model="search"
                        x-ref="commandInput"
                        x-init="$watch('open', v => { if (v) $nextTick(() => $refs.commandInput.focus()) })"
                    />
                    <kbd class="aura-command-kbd shrink-0 px-1.5 py-0.5 text-[10px] font-mono text-aura-surface-400 bg-aura-surface-100 rounded border border-aura-surface-200">ESC</kbd>
                </div>

                <div class="aura-command-list max-h-[300px] overflow-y-auto p-2" x-ref="groups">
                    {{ $slot }}
                </div>

                <div class="aura-command-empty px-4 py-8 text-center text-sm text-aura-surface-400" x-show="search.length > 0 && flatItems.length === 0" x-cloak>
                    {{ $emptyText }}
                </div>

                <div class="aura-command-footer flex items-center gap-4 px-4 py-2.5 border-t border-aura-surface-200 bg-aura-surface-50 text-xs text-aura-surface-400">
                    <span class="aura-command-hint"><kbd class="px-1 py-0.5 text-[10px] font-mono bg-aura-surface-100 rounded border border-aura-surface-200">&uarr;&darr;</kbd> navigate</span>
                    <span class="aura-command-hint"><kbd class="px-1 py-0.5 text-[10px] font-mono bg-aura-surface-100 rounded border border-aura-surface-200">&crarr;</kbd> select</span>
                    <span class="aura-command-hint"><kbd class="px-1 py-0.5 text-[10px] font-mono bg-aura-surface-100 rounded border border-aura-surface-200">esc</kbd> close</span>
                </div>
            </div>
        </div>
    </template>
</div>
