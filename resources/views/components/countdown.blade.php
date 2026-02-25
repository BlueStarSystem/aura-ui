@props([
    'target' => null,
    'seconds' => null,
    'size' => 'md',
    'separator' => ':',
    'labels' => true,
])

@php
    $sizeClass = match($size) {
        'sm' => 'text-lg',
        'lg' => 'text-5xl',
        default => 'text-3xl',
    };

    $labelSize = match($size) {
        'sm' => 'text-[10px]',
        'lg' => 'text-sm',
        default => 'text-xs',
    };
@endphp

<div x-data="{
        remaining: 0,
        days: 0, hours: 0, minutes: 0, secs: 0,
        interval: null,
        init() {
            @if($target)
                const target = new Date('{{ $target }}').getTime();
                this.remaining = Math.max(0, Math.floor((target - Date.now()) / 1000));
            @elseif($seconds)
                this.remaining = {{ (int)$seconds }};
            @endif
            this.update();
            this.interval = setInterval(() => {
                if (this.remaining > 0) { this.remaining--; this.update(); }
                else { clearInterval(this.interval); $dispatch('countdown-finished'); }
            }, 1000);
        },
        update() {
            this.days = Math.floor(this.remaining / 86400);
            this.hours = Math.floor((this.remaining % 86400) / 3600);
            this.minutes = Math.floor((this.remaining % 3600) / 60);
            this.secs = this.remaining % 60;
        },
        pad(n) { return String(n).padStart(2, '0'); },
        destroy() { clearInterval(this.interval); }
     }"
     {{ $attributes->class(['aura-countdown inline-flex items-center gap-2 font-mono tabular-nums', $sizeClass]) }}
     role="timer">

    <template x-if="days > 0">
        <div class="aura-countdown-segment flex flex-col items-center">
            <span x-text="pad(days)" class="font-bold"></span>
            @if($labels)<span class="{{ $labelSize }} text-aura-surface-400 uppercase tracking-wider">days</span>@endif
        </div>
    </template>
    <template x-if="days > 0">
        <span class="aura-countdown-sep text-aura-surface-300 -mt-4">{{ $separator }}</span>
    </template>

    <div class="aura-countdown-segment flex flex-col items-center">
        <span x-text="pad(hours)" class="font-bold"></span>
        @if($labels)<span class="{{ $labelSize }} text-aura-surface-400 uppercase tracking-wider">hrs</span>@endif
    </div>
    <span class="aura-countdown-sep text-aura-surface-300 {{ $labels ? '-mt-4' : '' }}">{{ $separator }}</span>

    <div class="aura-countdown-segment flex flex-col items-center">
        <span x-text="pad(minutes)" class="font-bold"></span>
        @if($labels)<span class="{{ $labelSize }} text-aura-surface-400 uppercase tracking-wider">min</span>@endif
    </div>
    <span class="aura-countdown-sep text-aura-surface-300 {{ $labels ? '-mt-4' : '' }}">{{ $separator }}</span>

    <div class="aura-countdown-segment flex flex-col items-center">
        <span x-text="pad(secs)" class="font-bold"></span>
        @if($labels)<span class="{{ $labelSize }} text-aura-surface-400 uppercase tracking-wider">sec</span>@endif
    </div>
</div>
