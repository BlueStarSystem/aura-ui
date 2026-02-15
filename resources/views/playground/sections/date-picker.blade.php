<section id="date-picker" class="aura-playground-section">
    <h2 class="aura-section-title">DatePicker</h2>

    <h3 class="aura-section-subtitle">Basic</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: '',
            displayValue: '',
            year: 2026,
            month: 1,
            days: [],
            dayNames: ['Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa', 'Do'],
            monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],

            init() { this.buildDays(); },

            buildDays() {
                let first = new Date(this.year, this.month, 1);
                let startDay = (first.getDay() + 6) % 7;
                let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                let daysInPrev = new Date(this.year, this.month, 0).getDate();
                this.days = [];
                for (let i = startDay - 1; i >= 0; i--) this.days.push({ day: daysInPrev - i, current: false });
                for (let i = 1; i <= daysInMonth; i++) {
                    let dt = new Date(this.year, this.month, i);
                    let iso = dt.getFullYear() + '-' + String(dt.getMonth()+1).padStart(2,'0') + '-' + String(dt.getDate()).padStart(2,'0');
                    this.days.push({ day: i, current: true, date: iso });
                }
                let rem = 42 - this.days.length;
                for (let i = 1; i <= rem; i++) this.days.push({ day: i, current: false });
            },

            prevMonth() { this.month--; if (this.month < 0) { this.month = 11; this.year--; } this.buildDays(); },
            nextMonth() { this.month++; if (this.month > 11) { this.month = 0; this.year++; } this.buildDays(); },

            selectDate(iso) {
                this.value = iso;
                let parts = iso.split('-');
                this.displayValue = parts[2] + '/' + parts[1] + '/' + parts[0];
                this.open = false;
            },

            clear() { this.value = ''; this.displayValue = ''; this.open = false; }
        }" x-on:click.outside="open = false" class="aura-datepicker-wrapper" style="position: relative;">
            <label class="aura-label">Data</label>
            <div class="aura-datepicker-input-wrap">
                <input type="text" class="aura-input aura-datepicker-input" x-bind:value="displayValue" placeholder="gg/mm/aaaa" readonly x-on:click="open = !open" />
                <div class="aura-datepicker-icons">
                    <button type="button" class="aura-datepicker-clear" x-show="displayValue" x-on:click.stop="clear()" aria-label="Cancella">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                    <span class="aura-datepicker-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </span>
                </div>
            </div>
            <div class="aura-datepicker-dropdown aura-glass" x-show="open" x-transition x-cloak>
                <div class="aura-datepicker-header">
                    <button type="button" class="aura-datepicker-nav" x-on:click="prevMonth()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <span class="aura-datepicker-title" x-text="monthNames[month] + ' ' + year"></span>
                    <button type="button" class="aura-datepicker-nav" x-on:click="nextMonth()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
                <div class="aura-datepicker-weekdays">
                    <template x-for="d in dayNames" :key="d">
                        <span class="aura-datepicker-weekday" x-text="d"></span>
                    </template>
                </div>
                <div class="aura-datepicker-grid">
                    <template x-for="(cell, idx) in days" :key="idx">
                        <button type="button" class="aura-datepicker-day"
                            x-text="cell.day"
                            x-bind:class="{
                                'aura-datepicker-day-other': !cell.current,
                                'aura-datepicker-day-selected': cell.date && cell.date === value,
                            }"
                            x-bind:disabled="!cell.current"
                            x-on:click="cell.current && selectDate(cell.date)"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">With Time</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: '',
            displayValue: '',
            year: 2026,
            month: 1,
            hour: 9,
            minute: 0,
            days: [],
            selectedDate: '',
            dayNames: ['Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa', 'Do'],
            monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],

            init() { this.buildDays(); },

            buildDays() {
                let first = new Date(this.year, this.month, 1);
                let startDay = (first.getDay() + 6) % 7;
                let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                let daysInPrev = new Date(this.year, this.month, 0).getDate();
                this.days = [];
                for (let i = startDay - 1; i >= 0; i--) this.days.push({ day: daysInPrev - i, current: false });
                for (let i = 1; i <= daysInMonth; i++) {
                    let dt = new Date(this.year, this.month, i);
                    let iso = dt.getFullYear() + '-' + String(dt.getMonth()+1).padStart(2,'0') + '-' + String(dt.getDate()).padStart(2,'0');
                    this.days.push({ day: i, current: true, date: iso });
                }
                let rem = 42 - this.days.length;
                for (let i = 1; i <= rem; i++) this.days.push({ day: i, current: false });
            },

            prevMonth() { this.month--; if (this.month < 0) { this.month = 11; this.year--; } this.buildDays(); },
            nextMonth() { this.month++; if (this.month > 11) { this.month = 0; this.year++; } this.buildDays(); },

            selectDate(iso) {
                this.selectedDate = iso;
                this.updateValue();
            },

            updateValue() {
                if (!this.selectedDate) return;
                let h = String(this.hour).padStart(2, '0');
                let m = String(this.minute).padStart(2, '0');
                this.value = this.selectedDate + ' ' + h + ':' + m;
                let parts = this.selectedDate.split('-');
                this.displayValue = parts[2] + '/' + parts[1] + '/' + parts[0] + ' ' + h + ':' + m;
            },

            clear() { this.value = ''; this.displayValue = ''; this.selectedDate = ''; this.open = false; }
        }" x-on:click.outside="open = false" class="aura-datepicker-wrapper" style="position: relative;">
            <label class="aura-label">Data e Ora</label>
            <div class="aura-datepicker-input-wrap">
                <input type="text" class="aura-input aura-datepicker-input" x-bind:value="displayValue" placeholder="gg/mm/aaaa HH:MM" readonly x-on:click="open = !open" />
                <div class="aura-datepicker-icons">
                    <button type="button" class="aura-datepicker-clear" x-show="displayValue" x-on:click.stop="clear()" aria-label="Cancella">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                    <span class="aura-datepicker-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </span>
                </div>
            </div>
            <div class="aura-datepicker-dropdown aura-glass" x-show="open" x-transition x-cloak>
                <div class="aura-datepicker-header">
                    <button type="button" class="aura-datepicker-nav" x-on:click="prevMonth()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <span class="aura-datepicker-title" x-text="monthNames[month] + ' ' + year"></span>
                    <button type="button" class="aura-datepicker-nav" x-on:click="nextMonth()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
                <div class="aura-datepicker-weekdays">
                    <template x-for="d in dayNames" :key="d">
                        <span class="aura-datepicker-weekday" x-text="d"></span>
                    </template>
                </div>
                <div class="aura-datepicker-grid">
                    <template x-for="(cell, idx) in days" :key="idx">
                        <button type="button" class="aura-datepicker-day"
                            x-text="cell.day"
                            x-bind:class="{
                                'aura-datepicker-day-other': !cell.current,
                                'aura-datepicker-day-selected': cell.date && cell.date === selectedDate,
                            }"
                            x-bind:disabled="!cell.current"
                            x-on:click="cell.current && selectDate(cell.date)"
                        ></button>
                    </template>
                </div>
                <div class="aura-datepicker-time">
                    <label class="aura-datepicker-time-label">Ora:</label>
                    <input type="number" min="0" max="23" x-model.number="hour" x-on:change="updateValue()" class="aura-datepicker-time-input" />
                    <span class="aura-datepicker-time-sep">:</span>
                    <input type="number" min="0" max="59" step="5" x-model.number="minute" x-on:change="updateValue()" class="aura-datepicker-time-input" />
                </div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Min / Max Range</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: '',
            displayValue: '',
            year: 2026,
            month: 1,
            minDate: '2026-02-10',
            maxDate: '2026-02-25',
            days: [],
            dayNames: ['Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa', 'Do'],
            monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],

            init() { this.buildDays(); },

            buildDays() {
                let first = new Date(this.year, this.month, 1);
                let startDay = (first.getDay() + 6) % 7;
                let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                let daysInPrev = new Date(this.year, this.month, 0).getDate();
                this.days = [];
                for (let i = startDay - 1; i >= 0; i--) this.days.push({ day: daysInPrev - i, current: false });
                for (let i = 1; i <= daysInMonth; i++) {
                    let dt = new Date(this.year, this.month, i);
                    let iso = dt.getFullYear() + '-' + String(dt.getMonth()+1).padStart(2,'0') + '-' + String(dt.getDate()).padStart(2,'0');
                    let disabled = iso < this.minDate || iso > this.maxDate;
                    this.days.push({ day: i, current: true, date: iso, disabled: disabled });
                }
                let rem = 42 - this.days.length;
                for (let i = 1; i <= rem; i++) this.days.push({ day: i, current: false });
            },

            prevMonth() { this.month--; if (this.month < 0) { this.month = 11; this.year--; } this.buildDays(); },
            nextMonth() { this.month++; if (this.month > 11) { this.month = 0; this.year++; } this.buildDays(); },

            selectDate(iso) {
                this.value = iso;
                let parts = iso.split('-');
                this.displayValue = parts[2] + '/' + parts[1] + '/' + parts[0];
                this.open = false;
            },

            clear() { this.value = ''; this.displayValue = ''; this.open = false; }
        }" x-on:click.outside="open = false" class="aura-datepicker-wrapper" style="position: relative;">
            <label class="aura-label">Data (10-25 Feb 2026)</label>
            <div class="aura-datepicker-input-wrap">
                <input type="text" class="aura-input aura-datepicker-input" x-bind:value="displayValue" placeholder="gg/mm/aaaa" readonly x-on:click="open = !open" />
                <div class="aura-datepicker-icons">
                    <button type="button" class="aura-datepicker-clear" x-show="displayValue" x-on:click.stop="clear()" aria-label="Cancella">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                    <span class="aura-datepicker-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </span>
                </div>
            </div>
            <div class="aura-datepicker-dropdown aura-glass" x-show="open" x-transition x-cloak>
                <div class="aura-datepicker-header">
                    <button type="button" class="aura-datepicker-nav" x-on:click="prevMonth()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <span class="aura-datepicker-title" x-text="monthNames[month] + ' ' + year"></span>
                    <button type="button" class="aura-datepicker-nav" x-on:click="nextMonth()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
                <div class="aura-datepicker-weekdays">
                    <template x-for="d in dayNames" :key="d">
                        <span class="aura-datepicker-weekday" x-text="d"></span>
                    </template>
                </div>
                <div class="aura-datepicker-grid">
                    <template x-for="(cell, idx) in days" :key="idx">
                        <button type="button" class="aura-datepicker-day"
                            x-text="cell.day"
                            x-bind:class="{
                                'aura-datepicker-day-other': !cell.current,
                                'aura-datepicker-day-selected': cell.date && cell.date === value,
                                'aura-datepicker-day-disabled': cell.disabled,
                            }"
                            x-bind:disabled="!cell.current || cell.disabled"
                            x-on:click="cell.current && !cell.disabled && selectDate(cell.date)"
                        ></button>
                    </template>
                </div>
            </div>
            <span class="aura-input-hint">Solo date tra il 10 e il 25 febbraio 2026.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Custom Format (Y-m-d)</h3>
    <div class="aura-component-row">
        <div x-data="{
            open: false,
            value: '',
            displayValue: '',
            year: 2026,
            month: 1,
            days: [],
            dayNames: ['Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa', 'Do'],
            monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],

            init() { this.buildDays(); },

            buildDays() {
                let first = new Date(this.year, this.month, 1);
                let startDay = (first.getDay() + 6) % 7;
                let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                let daysInPrev = new Date(this.year, this.month, 0).getDate();
                this.days = [];
                for (let i = startDay - 1; i >= 0; i--) this.days.push({ day: daysInPrev - i, current: false });
                for (let i = 1; i <= daysInMonth; i++) {
                    let dt = new Date(this.year, this.month, i);
                    let iso = dt.getFullYear() + '-' + String(dt.getMonth()+1).padStart(2,'0') + '-' + String(dt.getDate()).padStart(2,'0');
                    this.days.push({ day: i, current: true, date: iso });
                }
                let rem = 42 - this.days.length;
                for (let i = 1; i <= rem; i++) this.days.push({ day: i, current: false });
            },

            prevMonth() { this.month--; if (this.month < 0) { this.month = 11; this.year--; } this.buildDays(); },
            nextMonth() { this.month++; if (this.month > 11) { this.month = 0; this.year++; } this.buildDays(); },

            selectDate(iso) {
                this.value = iso;
                this.displayValue = iso;
                this.open = false;
            },

            clear() { this.value = ''; this.displayValue = ''; this.open = false; }
        }" x-on:click.outside="open = false" class="aura-datepicker-wrapper" style="position: relative;">
            <label class="aura-label">Data (formato ISO)</label>
            <div class="aura-datepicker-input-wrap">
                <input type="text" class="aura-input aura-datepicker-input" x-bind:value="displayValue" placeholder="YYYY-MM-DD" readonly x-on:click="open = !open" />
                <div class="aura-datepicker-icons">
                    <button type="button" class="aura-datepicker-clear" x-show="displayValue" x-on:click.stop="clear()" aria-label="Cancella">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                    <span class="aura-datepicker-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </span>
                </div>
            </div>
            <div class="aura-datepicker-dropdown aura-glass" x-show="open" x-transition x-cloak>
                <div class="aura-datepicker-header">
                    <button type="button" class="aura-datepicker-nav" x-on:click="prevMonth()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <span class="aura-datepicker-title" x-text="monthNames[month] + ' ' + year"></span>
                    <button type="button" class="aura-datepicker-nav" x-on:click="nextMonth()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
                <div class="aura-datepicker-weekdays">
                    <template x-for="d in dayNames" :key="d">
                        <span class="aura-datepicker-weekday" x-text="d"></span>
                    </template>
                </div>
                <div class="aura-datepicker-grid">
                    <template x-for="(cell, idx) in days" :key="idx">
                        <button type="button" class="aura-datepicker-day"
                            x-text="cell.day"
                            x-bind:class="{
                                'aura-datepicker-day-other': !cell.current,
                                'aura-datepicker-day-selected': cell.date && cell.date === value,
                            }"
                            x-bind:disabled="!cell.current"
                            x-on:click="cell.current && selectDate(cell.date)"
                        ></button>
                    </template>
                </div>
            </div>
            <span class="aura-input-hint">Formato di visualizzazione: YYYY-MM-DD.</span>
        </div>
    </div>
</section>
