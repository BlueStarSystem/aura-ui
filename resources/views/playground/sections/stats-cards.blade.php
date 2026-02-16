<section id="stats-cards" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Stats Card</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Dashboard Grid</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-aura::stats-card
                title="Clienti Totali"
                value="1,234"
                change="+12%"
                changeType="positive"
                icon="users"
            />
            <x-aura::stats-card
                title="Fatturato Mensile"
                value="&euro; 45,678"
                change="+8.2%"
                changeType="positive"
                icon="bar-chart"
            />
            <x-aura::stats-card
                title="Appuntamenti"
                value="156"
                change="-3%"
                changeType="negative"
                icon="calendar"
            />
            <x-aura::stats-card
                title="Tempo Medio"
                value="45 min"
                changeType="neutral"
                icon="clock"
            />
        </div>
    </div>
</section>
