<section id="stats-cards" class="aura-playground-section">
    <h2 class="aura-section-title">Stats Card</h2>

    <h3 class="aura-section-subtitle">Dashboard Grid</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
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
</section>
