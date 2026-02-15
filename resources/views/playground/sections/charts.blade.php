<section id="charts" class="aura-playground-section">
    <h2 class="aura-section-title">Charts</h2>
    <p class="aura-section-description" style="margin-bottom: 16px; font-size: 0.85rem; color: var(--aura-text-tertiary);">Requires Chart.js CDN: <code>&lt;script src="https://cdn.jsdelivr.net/npm/chart.js@4"&gt;</code></p>

    <h3 class="aura-section-subtitle">Line Chart</h3>
    <div class="aura-component-row">
        <div style="max-width: 600px; width: 100%;">
            <x-aura::chart
                type="line"
                :labels="['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']"
                :datasets="[
                    ['label' => 'Revenue', 'data' => [12, 19, 3, 5, 2, 15], 'borderColor' => '#6366f1', 'tension' => 0.3],
                    ['label' => 'Expenses', 'data' => [8, 11, 5, 8, 3, 10], 'borderColor' => '#06b6d4', 'tension' => 0.3],
                ]"
                height="250px"
            />
        </div>
    </div>

    <h3 class="aura-section-subtitle">Bar Chart</h3>
    <div class="aura-component-row">
        <div style="max-width: 600px; width: 100%;">
            <x-aura::chart
                type="bar"
                :labels="['Q1', 'Q2', 'Q3', 'Q4']"
                :datasets="[
                    ['label' => '2025', 'data' => [65, 59, 80, 81], 'backgroundColor' => '#818cf8'],
                    ['label' => '2026', 'data' => [72, 68, 90, 95], 'backgroundColor' => '#22d3ee'],
                ]"
                height="250px"
            />
        </div>
    </div>

    <h3 class="aura-section-subtitle">Doughnut Chart</h3>
    <div class="aura-component-row">
        <div style="max-width: 300px; width: 100%;">
            <x-aura::chart
                type="doughnut"
                :labels="['Direct', 'Referral', 'Social', 'Email']"
                :datasets="[
                    ['data' => [40, 25, 20, 15], 'backgroundColor' => ['#6366f1', '#06b6d4', '#10b981', '#f59e0b']],
                ]"
                height="250px"
            />
        </div>
    </div>
</section>
