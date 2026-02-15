@props([
    'label' => null,
    'swatches' => ['#6366f1','#06b6d4','#10b981','#f59e0b','#ef4444','#ec4899','#8b5cf6','#000000','#ffffff'],
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'size' => 'md',
])

<div
    {{ $attributes->class(['aura-color-picker-wrapper']) }}
    x-data="{
        open: false,
        value: @entangle($attributes->wire('model')),
        hexInput: '',

        init() {
            this.hexInput = this.value || '#6366f1';
            this.$watch('value', (v) => { this.hexInput = v || ''; });
        },

        selectSwatch(color) {
            this.value = color;
            this.hexInput = color;
        },

        onHexInput() {
            let hex = this.hexInput.trim();
            if (/^#[0-9a-fA-F]{6}$/.test(hex) || /^#[0-9a-fA-F]{3}$/.test(hex)) {
                this.value = hex;
            }
        },

        clear() {
            this.value = '';
            this.hexInput = '';
        }
    }"
    x-on:click.outside="open = false"
>
    @if($label)
        <label class="aura-label">{{ $label }}</label>
    @endif

    <div class="aura-color-picker-trigger">
        <button
            type="button"
            class="aura-color-picker-button aura-input aura-input-{{ $size }}"
            x-on:click="if (!{{ $disabled ? 'true' : 'false' }}) open = !open"
            @if($disabled) disabled @endif
        >
            <span class="aura-color-swatch-preview" x-bind:style="value ? 'background-color: ' + value : ''"></span>
            <span class="aura-color-value" x-text="value || 'Seleziona colore'"></span>
        </button>
    </div>

    <div
        class="aura-color-picker-dropdown aura-glass"
        x-show="open"
        x-transition
        x-cloak
    >
        {{-- Swatches --}}
        <div class="aura-color-swatches">
            @foreach($swatches as $swatch)
                <button
                    type="button"
                    class="aura-color-swatch"
                    style="background-color: {{ $swatch }}"
                    x-on:click="selectSwatch('{{ $swatch }}')"
                    x-bind:class="{ 'aura-color-swatch-active': value === '{{ $swatch }}' }"
                    title="{{ $swatch }}"
                ></button>
            @endforeach
        </div>

        {{-- Custom hex --}}
        <div class="aura-color-hex-input">
            <span class="aura-color-swatch-preview aura-color-swatch-sm" x-bind:style="'background-color: ' + hexInput"></span>
            <input
                type="text"
                class="aura-input aura-input-sm"
                x-model="hexInput"
                x-on:input="onHexInput()"
                placeholder="#000000"
                maxlength="7"
            />
        </div>
    </div>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
