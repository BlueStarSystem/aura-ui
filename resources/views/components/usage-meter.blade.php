@props([
    'used' => 0,
    'limit' => 100,
    'label' => null,
    'unit' => null,
    'warnAt' => 75,
    'dangerAt' => 90,
    'showValues' => true,
])

@php
    /**
     * Usage against a quota — storage, seats, API calls.
     *
     * The bar changes colour as it fills, and colour alone is not information:
     * the state is also written into the accessible name, so someone who
     * cannot see the amber knows they are close to the limit.
     */
    $limitValue = max(0.0001, (float) $limit);
    $usedValue = max(0, (float) $used);
    $percent = min(100, round(($usedValue / $limitValue) * 100));

    $state = match (true) {
        $percent >= $dangerAt => 'danger',
        $percent >= $warnAt => 'warning',
        default => 'normal',
    };

    $barClass = match ($state) {
        'danger' => 'bg-aura-danger-600',
        'warning' => 'bg-aura-warning-600',
        default => 'bg-aura-primary-600',
    };

    $meterLabel = $label ?? __('aura-ui::messages.usage');

    $spoken = $meterLabel.': '.__('aura-ui::messages.usage_of', [
        'used' => trim($usedValue.' '.($unit ?? '')),
        'limit' => trim($limitValue.' '.($unit ?? '')),
    ]).($state === 'normal' ? '' : ', '.__('aura-ui::messages.usage_'.$state));
@endphp

<div {{ $attributes->class(['aura-usage-meter']) }}>
    @if($showValues)
        <div class="aura-usage-meter-head mb-1.5 flex items-baseline justify-between gap-3 text-sm">
            <span class="aura-usage-meter-label font-medium text-aura-surface-900">{{ $meterLabel }}</span>

            <span class="aura-usage-meter-values text-aura-surface-600" aria-hidden="true">
                {{ $usedValue }}@if($unit) {{ $unit }}@endif / {{ $limitValue }}@if($unit) {{ $unit }}@endif
            </span>
        </div>
    @endif

    <div
        class="aura-usage-meter-track h-2 w-full overflow-hidden rounded-aura-full bg-aura-surface-200"
        role="progressbar"
        aria-label="{{ $spoken }}"
        aria-valuenow="{{ $percent }}"
        aria-valuemin="0"
        aria-valuemax="100"
    >
        <div class="aura-usage-meter-bar aura-usage-meter-{{ $state }} h-full rounded-aura-full aura-transition {{ $barClass }}" style="width: {{ $percent }}%"></div>
    </div>

    @if($state !== 'normal')
        {{-- Written as well as coloured: the amber says nothing to someone who
             cannot see it. --}}
        <p class="aura-usage-meter-note mt-1.5 text-xs font-medium {{ $state === 'danger' ? 'text-aura-danger-700 dark:text-aura-danger-400' : 'text-aura-warning-700 dark:text-aura-warning-400' }}">
            {{ __('aura-ui::messages.usage_'.$state) }}
        </p>
    @endif
</div>
