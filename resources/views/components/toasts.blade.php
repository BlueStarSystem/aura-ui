@props([
    'position' => 'top-right',
    'maxToasts' => 5,
    'duration' => 5000,
])

@php
    $positionClass = "aura-toasts-{$position}";
@endphp

<div
    class="aura-toasts {{ $positionClass }}"
    style="z-index: var(--aura-z-toast, 80);"
    x-data="{
        toasts: [],
        maxToasts: {{ (int)$maxToasts }},
        defaultDuration: {{ (int)$duration }},
        add(toast) {
            const id = Date.now() + Math.random();
            const duration = toast.duration || this.defaultDuration;
            this.toasts.push({ id, type: toast.type || 'info', title: toast.title || '', message: toast.message || '', duration, progress: 100 });
            if (this.toasts.length > this.maxToasts) this.toasts.shift();
            if (duration > 0) {
                const interval = setInterval(() => {
                    const t = this.toasts.find(t => t.id === id);
                    if (!t) { clearInterval(interval); return; }
                    t.progress -= (100 / (duration / 50));
                    if (t.progress <= 0) { this.remove(id); clearInterval(interval); }
                }, 50);
            }
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }"
    @aura:toast.window="add($event.detail)"
    {{ $attributes }}
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            class="aura-toast"
            x-bind:class="'aura-toast-' + toast.type"
            x-transition:enter="aura-transition"
            x-transition:enter-start="opacity-0 transform translate-x-4"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="aura-transition-fast"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 transform translate-x-4"
            role="alert"
        >
            <div class="aura-toast-icon">
                <template x-if="toast.type === 'success'">
                    <x-aura::icon name="check-circle" size="md" />
                </template>
                <template x-if="toast.type === 'danger' || toast.type === 'error'">
                    <x-aura::icon name="x-circle" size="md" />
                </template>
                <template x-if="toast.type === 'warning'">
                    <x-aura::icon name="alert-triangle" size="md" />
                </template>
                <template x-if="toast.type === 'info'">
                    <x-aura::icon name="info" size="md" />
                </template>
            </div>
            <div class="aura-toast-content">
                <template x-if="toast.title">
                    <div class="aura-toast-title" x-text="toast.title"></div>
                </template>
                <div class="aura-toast-message" x-text="toast.message"></div>
            </div>
            <button class="aura-toast-close" @click="remove(toast.id)" aria-label="Close">
                <x-aura::icon name="x" size="sm" />
            </button>
            <div class="aura-toast-progress">
                <div class="aura-toast-progress-bar" x-bind:style="'width: ' + toast.progress + '%'"></div>
            </div>
        </div>
    </template>
</div>
