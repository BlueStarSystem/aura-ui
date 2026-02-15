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
    class="aura-calendar"
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
    <div class="aura-calendar-header">
        <button type="button" class="aura-calendar-nav" @click="prevMonth()" aria-label="Previous month">
            <x-aura::icon name="chevron-left" size="sm" />
        </button>
        <span class="aura-calendar-title" x-text="monthName"></span>
        <button type="button" class="aura-calendar-nav" @click="goToday()" aria-label="Today">
            <x-aura::icon name="circle" size="xs" />
        </button>
        <button type="button" class="aura-calendar-nav" @click="nextMonth()" aria-label="Next month">
            <x-aura::icon name="chevron-right" size="sm" />
        </button>
    </div>

    <div class="aura-calendar-grid">
        @foreach($dayNames as $day)
            <div class="aura-calendar-dayname">{{ $day }}</div>
        @endforeach

        <template x-for="(cell, index) in days" :key="index">
            <div
                class="aura-calendar-cell"
                x-bind:class="{
                    'aura-calendar-today': isToday(cell.date),
                    'aura-calendar-other': !cell.current
                }"
            >
                <span class="aura-calendar-date" x-text="cell.date.getDate()"></span>
                <template x-for="ev in getEvents(cell.date)" :key="ev[eventTitleKey]">
                    <div
                        class="aura-calendar-event"
                        x-bind:style="ev[eventColorKey] ? 'background-color: ' + ev[eventColorKey] : ''"
                        x-text="ev[eventTitleKey]"
                    ></div>
                </template>
            </div>
        </template>
    </div>
</div>
