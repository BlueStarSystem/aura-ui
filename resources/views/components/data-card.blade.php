@props([
    'title' => '',
    'value' => '',
    'change' => null,
    'changeType' => 'neutral',
    'icon' => null,
    'sparkline' => null,
    'href' => null,
])

@php
    $tag = $href ? 'a' : 'div';
    $extraAttrs = $href ? 'href="' . e($href) . '"' : '';
    $changeClass = match($changeType) {
        'positive' => 'aura-data-card__change--positive',
        'negative' => 'aura-data-card__change--negative',
        default => 'aura-data-card__change--neutral',
    };
@endphp

<{{ $tag }}
    {!! $extraAttrs !!}
    {{ $attributes->class([
        'aura-data-card',
        'aura-data-card--clickable' => (bool) $href,
    ]) }}
>
    <div class="aura-data-card__header">
        @if ($icon)
            <div class="aura-data-card__icon">
                <x-aura::icon :name="$icon" class="w-5 h-5" />
            </div>
        @endif
        <span class="aura-data-card__title">{{ $title }}</span>
    </div>

    <div class="aura-data-card__body">
        <span class="aura-data-card__value">{{ $value }}</span>

        @if ($change)
            <span class="aura-data-card__change {{ $changeClass }}">
                @if ($changeType === 'positive')
                    <svg class="aura-data-card__change-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.577 4.878a.75.75 0 0 1 .919-.53l4.78 1.281a.75.75 0 0 1 .531.919l-1.281 4.78a.75.75 0 0 1-1.449-.387l.81-3.022a19.407 19.407 0 0 1-5.594 5.203c-2.127 1.364-4.513 2.159-6.06 2.159a.75.75 0 0 1 0-1.5c1.202 0 3.264-.673 5.192-1.91a17.91 17.91 0 0 0 5.143-4.747l-3.02.81a.75.75 0 0 1-.388-1.45l.417-.112Z" clip-rule="evenodd"/></svg>
                @elseif ($changeType === 'negative')
                    <svg class="aura-data-card__change-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M1.22 5.222a.75.75 0 0 1 1.06 0L7 9.942l3.768-3.769a.75.75 0 0 1 1.113.058 20.908 20.908 0 0 1 3.813 7.254l1.574-2.727a.75.75 0 0 1 1.3.75l-2.475 4.286a.75.75 0 0 1-1.025.275l-4.287-2.475a.75.75 0 0 1 .75-1.3l2.71 1.565a19.422 19.422 0 0 0-3.013-5.88L7.53 11.533a.75.75 0 0 1-1.06 0l-5.25-5.25a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                @endif
                {{ $change }}
            </span>
        @endif
    </div>

    @if ($sparkline)
        <div class="aura-data-card__sparkline"
            x-data="{
                values: {{ Js::from($sparkline) }},
                get path() {
                    const v = this.values;
                    if (!v.length) return '';
                    const max = Math.max(...v);
                    const min = Math.min(...v);
                    const range = max - min || 1;
                    const w = 120;
                    const h = 32;
                    const step = w / (v.length - 1);
                    return v.map((val, i) => {
                        const x = i * step;
                        const y = h - ((val - min) / range) * h;
                        return (i === 0 ? 'M' : 'L') + x.toFixed(1) + ',' + y.toFixed(1);
                    }).join(' ');
                },
            }"
        >
            <svg viewBox="0 0 120 32" preserveAspectRatio="none" class="aura-data-card__sparkline-svg">
                <path :d="path" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    @endif

    @if (isset($footer))
        <div class="aura-data-card__footer">
            {{ $footer }}
        </div>
    @endif
</{{ $tag }}>
