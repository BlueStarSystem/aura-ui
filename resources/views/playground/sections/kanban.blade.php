<section id="kanban" class="aura-playground-section">
    <h2 class="aura-section-title">Kanban Board</h2>

    <h3 class="aura-section-subtitle">Project Board</h3>
    <div class="aura-component-row">
        <x-aura::kanban>
            <x-aura::kanban.column title="Backlog" columnId="backlog" color="#94a3b8" :count="3">
                <x-aura::kanban.card cardId="1" columnId="backlog">
                    <strong style="font-size: 0.85rem;">Setup CI/CD pipeline</strong>
                    <p style="font-size: 0.75rem; color: var(--aura-text-tertiary); margin-top: 4px;">Configure GitHub Actions for automated deployment</p>
                </x-aura::kanban.card>
                <x-aura::kanban.card cardId="2" columnId="backlog">
                    <strong style="font-size: 0.85rem;">Write API docs</strong>
                </x-aura::kanban.card>
                <x-aura::kanban.card cardId="3" columnId="backlog">
                    <strong style="font-size: 0.85rem;">Add dark mode</strong>
                </x-aura::kanban.card>
            </x-aura::kanban.column>

            <x-aura::kanban.column title="In Progress" columnId="progress" color="#6366f1" :count="2">
                <x-aura::kanban.card cardId="4" columnId="progress">
                    <strong style="font-size: 0.85rem;">Implement auth system</strong>
                    <p style="font-size: 0.75rem; color: var(--aura-text-tertiary); margin-top: 4px;">JWT + refresh tokens</p>
                </x-aura::kanban.card>
                <x-aura::kanban.card cardId="5" columnId="progress">
                    <strong style="font-size: 0.85rem;">Design landing page</strong>
                </x-aura::kanban.card>
            </x-aura::kanban.column>

            <x-aura::kanban.column title="Review" columnId="review" color="#f59e0b" :count="1">
                <x-aura::kanban.card cardId="6" columnId="review">
                    <strong style="font-size: 0.85rem;">User settings page</strong>
                    <p style="font-size: 0.75rem; color: var(--aura-text-tertiary); margin-top: 4px;">Awaiting design review</p>
                </x-aura::kanban.card>
            </x-aura::kanban.column>

            <x-aura::kanban.column title="Done" columnId="done" color="#10b981" :count="2">
                <x-aura::kanban.card cardId="7" columnId="done" :draggable="false">
                    <strong style="font-size: 0.85rem;">Database schema</strong>
                </x-aura::kanban.card>
                <x-aura::kanban.card cardId="8" columnId="done" :draggable="false">
                    <strong style="font-size: 0.85rem;">Project setup</strong>
                </x-aura::kanban.card>
            </x-aura::kanban.column>
        </x-aura::kanban>
    </div>
</section>
