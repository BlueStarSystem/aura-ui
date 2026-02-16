<style>
/* Playground-specific styles — NOT component CSS (handled by Tailwind) */

/* Smooth scrollbar for sidebar */
.playground-nav::-webkit-scrollbar { width: 4px; }
.playground-nav::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.15); border-radius: 4px; }

/* Active nav link highlight */
.playground-nav a.active {
    background: var(--color-aura-primary-50);
    color: var(--color-aura-primary-600);
    font-weight: 500;
}
.dark .playground-nav a.active {
    background: rgba(99, 102, 241, 0.1);
    color: var(--color-aura-primary-400);
}

/* Section spacing */
.playground-section + .playground-section { margin-top: 3rem; }

/* Hide x-cloak elements */
[x-cloak] { display: none !important; }
</style>
