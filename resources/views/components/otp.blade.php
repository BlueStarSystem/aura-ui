@props([
    'label' => null,
    'length' => 6,
    'disabled' => false,
    'error' => null,
    'hint' => null,
])

@php $len = max(1, (int) $length); @endphp

<div
    {{ $attributes->class(['aura-otp-wrapper flex flex-col gap-1.5']) }}
    x-data="{
        length: {{ $len }},
        digits: Array({{ $len }}).fill(''),
        model: @if($attributes->wire('model')->value()) $wire.entangle({{ Js::from($attributes->wire('model')->value()) }}){{ $attributes->wire('model')->hasModifier('live') ? '.live' : '' }} @else '' @endif,
        init() {
            const v = (this.model || '').toString().slice(0, this.length).split('');
            for (let i = 0; i < this.length; i++) this.digits[i] = v[i] || '';
        },
        sync() { this.model = this.digits.join(''); },
        onInput(e, i) {
            const d = e.target.value.replace(/[^0-9]/g, '').slice(-1);
            this.digits[i] = d;
            e.target.value = d;
            this.sync();
            if (d && i < this.length - 1) this.$refs['d' + (i + 1)].focus();
        },
        onKeydown(e, i) {
            if (e.key === 'Backspace' && !this.digits[i] && i > 0) { this.$refs['d' + (i - 1)].focus(); }
            else if (e.key === 'ArrowLeft' && i > 0) { this.$refs['d' + (i - 1)].focus(); }
            else if (e.key === 'ArrowRight' && i < this.length - 1) { this.$refs['d' + (i + 1)].focus(); }
        },
        onPaste(e) {
            e.preventDefault();
            const txt = (e.clipboardData.getData('text') || '').replace(/[^0-9]/g, '').slice(0, this.length).split('');
            for (let i = 0; i < this.length; i++) this.digits[i] = txt[i] || '';
            this.sync();
            const next = Math.min(txt.length, this.length - 1);
            this.$nextTick(() => this.$refs['d' + next] && this.$refs['d' + next].focus());
        }
    }"
>
    @php
        $otpId = 'aura-otp-'.\Illuminate\Support\Str::random(8);
        $otpDescribedBy = $error ? $otpId.'-error' : ($hint ? $otpId.'-hint' : null);
    @endphp

    @if($label)
        <span class="aura-label" id="{{ $otpId }}-label">{{ $label }}</span>
    @endif

    {{-- Each box is a separate input, so without a name of its own a screen
         reader announces six identical unlabelled fields. The group carries the
         label, each box says which digit it is. --}}
    <div
        class="aura-otp-inputs flex items-center gap-2"
        role="group"
        @if($label) aria-labelledby="{{ $otpId }}-label" @else aria-label="{{ __('aura-ui::messages.verification_code') }}" @endif
        @if($otpDescribedBy) aria-describedby="{{ $otpDescribedBy }}" @endif
        x-on:paste="onPaste($event)"
    >
        @for($i = 0; $i < $len; $i++)
            <input
                type="text"
                inputmode="numeric"
                maxlength="1"
                class="aura-otp-digit w-11 h-11 text-center text-base font-semibold border border-aura-surface-500 rounded-aura-md bg-aura-surface-0 text-aura-surface-900 outline-none aura-transition-fast focus:border-aura-primary-500 focus:shadow-[var(--aura-glow-primary)] @if($error) border-aura-danger-500 @endif"
                x-ref="d{{ $i }}"
                x-model="digits[{{ $i }}]"
                x-on:input="onInput($event, {{ $i }})"
                x-on:keydown="onKeydown($event, {{ $i }})"
                @if($disabled) disabled @endif
                aria-label="{{ __('aura-ui::messages.digit_n_of_max', ['n' => $i + 1, 'max' => $len]) }}"
                @if($error) aria-invalid="true" @endif
                {{-- one-time-code lets the phone offer the SMS it just received;
                     "off" told it not to. Only the first box, or the OS fills
                     every one of them with the whole code. --}}
                autocomplete="{{ $i === 0 ? 'one-time-code' : 'off' }}"
            />
        @endfor
    </div>

    @if($error)
        <p class="aura-input-error-text" id="{{ $otpId }}-error">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint" id="{{ $otpId }}-hint">{{ $hint }}</p>
    @endif
</div>
