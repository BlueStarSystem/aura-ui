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
    // Falls back rather than emitting whatever arrived: this lands inside a
    // style attribute, where a semicolon starts a second declaration.
    $safeHeight = \BlueStarSystem\AuraUI\Support\Html::cssValue($height) ?? '300px';
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
   
    style="height: {{ $safeHeight }};"
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
            // Was '/js/vendor/chart.umd.min.js', a path no application ships,
            // so every chart logged a 404 and a blocked-script error before
            // falling back to the CDN. Two charts on a page also fetched the
            // library twice; they share one load now.
            if (window.__auraChartLoading) {
                window.__auraChartLoading.then(() => this.renderChart());
                return;
            }
            window.__auraChartLoading = new Promise((resolve) => {
                const script = document.createElement('script');
                script.src = {!! \Illuminate\Support\Js::from(config('aura-ui.chart.src', 'https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js')) !!};
                script.onload = resolve;
                document.head.appendChild(script);
            });
            window.__auraChartLoading.then(() => this.renderChart());
        },
        destroy() {
            if (this.chart) this.chart.destroy();
        }
    }"
    x-on:destroy="destroy()"
    {{ $attributes->class(['aura-chart relative']) }}
>
    <canvas x-ref="canvas"></canvas>
</div>
