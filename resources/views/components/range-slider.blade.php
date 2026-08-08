@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'from' => null,
    'to' => null,
    'color' => 'primary',
    'showValues' => true,
    'prefix' => null,
    'suffix' => null,
])

@php
    use BlueStarSystem\AuraUI\Support\Html;

    $groupId = Html::fieldId($attributes->get('id'), $attributes->get('name'), $label, Html::wireModelFrom($attributes->getAttributes()));
    $descriptionId = $groupId.'-description';

    $min = (float) $min;
    $max = (float) $max;
    $from = $from === null ? $min : (float) $from;
    $to = $to === null ? $max : (float) $to;

    $colorClass = match($color) {
        'success' => 'aura-range-slider--success',
        'danger' => 'aura-range-slider--danger',
        'warning' => 'aura-range-slider--warning',
        default => 'aura-range-slider--primary',
    };
@endphp

{{--
    Two native <input type="range"> stacked on one track, rather than divs and
    pointer maths. Keyboard support, the browser's own value announcements and
    every assistive technology come for free — a custom-drawn range slider has
    to reimplement all of it, and usually does not.
--}}
<div
    {{ $attributes->except(['id', 'name'])->class(['aura-range-slider flex flex-col gap-1.5 w-full max-w-[340px]', $colorClass, 'aura-has-error' => (bool) $error]) }}
    x-data="{
        min: {{ Js::from($min) }},
        max: {{ Js::from($max) }},
        from: {{ Js::from($from) }},
        to: {{ Js::from($to) }},
        get span() { return this.max - this.min || 1 },
        get startPercent() { return ((Math.min(this.from, this.to) - this.min) / this.span) * 100 },
        get endPercent() { return ((Math.max(this.from, this.to) - this.min) / this.span) * 100 },
    }"
>
    @if($label)
        <div class="flex items-baseline justify-between gap-3">
            <span class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">{{ $label }}</span>

            @if($showValues)
                <span class="aura-range-slider-values text-xs tabular-nums text-aura-surface-700">
                    {{ $prefix }}<span x-text="Math.min(from, to)"></span>{{ $suffix }}
                    &ndash;
                    {{ $prefix }}<span x-text="Math.max(from, to)"></span>{{ $suffix }}
                </span>
            @endif
        </div>
    @endif

    <div class="aura-range-slider-track relative h-6">
        <div class="absolute inset-x-0 top-1/2 h-1.5 -translate-y-1/2 rounded-full bg-aura-surface-300"></div>

        <div
            class="aura-range-slider-fill absolute top-1/2 h-1.5 -translate-y-1/2 rounded-full bg-aura-primary-600"
            x-bind:style="'left:' + startPercent + '%; width:' + (endPercent - startPercent) + '%'"
        ></div>

        <input
            type="range"
            id="{{ $groupId }}-from"
            name="{{ $attributes->get('name') ? $attributes->get('name').'[from]' : null }}"
            min="{{ $min }}" max="{{ $max }}" step="{{ $step }}"
            x-model.number="from"
            aria-label="{{ $label ? $label.' — '.__('aura-ui::messages.minimum') : __('aura-ui::messages.minimum') }}"
            @if($error) aria-invalid="true" @endif
            @if($error || $hint) aria-describedby="{{ $descriptionId }}" @endif
            class="aura-range-slider-input absolute inset-x-0 top-0 h-6 w-full appearance-none bg-transparent"
        />

        <input
            type="range"
            id="{{ $groupId }}-to"
            name="{{ $attributes->get('name') ? $attributes->get('name').'[to]' : null }}"
            min="{{ $min }}" max="{{ $max }}" step="{{ $step }}"
            x-model.number="to"
            aria-label="{{ $label ? $label.' — '.__('aura-ui::messages.maximum') : __('aura-ui::messages.maximum') }}"
            @if($error) aria-invalid="true" @endif
            @if($error || $hint) aria-describedby="{{ $descriptionId }}" @endif
            class="aura-range-slider-input absolute inset-x-0 top-0 h-6 w-full appearance-none bg-transparent"
        />
    </div>

    @if($error)
        <p id="{{ $descriptionId }}" role="alert" class="aura-input-error-text text-xs text-aura-danger-700 dark:text-aura-danger-500 font-medium">{{ $error }}</p>
    @elseif($hint)
        <p id="{{ $descriptionId }}" class="aura-input-hint text-xs text-aura-surface-600 leading-snug">{{ $hint }}</p>
    @endif
</div>
