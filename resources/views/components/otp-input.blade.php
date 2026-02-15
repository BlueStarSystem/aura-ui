@props([
    'label' => null,
    'length' => 6,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'size' => 'md',
])

<div
    {{ $attributes->class(['aura-otp-wrapper']) }}
    x-data="{
        value: @entangle($attributes->wire('model')),
        length: {{ $length }},
        digits: [],

        init() {
            this.digits = Array.from({ length: this.length }, (_, i) =>
                this.value ? (this.value[i] || '') : ''
            );
            this.$watch('value', (v) => {
                let str = v || '';
                this.digits = Array.from({ length: this.length }, (_, i) => str[i] || '');
            });
        },

        onInput(idx, e) {
            let val = e.target.value.replace(/\D/g, '');
            if (val.length > 1) {
                // Paste handling
                let paste = val.split('');
                for (let i = 0; i < paste.length && (idx + i) < this.length; i++) {
                    this.digits[idx + i] = paste[i];
                }
                let nextIdx = Math.min(idx + paste.length, this.length - 1);
                this.$refs['otp-' + nextIdx]?.focus();
            } else {
                this.digits[idx] = val;
                if (val && idx < this.length - 1) {
                    this.$refs['otp-' + (idx + 1)]?.focus();
                }
            }
            this.syncValue();
        },

        onKeydown(idx, e) {
            if (e.key === 'Backspace' && !this.digits[idx] && idx > 0) {
                this.digits[idx - 1] = '';
                this.$refs['otp-' + (idx - 1)]?.focus();
                this.syncValue();
            } else if (e.key === 'ArrowLeft' && idx > 0) {
                this.$refs['otp-' + (idx - 1)]?.focus();
            } else if (e.key === 'ArrowRight' && idx < this.length - 1) {
                this.$refs['otp-' + (idx + 1)]?.focus();
            }
        },

        onPaste(e) {
            e.preventDefault();
            let paste = e.clipboardData.getData('text').replace(/\D/g, '').substring(0, this.length);
            paste.split('').forEach((ch, i) => { this.digits[i] = ch; });
            let focusIdx = Math.min(paste.length, this.length - 1);
            this.$refs['otp-' + focusIdx]?.focus();
            this.syncValue();
        },

        syncValue() {
            this.value = this.digits.join('');
        }
    }"
>
    @if($label)
        <label class="aura-label">{{ $label }}</label>
    @endif

    <div class="aura-otp-inputs aura-otp-{{ $size }}">
        @for($i = 0; $i < $length; $i++)
            @if($i == 3 && $length == 6)
                <span class="aura-otp-separator">-</span>
            @endif
            <input
                type="text"
                inputmode="numeric"
                maxlength="1"
                class="aura-otp-digit {{ $error ? 'aura-input-error' : '' }}"
                x-ref="otp-{{ $i }}"
                x-bind:value="digits[{{ $i }}]"
                x-on:input="onInput({{ $i }}, $event)"
                x-on:keydown="onKeydown({{ $i }}, $event)"
                x-on:paste="onPaste($event)"
                x-on:focus="$event.target.select()"
                @if($disabled) disabled @endif
                autocomplete="one-time-code"
            />
        @endfor
    </div>

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
