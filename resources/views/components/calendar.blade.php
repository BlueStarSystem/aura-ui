@props([
    'events' => [],
    'locale' => 'en',
    'startOfWeek' => 1,
    'eventDateKey' => 'date',
    'eventTitleKey' => 'title',
    'eventColorKey' => 'color',
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
        currentDate: new Date(),
        events: {{ Js::from($events) }},
        eventDateKey: '{{ $eventDateKey }}',
        eventTitleKey: '{{ $eventTitleKey }}',
        eventColorKey: '{{ $eventColorKey }}',
        startOfWeek: {{ (int)$startOfWeek }},
        get year() { return this.currentDate.getFullYear(); },
        get month() { return this.currentDate.getMonth(); },
        get monthName() {
            return this.currentDate.toLocaleString('{{ $locale }}', { month: 'long', year: 'numeric' });
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
        isToday(date) {
            const today = new Date();
            return date.toDateString() === today.toDateString();
        },
        getEvents(date) {
            const dateStr = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
            return this.events.filter(e => e[this.eventDateKey] === dateStr);
        },
        prevMonth() {
            this.currentDate = new Date(this.year, this.month - 1, 1);
        },
        nextMonth() {
            this.currentDate = new Date(this.year, this.month + 1, 1);
        },
        goToday() {
            this.currentDate = new Date();
        }
    }"
    {{ $attributes }}
>
    <div class="aura-calendar-header flex items-center justify-between px-4 py-3 border-b border-aura-surface-200 bg-aura-surface-50">
        <button type="button" class="aura-calendar-nav inline-flex items-center justify-center w-8 h-8 rounded-aura-md text-aura-surface-500 bg-transparent border-none cursor-pointer aura-transition-fast hover:bg-aura-surface-200 hover:text-aura-surface-900" @click="prevMonth()" aria-label="Previous month">
            <x-aura::icon name="chevron-left" size="sm" />
        </button>
        <span class="aura-calendar-title text-sm font-semibold text-aura-surface-900 capitalize" x-text="monthName"></span>
        <button type="button" class="aura-calendar-nav inline-flex items-center justify-center w-8 h-8 rounded-aura-md text-aura-surface-500 bg-transparent border-none cursor-pointer aura-transition-fast hover:bg-aura-surface-200 hover:text-aura-surface-900" @click="goToday()" aria-label="Today">
            <x-aura::icon name="circle" size="xs" />
        </button>
        <button type="button" class="aura-calendar-nav inline-flex items-center justify-center w-8 h-8 rounded-aura-md text-aura-surface-500 bg-transparent border-none cursor-pointer aura-transition-fast hover:bg-aura-surface-200 hover:text-aura-surface-900" @click="nextMonth()" aria-label="Next month">
            <x-aura::icon name="chevron-right" size="sm" />
        </button>
    </div>

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
