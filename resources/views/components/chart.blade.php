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
    class="aura-chart relative"
    style="height: {{ $height }};"
    x-data="{
        chart: null,
        renderChart() {
            const ctx = this.$refs.canvas.getContext('2d');
            this.chart = new Chart(ctx, {{ Js::from(json_decode($chartConfig, true)) }});
        },
        init() {
            if (typeof Chart !== 'undefined') {
                this.renderChart();
                return;
            }
            const script = document.createElement('script');
            script.src = '/js/vendor/chart.umd.min.js';
            script.onload = () => this.renderChart();
            script.onerror = () => {
                const cdn = document.createElement('script');
                cdn.src = 'https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js';
                cdn.onload = () => this.renderChart();
                document.head.appendChild(cdn);
            };
            document.head.appendChild(script);
        },
        destroy() {
            if (this.chart) this.chart.destroy();
        }
    }"
    x-on:destroy="destroy()"
    {{ $attributes }}
>
    <canvas x-ref="canvas"></canvas>
</div>
