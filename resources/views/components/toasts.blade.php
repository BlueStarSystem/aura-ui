@props([
    'position' => 'top-right',
    'maxToasts' => 5,
    'duration' => 5000,
])

@php
    $positionClasses = match($position) {
        'top-left' => 'top-4 left-4',
        'top-center' => 'top-4 left-1/2 -translate-x-1/2',
        'bottom-right' => 'bottom-4 right-4',
        'bottom-left' => 'bottom-4 left-4',
        'bottom-center' => 'bottom-4 left-1/2 -translate-x-1/2',
        default => 'top-4 right-4',
    };
@endphp

<div
    class="aura-toasts aura-toasts-{{ $position }} fixed z-aura-toast {{ $positionClasses }} flex flex-col gap-3 w-full max-w-sm"
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
            class="aura-toast relative bg-aura-surface-0 border border-aura-surface-200 rounded-aura-lg shadow-aura-lg overflow-hidden flex items-start gap-3 p-4"
            x-bind:class="'aura-toast-' + toast.type"
            x-transition:enter="aura-transition"
            x-transition:enter-start="opacity-0 translate-x-4"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="aura-transition-fast"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 translate-x-4"
            role="alert"
        >
            <div class="aura-toast-icon shrink-0" x-bind:class="{
                'text-aura-success-500': toast.type === 'success',
                'text-aura-danger-500': toast.type === 'danger' || toast.type === 'error',
                'text-aura-warning-500': toast.type === 'warning',
                'text-aura-info-500': toast.type === 'info'
            }">
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
            <div class="aura-toast-content flex-1 min-w-0">
                <template x-if="toast.title">
                    <div class="aura-toast-title text-sm font-semibold text-aura-surface-900" x-text="toast.title"></div>
                </template>
                <div class="aura-toast-message text-sm text-aura-surface-500" x-text="toast.message"></div>
            </div>
            <button class="aura-toast-close shrink-0 p-1 text-aura-surface-400 bg-transparent border-none cursor-pointer rounded-aura-sm aura-transition-fast hover:text-aura-surface-900 hover:bg-aura-surface-100" @click="remove(toast.id)" aria-label="Close">
                <x-aura::icon name="x" size="sm" />
            </button>
            <div class="aura-toast-progress absolute bottom-0 left-0 right-0 h-0.5 bg-aura-surface-100">
                <div class="aura-toast-progress-bar h-full rounded-full" x-bind:class="{
                    'bg-aura-success-500': toast.type === 'success',
                    'bg-aura-danger-500': toast.type === 'danger' || toast.type === 'error',
                    'bg-aura-warning-500': toast.type === 'warning',
                    'bg-aura-info-500': toast.type === 'info'
                }" x-bind:style="'width: ' + toast.progress + '%'"></div>
            </div>
        </div>
    </template>
</div>
