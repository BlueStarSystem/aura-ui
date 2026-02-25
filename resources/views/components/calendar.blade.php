@props([
    'events' => [],
    'view' => 'month',
    'locale' => 'en',
    'startOfWeek' => 1,
    'eventDateKey' => 'date',
    'eventTitleKey' => 'title',
    'eventColorKey' => 'color',
    'eventStartKey' => 'start',
    'eventEndKey' => 'end',
    'businessHoursStart' => 8,
    'businessHoursEnd' => 20,
])

@php
    $dayNames = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    if ($startOfWeek === 0) {
        array_unshift($dayNames, array_pop($dayNames));
    }
@endphp

<div
    class="aura-calendar border border-aura-surface-200 rounded-aura-lg overflow-hidden bg-aura-surface-0"
    x-data="{
        view: '{{ $view }}',
        currentDate: new Date(),
        events: {{ Js::from($events) }},
        eventDateKey: '{{ $eventDateKey }}',
        eventTitleKey: '{{ $eventTitleKey }}',
        eventColorKey: '{{ $eventColorKey }}',
        eventStartKey: '{{ $eventStartKey }}',
        eventEndKey: '{{ $eventEndKey }}',
        startOfWeek: {{ (int)$startOfWeek }},
        businessHoursStart: {{ (int)$businessHoursStart }},
        businessHoursEnd: {{ (int)$businessHoursEnd }},

        get year() { return this.currentDate.getFullYear(); },
        get month() { return this.currentDate.getMonth(); },

        get title() {
            if (this.view === 'month') return this.monthTitle;
            if (this.view === 'week') return this.weekTitle;
            return this.dayTitle;
        },

        get monthTitle() {
            return this.currentDate.toLocaleString('{{ $locale }}', { month: 'long', year: 'numeric' });
        },

        get weekTitle() {
            const start = this.weekStart;
            const end = new Date(start);
            end.setDate(end.getDate() + 6);
            const opts = { month: 'short', day: 'numeric' };
            const startStr = start.toLocaleString('{{ $locale }}', opts);
            if (start.getMonth() === end.getMonth()) {
                return startStr + ' – ' + end.getDate() + ', ' + start.getFullYear();
            }
            const endStr = end.toLocaleString('{{ $locale }}', opts);
            return startStr + ' – ' + endStr + ', ' + end.getFullYear();
        },

        get dayTitle() {
            return this.currentDate.toLocaleString('{{ $locale }}', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        },

        get days() {
            const first = new Date(this.year, this.month, 1);
            const last = new Date(this.year, this.month + 1, 0);
            let startDay = first.getDay() - this.startOfWeek;
            if (startDay < 0) startDay += 7;
            const cells = [];
            for (let i = startDay - 1; i >= 0; i--) {
                const d = new Date(this.year, this.month, -i);
                cells.push({ date: d, current: false });
            }
            for (let i = 1; i <= last.getDate(); i++) {
                cells.push({ date: new Date(this.year, this.month, i), current: true });
            }
            while (cells.length < 42) {
                const d = new Date(this.year, this.month + 1, cells.length - last.getDate() - startDay + 1);
                cells.push({ date: d, current: false });
            }
            return cells;
        },

        get weekStart() {
            const d = new Date(this.currentDate);
            let diff = d.getDay() - this.startOfWeek;
            if (diff < 0) diff += 7;
            d.setDate(d.getDate() - diff);
            d.setHours(0, 0, 0, 0);
            return d;
        },

        get weekDays() {
            const days = [];
            for (let i = 0; i < 7; i++) {
                const d = new Date(this.weekStart);
                d.setDate(d.getDate() + i);
                days.push(d);
            }
            return days;
        },

        get hours() {
            const hrs = [];
            for (let h = this.businessHoursStart; h <= this.businessHoursEnd; h++) {
                hrs.push(h);
            }
            return hrs;
        },

        formatHour(h) {
            return String(h).padStart(2, '0') + ':00';
        },

        formatDayHeader(date) {
            return date.toLocaleString('{{ $locale }}', { weekday: 'short', day: 'numeric' });
        },

        isToday(date) {
            const today = new Date();
            return date.toDateString() === today.toDateString();
        },

        dateStr(date) {
            return date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
        },

        getEvents(date) {
            const ds = this.dateStr(date);
            return this.events.filter(e => e[this.eventDateKey] === ds);
        },

        getAllDayEvents(date) {
            return this.getEvents(date).filter(e => !e[this.eventStartKey]);
        },

        getTimedEvents(date) {
            return this.getEvents(date).filter(e => !!e[this.eventStartKey]);
        },

        getEventsForHour(date, hour) {
            return this.getTimedEvents(date).filter(e => {
                const parts = e[this.eventStartKey].split(':');
                return parseInt(parts[0]) === hour;
            });
        },

        prev() {
            if (this.view === 'month') this.prevMonth();
            else if (this.view === 'week') this.prevWeek();
            else this.prevDay();
        },

        next() {
            if (this.view === 'month') this.nextMonth();
            else if (this.view === 'week') this.nextWeek();
            else this.nextDay();
        },

        prevMonth() { this.currentDate = new Date(this.year, this.month - 1, 1); },
        nextMonth() { this.currentDate = new Date(this.year, this.month + 1, 1); },

        prevWeek() {
            const d = new Date(this.currentDate);
            d.setDate(d.getDate() - 7);
            this.currentDate = d;
        },

        nextWeek() {
            const d = new Date(this.currentDate);
            d.setDate(d.getDate() + 7);
            this.currentDate = d;
        },

        prevDay() {
            const d = new Date(this.currentDate);
            d.setDate(d.getDate() - 1);
            this.currentDate = d;
        },

        nextDay() {
            const d = new Date(this.currentDate);
            d.setDate(d.getDate() + 1);
            this.currentDate = d;
        },

        goToday() { this.currentDate = new Date(); }
    }"
    {{ $attributes }}
>
    {{-- HEADER --}}
    <div class="aura-calendar-header flex items-center justify-between px-4 py-3 border-b border-aura-surface-200 bg-aura-surface-50">
        <div class="flex items-center gap-1">
            <button type="button" class="aura-calendar-nav inline-flex items-center justify-center w-8 h-8 rounded-aura-md text-aura-surface-500 bg-transparent border-none cursor-pointer aura-transition-fast hover:bg-aura-surface-200 hover:text-aura-surface-900" @click="prev()" :aria-label="view === 'month' ? 'Previous month' : view === 'week' ? 'Previous week' : 'Previous day'">
                <x-aura::icon name="chevron-left" size="sm" />
            </button>
            <button type="button" class="aura-calendar-nav inline-flex items-center justify-center w-8 h-8 rounded-aura-md text-aura-surface-500 bg-transparent border-none cursor-pointer aura-transition-fast hover:bg-aura-surface-200 hover:text-aura-surface-900" @click="goToday()" aria-label="Today">
                <x-aura::icon name="circle" size="xs" />
            </button>
            <button type="button" class="aura-calendar-nav inline-flex items-center justify-center w-8 h-8 rounded-aura-md text-aura-surface-500 bg-transparent border-none cursor-pointer aura-transition-fast hover:bg-aura-surface-200 hover:text-aura-surface-900" @click="next()" :aria-label="view === 'month' ? 'Next month' : view === 'week' ? 'Next week' : 'Next day'">
                <x-aura::icon name="chevron-right" size="sm" />
            </button>
        </div>

        <span class="aura-calendar-title text-sm font-semibold text-aura-surface-900 capitalize" x-text="title"></span>

        <div class="aura-calendar-views flex items-center gap-0.5 bg-aura-surface-100 rounded-aura-md p-0.5">
            <button type="button" class="aura-calendar-view-btn px-2.5 py-1 text-xs font-medium rounded-aura-sm aura-transition-fast cursor-pointer border-none" :class="view === 'month' ? 'bg-aura-surface-0 shadow-sm text-aura-surface-900' : 'bg-transparent text-aura-surface-500 hover:text-aura-surface-700'" @click="view = 'month'" aria-label="Month view">Month</button>
            <button type="button" class="aura-calendar-view-btn px-2.5 py-1 text-xs font-medium rounded-aura-sm aura-transition-fast cursor-pointer border-none" :class="view === 'week' ? 'bg-aura-surface-0 shadow-sm text-aura-surface-900' : 'bg-transparent text-aura-surface-500 hover:text-aura-surface-700'" @click="view = 'week'" aria-label="Week view">Week</button>
            <button type="button" class="aura-calendar-view-btn px-2.5 py-1 text-xs font-medium rounded-aura-sm aura-transition-fast cursor-pointer border-none" :class="view === 'day' ? 'bg-aura-surface-0 shadow-sm text-aura-surface-900' : 'bg-transparent text-aura-surface-500 hover:text-aura-surface-700'" @click="view = 'day'" aria-label="Day view">Day</button>
        </div>
    </div>

    {{-- MONTH VIEW --}}
    <div x-show="view === 'month'" class="aura-calendar-month">
        <div class="aura-calendar-grid grid grid-cols-7">
            @foreach($dayNames as $day)
                <div class="aura-calendar-dayname py-2 text-center text-xs font-semibold text-aura-surface-400 uppercase">{{ $day }}</div>
            @endforeach

            <template x-for="(cell, index) in days" :key="index">
                <div
                    class="aura-calendar-cell min-h-[80px] p-1.5 border-t border-r border-aura-surface-100 last:border-r-0 [&:nth-child(7n+7)]:border-r-0"
                    x-bind:class="{
                        'aura-calendar-today bg-aura-primary-50/50': isToday(cell.date),
                        'aura-calendar-other': !cell.current
                    }"
                >
                    <span class="aura-calendar-date inline-flex items-center justify-center w-6 h-6 text-xs font-medium rounded-full" x-bind:class="{ 'text-aura-surface-300': !cell.current, 'text-aura-surface-700': cell.current, 'bg-aura-primary-500 text-white': isToday(cell.date) }" x-text="cell.date.getDate()"></span>
                    <template x-for="ev in getEvents(cell.date)" :key="ev[eventTitleKey]">
                        <div
                            class="aura-calendar-event mt-0.5 px-1 py-0.5 text-[10px] font-medium text-white rounded truncate"
                            x-bind:style="ev[eventColorKey] ? 'background-color: ' + ev[eventColorKey] : 'background-color: var(--color-aura-primary-500)'"
                            x-text="ev[eventTitleKey]"
                        ></div>
                    </template>
                </div>
            </template>
        </div>
    </div>

    {{-- WEEK VIEW --}}
    <div x-show="view === 'week'" class="aura-calendar-week">
        <div class="aura-calendar-week-header grid border-b border-aura-surface-200" style="grid-template-columns: 60px repeat(7, 1fr)">
            <div class="py-2"></div>
            <template x-for="(day, i) in weekDays" :key="'wh-'+i">
                <div class="py-2 text-center border-l border-aura-surface-100" :class="isToday(day) ? 'bg-aura-primary-50/50' : ''">
                    <span class="text-xs font-semibold" :class="isToday(day) ? 'text-aura-primary-600' : 'text-aura-surface-600'" x-text="formatDayHeader(day)"></span>
                </div>
            </template>
        </div>

        <div class="aura-calendar-week-allday grid border-b border-aura-surface-200" style="grid-template-columns: 60px repeat(7, 1fr)">
            <div class="px-2 py-1 text-[10px] text-aura-surface-400 text-right self-center">All day</div>
            <template x-for="(day, i) in weekDays" :key="'wa-'+i">
                <div class="p-0.5 border-l border-aura-surface-100 min-h-[32px]" :class="isToday(day) ? 'bg-aura-primary-50/30' : ''">
                    <template x-for="ev in getAllDayEvents(day)" :key="ev[eventTitleKey]">
                        <div
                            class="aura-calendar-event px-1 py-0.5 text-[10px] font-medium text-white rounded truncate"
                            x-bind:style="ev[eventColorKey] ? 'background-color: ' + ev[eventColorKey] : 'background-color: var(--color-aura-primary-500)'"
                            x-text="ev[eventTitleKey]"
                        ></div>
                    </template>
                </div>
            </template>
        </div>

        <div class="aura-calendar-week-body overflow-y-auto max-h-[480px]">
            <template x-for="hour in hours" :key="'wg-'+hour">
                <div class="grid border-b border-aura-surface-100" style="grid-template-columns: 60px repeat(7, 1fr)">
                    <div class="px-2 py-1 text-[10px] text-aura-surface-400 text-right self-start" x-text="formatHour(hour)"></div>
                    <template x-for="(day, i) in weekDays" :key="'wc-'+hour+'-'+i">
                        <div class="min-h-[48px] p-0.5 border-l border-aura-surface-100" :class="isToday(day) ? 'bg-aura-primary-50/30' : ''">
                            <template x-for="ev in getEventsForHour(day, hour)" :key="ev[eventTitleKey]">
                                <div
                                    class="aura-calendar-event px-1.5 py-0.5 text-[10px] font-medium text-white rounded truncate"
                                    x-bind:style="ev[eventColorKey] ? 'background-color: ' + ev[eventColorKey] : 'background-color: var(--color-aura-primary-500)'"
                                    x-text="ev[eventStartKey] + ' ' + ev[eventTitleKey]"
                                ></div>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>

    {{-- DAY VIEW --}}
    <div x-show="view === 'day'" class="aura-calendar-day">
        <div class="aura-calendar-day-allday flex border-b border-aura-surface-200">
            <div class="w-[60px] shrink-0 px-2 py-1 text-[10px] text-aura-surface-400 text-right self-center">All day</div>
            <div class="flex-1 p-0.5 border-l border-aura-surface-100 min-h-[32px]">
                <template x-for="ev in getAllDayEvents(currentDate)" :key="ev[eventTitleKey]">
                    <div
                        class="aura-calendar-event px-1.5 py-1 text-xs font-medium text-white rounded truncate mb-0.5"
                        x-bind:style="ev[eventColorKey] ? 'background-color: ' + ev[eventColorKey] : 'background-color: var(--color-aura-primary-500)'"
                        x-text="ev[eventTitleKey]"
                    ></div>
                </template>
            </div>
        </div>

        <div class="aura-calendar-day-body overflow-y-auto max-h-[480px]">
            <template x-for="hour in hours" :key="'dg-'+hour">
                <div class="flex border-b border-aura-surface-100">
                    <div class="w-[60px] shrink-0 px-2 py-1 text-[10px] text-aura-surface-400 text-right self-start" x-text="formatHour(hour)"></div>
                    <div class="flex-1 min-h-[48px] p-0.5 border-l border-aura-surface-100">
                        <template x-for="ev in getEventsForHour(currentDate, hour)" :key="ev[eventTitleKey]">
                            <div
                                class="aura-calendar-event px-1.5 py-1 text-xs font-medium text-white rounded truncate mb-0.5"
                                x-bind:style="ev[eventColorKey] ? 'background-color: ' + ev[eventColorKey] : 'background-color: var(--color-aura-primary-500)'"
                                x-text="ev[eventStartKey] + ' ' + ev[eventTitleKey]"
                            ></div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
