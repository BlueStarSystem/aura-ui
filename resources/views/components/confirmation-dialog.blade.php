@props([
    'name' => 'confirm',
    'variant' => 'danger',
    'title' => 'Are you sure?',
    'message' => '',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'requireInput' => null,
    'maxWidth' => 'sm',
])

@php
    $variantClass = "aura-confirm-{$variant}";
    $iconMap = [
        'danger' => 'alert-triangle',
        'warning' => 'alert-circle',
        'info' => 'info',
    ];
    $iconName = $iconMap[$variant] ?? 'alert-triangle';
    $maxWidthClass = match($maxWidth) {
        'xs' => 'aura-confirm-xs',
        'sm' => 'aura-confirm-sm',
        'md' => 'aura-confirm-md',
        'lg' => 'aura-confirm-lg',
        default => 'aura-confirm-sm',
    };
@endphp

<div
    x-data="{ open: false, inputValue: '' }"
    x-on:open-confirm.window="if ($event.detail === '{{ $name }}') { open = true; inputValue = ''; }"
    x-on:keydown.escape.window="open = false"
    {{ $attributes }}
>
    <template x-teleport="body">
        <div
            class="aura-confirm-overlay"
            x-show="open"
            x-transition:enter="aura-transition-slow"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="aura-transition-fast"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;"
        >
            <div
                class="aura-confirm-dialog {{ $variantClass }} {{ $maxWidthClass }}"
                x-show="open"
                x-transition:enter="aura-transition"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="aura-transition-fast"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                x-on:click.stop
            >
                <div class="aura-confirm-icon {{ $variantClass }}-icon">
                    <x-aura::icon :name="$iconName" size="lg" />
                </div>

                <h3 class="aura-confirm-title">{{ $title }}</h3>

                @if($message)
                    <p class="aura-confirm-message">{{ $message }}</p>
                @elseif($slot->isNotEmpty())
                    <div class="aura-confirm-message">{{ $slot }}</div>
                @endif

                @if($requireInput)
                    <div class="aura-confirm-input">
                        <label class="aura-confirm-input-label">Type <strong>{{ $requireInput }}</strong> to confirm</label>
                        <input
                            type="text"
                            class="aura-input"
                            x-model="inputValue"
                            placeholder="{{ $requireInput }}"
                        />
                    </div>
                @endif

                <div class="aura-confirm-actions">
                    <button
                        type="button"
                        class="aura-btn aura-btn-ghost aura-btn-sm"
                        x-on:click="open = false"
                    >
                        {{ $cancelText }}
                    </button>
                    <button
                        type="button"
                        class="aura-btn aura-btn-{{ $variant }} aura-btn-sm"
                        x-on:click="$dispatch('confirmed', '{{ $name }}'); open = false;"
                        @if($requireInput) x-bind:disabled="inputValue !== '{{ $requireInput }}'" @endif
                    >
                        {{ $confirmText }}
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
