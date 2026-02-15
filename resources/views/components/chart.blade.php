@props([
    'type' => 'line',
    'labels' => [],
    'datasets' => [],
    'height' => '300px',
    'responsive' => true,
    'legend' => true,
    'options' => [],
])

@php
    $chartId = 'aura-chart-' . uniqid();
    $chartConfig = json_encode([
        'type' => $type === 'area' ? 'line' : $type,
        'data' => [
            'labels' => $labels,
            'datasets' => collect($datasets)->map(function ($ds) use ($type) {
                if ($type === 'area') {
                    $ds['fill'] = true;
                }
                return $ds;
            })->toArray(),
        ],
        'options' => array_merge([
            'responsive' => $responsive,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => ['display' => $legend],
            ],
        ], $options),
    ]);
@endphp

<div
    class="aura-chart"
    style="height: {{ $height }}; position: relative;"
    x-data="{
        chart: null,
        init() {
            if (typeof Chart === 'undefined') {
                console.warn('Chart.js is not loaded. Include Chart.js CDN to use this component.');
                return;
            }
            const ctx = this.$refs.canvas.getContext('2d');
            this.chart = new Chart(ctx, {{ Js::from(json_decode($chartConfig, true)) }});
        },
        destroy() {
            if (this.chart) this.chart.destroy();
        }
    }"
    x-init="init()"
    x-on:destroy="destroy()"
    {{ $attributes }}
>
    <canvas x-ref="canvas"></canvas>
</div>
