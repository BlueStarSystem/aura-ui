<section id="slider-otp" class="aura-playground-section">
    <h2 class="aura-section-title">Slider</h2>

    <h3 class="aura-section-subtitle">Basic</h3>
    <div class="aura-component-row">
        <div x-data="{ value: 50, min: 0, max: 100, get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; } }" class="aura-slider-wrapper">
            <label class="aura-label">Volume</label>
            <div class="aura-slider-track-wrapper">
                <input type="range" class="aura-slider aura-slider-primary" x-model="value" min="0" max="100" step="1" x-bind:style="'--aura-slider-progress: ' + percentage + '%'" />
            </div>
            <div class="aura-slider-labels">
                <span class="aura-slider-min">0</span>
                <span class="aura-slider-max">100</span>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Show Value</h3>
    <div class="aura-component-row">
        <div x-data="{ value: 75, min: 0, max: 100, get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; } }" class="aura-slider-wrapper">
            <div class="aura-slider-header">
                <label class="aura-label">Luminosita'</label>
                <span class="aura-slider-value"><span x-text="value"></span>%</span>
            </div>
            <div class="aura-slider-track-wrapper">
                <input type="range" class="aura-slider aura-slider-primary" x-model="value" min="0" max="100" step="1" x-bind:style="'--aura-slider-progress: ' + percentage + '%'" />
            </div>
            <div class="aura-slider-labels">
                <span class="aura-slider-min">0%</span>
                <span class="aura-slider-max">100%</span>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Custom Range (0 - 1000, step 50)</h3>
    <div class="aura-component-row">
        <div x-data="{ value: 300, min: 0, max: 1000, get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; } }" class="aura-slider-wrapper">
            <div class="aura-slider-header">
                <label class="aura-label">Budget</label>
                <span class="aura-slider-value">&euro;<span x-text="value"></span></span>
            </div>
            <div class="aura-slider-track-wrapper">
                <input type="range" class="aura-slider aura-slider-success" x-model="value" min="0" max="1000" step="50" x-bind:style="'--aura-slider-progress: ' + percentage + '%'" />
            </div>
            <div class="aura-slider-labels">
                <span class="aura-slider-min">&euro;0</span>
                <span class="aura-slider-max">&euro;1000</span>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Negative Range (-50 to 50)</h3>
    <div class="aura-component-row">
        <div x-data="{ value: 0, min: -50, max: 50, get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; } }" class="aura-slider-wrapper">
            <div class="aura-slider-header">
                <label class="aura-label">Bilanciamento</label>
                <span class="aura-slider-value"><span x-text="value"></span></span>
            </div>
            <div class="aura-slider-track-wrapper">
                <input type="range" class="aura-slider aura-slider-warning" x-model="value" min="-50" max="50" step="1" x-bind:style="'--aura-slider-progress: ' + percentage + '%'" />
            </div>
            <div class="aura-slider-labels">
                <span class="aura-slider-min">-50</span>
                <span class="aura-slider-max">+50</span>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Disabled</h3>
    <div class="aura-component-row">
        <div class="aura-slider-wrapper">
            <div class="aura-slider-header">
                <label class="aura-label">Qualita' (disabilitato)</label>
                <span class="aura-slider-value">60%</span>
            </div>
            <div class="aura-slider-track-wrapper">
                <input type="range" class="aura-slider aura-slider-primary" value="60" min="0" max="100" step="1" disabled style="--aura-slider-progress: 60%;" />
            </div>
            <div class="aura-slider-labels">
                <span class="aura-slider-min">0%</span>
                <span class="aura-slider-max">100%</span>
            </div>
        </div>
    </div>

    {{-- OTP Section --}}
    <h2 class="aura-section-title" style="margin-top: 2rem;">OTP Input</h2>

    <h3 class="aura-section-subtitle">4 Digit</h3>
    <div class="aura-component-row">
        <div x-data="{
            digits: ['', '', '', ''],
            length: 4,

            onInput(idx, e) {
                let val = e.target.value.replace(/\D/g, '');
                if (val.length > 1) {
                    let paste = val.split('');
                    for (let i = 0; i < paste.length && (idx + i) < this.length; i++) {
                        this.digits[idx + i] = paste[i];
                    }
                    let nextIdx = Math.min(idx + paste.length, this.length - 1);
                    this.$refs['otp' + nextIdx]?.focus();
                } else {
                    this.digits[idx] = val;
                    if (val && idx < this.length - 1) {
                        this.$refs['otp' + (idx + 1)]?.focus();
                    }
                }
            },

            onKeydown(idx, e) {
                if (e.key === 'Backspace' && !this.digits[idx] && idx > 0) {
                    this.digits[idx - 1] = '';
                    this.$refs['otp' + (idx - 1)]?.focus();
                } else if (e.key === 'ArrowLeft' && idx > 0) {
                    this.$refs['otp' + (idx - 1)]?.focus();
                } else if (e.key === 'ArrowRight' && idx < this.length - 1) {
                    this.$refs['otp' + (idx + 1)]?.focus();
                }
            }
        }" class="aura-otp-wrapper">
            <label class="aura-label">Codice PIN (4 cifre)</label>
            <div class="aura-otp-inputs aura-otp-md">
                <template x-for="(digit, idx) in digits" :key="idx">
                    <input type="text" inputmode="numeric" maxlength="1"
                        class="aura-otp-digit"
                        x-bind:value="digits[idx]"
                        x-on:input="onInput(idx, $event)"
                        x-on:keydown="onKeydown(idx, $event)"
                        x-on:focus="$event.target.select()"
                        x-ref="'otp' + idx"
                        autocomplete="one-time-code"
                    />
                </template>
            </div>
            <span class="aura-input-hint">Inserisci il codice a 4 cifre.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">6 Digit (with separator)</h3>
    <div class="aura-component-row">
        <div x-data="{
            digits: ['', '', '', '', '', ''],
            length: 6,

            onInput(idx, e) {
                let val = e.target.value.replace(/\D/g, '');
                if (val.length > 1) {
                    let paste = val.split('');
                    for (let i = 0; i < paste.length && (idx + i) < this.length; i++) {
                        this.digits[idx + i] = paste[i];
                    }
                    let nextIdx = Math.min(idx + paste.length, this.length - 1);
                    this.$refs['otp6_' + nextIdx]?.focus();
                } else {
                    this.digits[idx] = val;
                    if (val && idx < this.length - 1) {
                        this.$refs['otp6_' + (idx + 1)]?.focus();
                    }
                }
            },

            onKeydown(idx, e) {
                if (e.key === 'Backspace' && !this.digits[idx] && idx > 0) {
                    this.digits[idx - 1] = '';
                    this.$refs['otp6_' + (idx - 1)]?.focus();
                } else if (e.key === 'ArrowLeft' && idx > 0) {
                    this.$refs['otp6_' + (idx - 1)]?.focus();
                } else if (e.key === 'ArrowRight' && idx < this.length - 1) {
                    this.$refs['otp6_' + (idx + 1)]?.focus();
                }
            }
        }" class="aura-otp-wrapper">
            <label class="aura-label">Codice di verifica (6 cifre)</label>
            <div class="aura-otp-inputs aura-otp-md">
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit"
                    x-bind:value="digits[0]" x-on:input="onInput(0, $event)" x-on:keydown="onKeydown(0, $event)" x-on:focus="$event.target.select()" x-ref="otp6_0" autocomplete="one-time-code" />
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit"
                    x-bind:value="digits[1]" x-on:input="onInput(1, $event)" x-on:keydown="onKeydown(1, $event)" x-on:focus="$event.target.select()" x-ref="otp6_1" autocomplete="one-time-code" />
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit"
                    x-bind:value="digits[2]" x-on:input="onInput(2, $event)" x-on:keydown="onKeydown(2, $event)" x-on:focus="$event.target.select()" x-ref="otp6_2" autocomplete="one-time-code" />
                <span class="aura-otp-separator">-</span>
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit"
                    x-bind:value="digits[3]" x-on:input="onInput(3, $event)" x-on:keydown="onKeydown(3, $event)" x-on:focus="$event.target.select()" x-ref="otp6_3" autocomplete="one-time-code" />
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit"
                    x-bind:value="digits[4]" x-on:input="onInput(4, $event)" x-on:keydown="onKeydown(4, $event)" x-on:focus="$event.target.select()" x-ref="otp6_4" autocomplete="one-time-code" />
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit"
                    x-bind:value="digits[5]" x-on:input="onInput(5, $event)" x-on:keydown="onKeydown(5, $event)" x-on:focus="$event.target.select()" x-ref="otp6_5" autocomplete="one-time-code" />
            </div>
            <span class="aura-input-hint">Inserisci il codice ricevuto via SMS o email.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">OTP Error State</h3>
    <div class="aura-component-row">
        <div class="aura-otp-wrapper">
            <label class="aura-label">Codice errato</label>
            <div class="aura-otp-inputs aura-otp-md">
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit aura-input-error" value="1" readonly />
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit aura-input-error" value="2" readonly />
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit aura-input-error" value="3" readonly />
                <span class="aura-otp-separator">-</span>
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit aura-input-error" value="4" readonly />
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit aura-input-error" value="5" readonly />
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit aura-input-error" value="6" readonly />
            </div>
            <span class="aura-input-error-text">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                Codice non valido. Riprova.
            </span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">OTP Disabled</h3>
    <div class="aura-component-row">
        <div class="aura-otp-wrapper">
            <label class="aura-label">Codice (disabilitato)</label>
            <div class="aura-otp-inputs aura-otp-md">
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit" value="8" disabled />
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit" value="5" disabled />
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit" value="2" disabled />
                <input type="text" inputmode="numeric" maxlength="1" class="aura-otp-digit" value="7" disabled />
            </div>
        </div>
    </div>
</section>
