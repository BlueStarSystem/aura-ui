<section id="calendar" class="aura-playground-section">
    <h2 class="aura-section-title">Calendar</h2>

    <h3 class="aura-section-subtitle">Monthly View with Events</h3>
    <div class="aura-component-row">
        <div style="max-width: 700px; width: 100%;">
            <x-aura::calendar :events="[
                ['date' => '2026-02-15', 'title' => 'Team Meeting', 'color' => '#6366f1'],
                ['date' => '2026-02-15', 'title' => 'Code Review', 'color' => '#10b981'],
                ['date' => '2026-02-18', 'title' => 'Sprint Demo', 'color' => '#f59e0b'],
                ['date' => '2026-02-20', 'title' => 'Release v4.0', 'color' => '#ef4444'],
                ['date' => '2026-02-25', 'title' => 'Planning', 'color' => '#06b6d4'],
            ]" />
        </div>
    </div>
</section>
