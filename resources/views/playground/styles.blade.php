<style>
/* ============================================================
   AURA UI — "Vibrant Depth" Design System
   Playground & Component Styles
   ============================================================ */

/* -------------------------------------------------------
   1. CSS VARIABLES
   ------------------------------------------------------- */
:root {
    /* Primary Palette */
    --aura-primary-50: #eef2ff;
    --aura-primary-100: #e0e7ff;
    --aura-primary-200: #c7d2fe;
    --aura-primary-300: #a5b4fc;
    --aura-primary-400: #818cf8;
    --aura-primary-500: #6366f1;
    --aura-primary-600: #4f46e5;
    --aura-primary-700: #4338ca;
    --aura-primary-800: #3730a3;
    --aura-primary-900: #312e81;

    /* Secondary (Cyan) */
    --aura-secondary-50: #ecfeff;
    --aura-secondary-100: #cffafe;
    --aura-secondary-200: #a5f3fc;
    --aura-secondary-300: #67e8f9;
    --aura-secondary-400: #22d3ee;
    --aura-secondary-500: #06b6d4;
    --aura-secondary-600: #0891b2;
    --aura-secondary-700: #0e7490;
    --aura-secondary-800: #155e75;
    --aura-secondary-900: #164e63;

    /* Success (Emerald) */
    --aura-success-50: #ecfdf5;
    --aura-success-100: #d1fae5;
    --aura-success-200: #a7f3d0;
    --aura-success-300: #6ee7b7;
    --aura-success-400: #34d399;
    --aura-success-500: #10b981;
    --aura-success-600: #059669;
    --aura-success-700: #047857;
    --aura-success-800: #065f46;
    --aura-success-900: #064e3b;

    /* Warning (Amber) */
    --aura-warning-50: #fffbeb;
    --aura-warning-100: #fef3c7;
    --aura-warning-200: #fde68a;
    --aura-warning-300: #fcd34d;
    --aura-warning-400: #fbbf24;
    --aura-warning-500: #f59e0b;
    --aura-warning-600: #d97706;
    --aura-warning-700: #b45309;
    --aura-warning-800: #92400e;
    --aura-warning-900: #78350f;

    /* Danger (Red) */
    --aura-danger-50: #fef2f2;
    --aura-danger-100: #fee2e2;
    --aura-danger-200: #fecaca;
    --aura-danger-300: #fca5a5;
    --aura-danger-400: #f87171;
    --aura-danger-500: #ef4444;
    --aura-danger-600: #dc2626;
    --aura-danger-700: #b91c1c;
    --aura-danger-800: #991b1b;
    --aura-danger-900: #7f1d1d;

    /* Info (Sky) */
    --aura-info-50: #f0f9ff;
    --aura-info-100: #e0f2fe;
    --aura-info-200: #bae6fd;
    --aura-info-300: #7dd3fc;
    --aura-info-400: #38bdf8;
    --aura-info-500: #0ea5e9;
    --aura-info-600: #0284c7;
    --aura-info-700: #0369a1;
    --aura-info-800: #075985;
    --aura-info-900: #0c4a6e;

    /* Surfaces (Light Mode) */
    --aura-surface-0: #ffffff;
    --aura-surface-50: #f8fafc;
    --aura-surface-100: #f1f5f9;
    --aura-surface-200: #e2e8f0;
    --aura-surface-300: #cbd5e1;
    --aura-surface-400: #94a3b8;
    --aura-surface-500: #64748b;
    --aura-surface-600: #475569;
    --aura-surface-700: #334155;
    --aura-surface-800: #1e293b;
    --aura-surface-900: #0f172a;

    /* Text */
    --aura-text-primary: #0f172a;
    --aura-text-secondary: #475569;
    --aura-text-tertiary: #94a3b8;
    --aura-text-inverse: #ffffff;
    --aura-text-link: var(--aura-primary-500);

    /* Borders */
    --aura-border-light: #e2e8f0;
    --aura-border-default: #cbd5e1;
    --aura-border-strong: #94a3b8;

    /* Multi-layered Shadows */
    --aura-shadow-xs: 0 1px 2px rgba(15, 23, 42, 0.04);
    --aura-shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.06), 0 1px 2px rgba(15, 23, 42, 0.04);
    --aura-shadow-md: 0 4px 6px -1px rgba(15, 23, 42, 0.07), 0 2px 4px -2px rgba(15, 23, 42, 0.05);
    --aura-shadow-lg: 0 10px 15px -3px rgba(15, 23, 42, 0.08), 0 4px 6px -4px rgba(15, 23, 42, 0.05);
    --aura-shadow-xl: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
    --aura-shadow-2xl: 0 25px 50px -12px rgba(15, 23, 42, 0.18);

    /* Glow Shadows (Focus / Interaction) */
    --aura-glow-primary: 0 0 0 3px rgba(99, 102, 241, 0.25);
    --aura-glow-secondary: 0 0 0 3px rgba(6, 182, 212, 0.25);
    --aura-glow-success: 0 0 0 3px rgba(16, 185, 129, 0.25);
    --aura-glow-warning: 0 0 0 3px rgba(245, 158, 11, 0.25);
    --aura-glow-danger: 0 0 0 3px rgba(239, 68, 68, 0.25);
    --aura-glow-info: 0 0 0 3px rgba(14, 165, 233, 0.25);

    /* Gradients */
    --aura-gradient-primary: linear-gradient(135deg, #6366f1 0%, #818cf8 50%, #4f46e5 100%);
    --aura-gradient-secondary: linear-gradient(135deg, #06b6d4 0%, #22d3ee 50%, #0891b2 100%);
    --aura-gradient-success: linear-gradient(135deg, #10b981 0%, #34d399 50%, #059669 100%);
    --aura-gradient-warning: linear-gradient(135deg, #f59e0b 0%, #fbbf24 50%, #d97706 100%);
    --aura-gradient-danger: linear-gradient(135deg, #ef4444 0%, #f87171 50%, #dc2626 100%);
    --aura-gradient-surface: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
    --aura-gradient-glass: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.4) 100%);

    /* Animation Timing */
    --aura-ease-out: cubic-bezier(0.16, 1, 0.3, 1);
    --aura-ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
    --aura-ease-in-out: cubic-bezier(0.4, 0, 0.2, 1);
    --aura-duration-fast: 100ms;
    --aura-duration-normal: 150ms;
    --aura-duration-slow: 250ms;
    --aura-duration-slower: 350ms;

    /* Radii */
    --aura-radius-sm: 6px;
    --aura-radius-md: 8px;
    --aura-radius-lg: 12px;
    --aura-radius-xl: 16px;
    --aura-radius-2xl: 24px;
    --aura-radius-full: 9999px;

    /* Z-Index Scale */
    --aura-z-dropdown: 40;
    --aura-z-sticky: 50;
    --aura-z-modal: 60;
    --aura-z-tooltip: 70;
    --aura-z-command: 75;
    --aura-z-toast: 80;
}

/* -------------------------------------------------------
   2. DARK MODE
   ------------------------------------------------------- */
.dark {
    --aura-surface-0: #0f172a;
    --aura-surface-50: #131c2e;
    --aura-surface-100: #1e293b;
    --aura-surface-200: #293548;
    --aura-surface-300: #334155;
    --aura-surface-400: #475569;
    --aura-surface-500: #64748b;
    --aura-surface-600: #94a3b8;
    --aura-surface-700: #cbd5e1;
    --aura-surface-800: #e2e8f0;
    --aura-surface-900: #f8fafc;

    --aura-text-primary: #f1f5f9;
    --aura-text-secondary: #94a3b8;
    --aura-text-tertiary: #64748b;
    --aura-text-inverse: #0f172a;

    --aura-border-light: #293548;
    --aura-border-default: #334155;
    --aura-border-strong: #475569;

    /* Brighter accents in dark mode */
    --aura-primary-500: #818cf8;
    --aura-secondary-500: #22d3ee;
    --aura-success-500: #34d399;
    --aura-warning-500: #fbbf24;
    --aura-danger-500: #f87171;
    --aura-info-500: #38bdf8;

    --aura-text-link: var(--aura-primary-500);

    /* Stronger glows */
    --aura-glow-primary: 0 0 0 3px rgba(129, 140, 248, 0.35), 0 0 20px rgba(129, 140, 248, 0.1);
    --aura-glow-secondary: 0 0 0 3px rgba(34, 211, 238, 0.35), 0 0 20px rgba(34, 211, 238, 0.1);
    --aura-glow-success: 0 0 0 3px rgba(52, 211, 153, 0.35), 0 0 20px rgba(52, 211, 153, 0.1);
    --aura-glow-warning: 0 0 0 3px rgba(251, 191, 36, 0.35), 0 0 20px rgba(251, 191, 36, 0.1);
    --aura-glow-danger: 0 0 0 3px rgba(248, 113, 113, 0.35), 0 0 20px rgba(248, 113, 113, 0.1);
    --aura-glow-info: 0 0 0 3px rgba(56, 189, 248, 0.35), 0 0 20px rgba(56, 189, 248, 0.1);

    /* Dark shadows */
    --aura-shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.15);
    --aura-shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.2), 0 1px 2px rgba(0, 0, 0, 0.15);
    --aura-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.25), 0 2px 4px -2px rgba(0, 0, 0, 0.15);
    --aura-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -4px rgba(0, 0, 0, 0.15);
    --aura-shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.15);
    --aura-shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.5);

    --aura-gradient-surface: linear-gradient(145deg, #131c2e 0%, #1e293b 100%);
    --aura-gradient-glass: linear-gradient(135deg, rgba(30, 41, 59, 0.8) 0%, rgba(30, 41, 59, 0.4) 100%);
    --aura-gradient-primary: linear-gradient(135deg, #818cf8 0%, #a5b4fc 50%, #6366f1 100%);
}

/* -------------------------------------------------------
   3. PLAYGROUND LAYOUT
   ------------------------------------------------------- */
.aura-body {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, sans-serif;
    font-size: 14px;
    line-height: 1.6;
    color: var(--aura-text-primary);
    background: var(--aura-surface-50);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    transition: background-color var(--aura-duration-slow) var(--aura-ease-in-out),
                color var(--aura-duration-slow) var(--aura-ease-in-out);
}

/* Header */
.aura-playground-header {
    position: fixed;
    top: 0;
    left: 220px;
    right: 0;
    z-index: var(--aura-z-sticky);
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 64px;
    padding: 0 24px;
    background: var(--aura-gradient-glass);
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    border-bottom: 1px solid var(--aura-border-light);
    box-shadow: var(--aura-shadow-sm);
}

.aura-playground-header-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}

.aura-playground-header-label {
    font-size: 14px;
    font-weight: 500;
    color: var(--aura-text-secondary);
}

.aura-playground-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Sidebar Brand */
.aura-sidebar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0 16px 16px;
    margin-bottom: 4px;
    border-bottom: 1px solid var(--aura-border-light);
}

.aura-playground-logo {
    width: 30px;
    height: 30px;
    flex-shrink: 0;
}

.aura-playground-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--aura-text-primary);
    letter-spacing: -0.02em;
    margin: 0;
    line-height: 1.2;
}

.aura-playground-version {
    font-size: 11px;
    font-weight: 600;
    background: var(--aura-gradient-primary);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Dark Mode Toggle */
.aura-dark-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border: 1px solid var(--aura-border-light);
    border-radius: var(--aura-radius-md);
    background: var(--aura-surface-0);
    color: var(--aura-text-secondary);
    cursor: pointer;
    transition: all var(--aura-duration-normal) var(--aura-ease-out);
    font-size: 18px;
    line-height: 1;
}

.aura-dark-toggle:hover {
    background: var(--aura-surface-100);
    color: var(--aura-text-primary);
    border-color: var(--aura-border-default);
    transform: scale(1.05);
    box-shadow: var(--aura-shadow-sm);
}

.aura-dark-toggle:active {
    transform: scale(0.95);
}

/* Sidebar Nav */
.aura-playground-nav {
    position: fixed;
    top: 0;
    left: 0;
    width: 220px;
    height: 100vh;
    overflow-y: auto;
    padding: 16px 0 32px;
    box-sizing: border-box;
    background: var(--aura-surface-0);
    border-right: 1px solid var(--aura-border-light);
    z-index: calc(var(--aura-z-sticky) + 1);
}

.aura-playground-nav::-webkit-scrollbar {
    width: 4px;
}

.aura-playground-nav::-webkit-scrollbar-thumb {
    background: var(--aura-surface-300);
    border-radius: var(--aura-radius-full);
}

.aura-playground-nav-title {
    padding: 8px 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--aura-text-tertiary);
}

.aura-playground-nav a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 450;
    color: var(--aura-text-secondary);
    text-decoration: none;
    border-left: 3px solid transparent;
    transition: all var(--aura-duration-normal) var(--aura-ease-out);
}

.aura-playground-nav a:hover {
    color: var(--aura-primary-500);
    background: var(--aura-primary-50);
    border-left-color: var(--aura-primary-200);
}

.dark .aura-playground-nav a:hover {
    background: rgba(129, 140, 248, 0.08);
}

.aura-playground-nav a.active {
    color: var(--aura-primary-600);
    background: var(--aura-primary-50);
    border-left-color: var(--aura-primary-500);
    font-weight: 550;
}

.dark .aura-playground-nav a.active {
    color: var(--aura-primary-500);
    background: rgba(129, 140, 248, 0.12);
}

/* Main Content */
.aura-playground-main {
    margin-left: 220px;
    padding: 96px 40px 80px;
    min-height: 100vh;
}

/* Section Card */
.aura-playground-section {
    margin-bottom: 40px;
    padding: 32px;
    background: var(--aura-surface-0);
    border: 1px solid var(--aura-border-light);
    border-radius: var(--aura-radius-xl);
    box-shadow: var(--aura-shadow-sm);
    transition: box-shadow var(--aura-duration-slow) var(--aura-ease-out);
}

.aura-playground-section:hover {
    box-shadow: var(--aura-shadow-md);
}

/* Section Title */
.aura-section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0 0 8px 0;
    padding-left: 16px;
    font-size: 20px;
    font-weight: 700;
    color: var(--aura-text-primary);
    letter-spacing: -0.02em;
    border-left: 4px solid var(--aura-primary-500);
}

/* Section Subtitle */
.aura-section-subtitle {
    margin: 24px 0 12px 0;
    padding: 0;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--aura-text-tertiary);
}

.aura-section-subtitle:first-of-type {
    margin-top: 20px;
}

.aura-section-description {
    margin: 0 0 24px 0;
    font-size: 14px;
    color: var(--aura-text-secondary);
    line-height: 1.6;
}

/* Component Row */
.aura-component-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.aura-component-row:last-child {
    margin-bottom: 0;
}

.aura-component-col {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* Responsive */
@media (max-width: 768px) {
    .aura-playground-header {
        left: 0;
    }

    .aura-playground-nav {
        display: none;
    }

    .aura-playground-main {
        margin-left: 0;
        padding: 80px 16px 60px;
    }

    .aura-playground-section {
        padding: 20px;
    }
}

/* -------------------------------------------------------
   4. BUTTONS
   ------------------------------------------------------- */
.aura-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 20px;
    font-family: inherit;
    font-size: 14px;
    font-weight: 500;
    line-height: 1;
    color: var(--aura-text-inverse);
    background: var(--aura-primary-500);
    border: 1px solid transparent;
    border-radius: var(--aura-radius-md);
    cursor: pointer;
    user-select: none;
    white-space: nowrap;
    text-decoration: none;
    transition: all var(--aura-duration-normal) var(--aura-ease-out);
    position: relative;
    overflow: hidden;
}

.aura-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0) 100%);
    pointer-events: none;
    border-radius: inherit;
}

.aura-btn:hover {
    transform: translateY(-1px) scale(1.02);
    box-shadow: var(--aura-shadow-lg), 0 0 0 1px rgba(99, 102, 241, 0.1);
}

.aura-btn:active {
    transform: translateY(0) scale(0.98);
    box-shadow: var(--aura-shadow-xs);
}

.aura-btn:focus-visible {
    outline: none;
    box-shadow: var(--aura-glow-primary);
}

.aura-btn:disabled,
.aura-btn[disabled] {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
}

/* Icon inside button */
.aura-btn svg,
.aura-btn .aura-btn-icon {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

/* --- Button Variants --- */

/* Primary (default) */
.aura-btn-primary {
    background: var(--aura-primary-500);
    color: var(--aura-text-inverse);
}

.aura-btn-primary:hover {
    background: var(--aura-primary-600);
}

/* Secondary */
.aura-btn-secondary {
    background: var(--aura-surface-100);
    color: var(--aura-text-primary);
    border-color: var(--aura-border-default);
}

.aura-btn-secondary::before {
    display: none;
}

.aura-btn-secondary:hover {
    background: var(--aura-surface-200);
    border-color: var(--aura-border-strong);
    box-shadow: var(--aura-shadow-md);
}

.aura-btn-secondary:focus-visible {
    box-shadow: 0 0 0 3px rgba(100, 116, 139, 0.2);
}

/* Success */
.aura-btn-success {
    background: var(--aura-success-500);
}

.aura-btn-success:hover {
    background: var(--aura-success-600);
    box-shadow: var(--aura-shadow-lg), 0 0 0 1px rgba(16, 185, 129, 0.1);
}

.aura-btn-success:focus-visible {
    box-shadow: var(--aura-glow-success);
}

/* Warning */
.aura-btn-warning {
    background: var(--aura-warning-500);
    color: var(--aura-surface-900);
}

.aura-btn-warning:hover {
    background: var(--aura-warning-600);
    box-shadow: var(--aura-shadow-lg), 0 0 0 1px rgba(245, 158, 11, 0.1);
}

.aura-btn-warning:focus-visible {
    box-shadow: var(--aura-glow-warning);
}

/* Danger */
.aura-btn-danger {
    background: var(--aura-danger-500);
}

.aura-btn-danger:hover {
    background: var(--aura-danger-600);
    box-shadow: var(--aura-shadow-lg), 0 0 0 1px rgba(239, 68, 68, 0.1);
}

.aura-btn-danger:focus-visible {
    box-shadow: var(--aura-glow-danger);
}

/* Ghost */
.aura-btn-ghost {
    background: transparent;
    color: var(--aura-text-secondary);
    border-color: transparent;
}

.aura-btn-ghost::before {
    display: none;
}

.aura-btn-ghost:hover {
    background: var(--aura-surface-100);
    color: var(--aura-text-primary);
    box-shadow: none;
    transform: translateY(-1px);
}

.aura-btn-ghost:focus-visible {
    box-shadow: 0 0 0 3px rgba(100, 116, 139, 0.15);
}

/* Link */
.aura-btn-link {
    background: transparent;
    color: var(--aura-text-link);
    border-color: transparent;
    padding-left: 4px;
    padding-right: 4px;
    text-decoration: underline;
    text-underline-offset: 3px;
}

.aura-btn-link::before {
    display: none;
}

.aura-btn-link:hover {
    color: var(--aura-primary-700);
    box-shadow: none;
    transform: none;
}

.dark .aura-btn-link:hover {
    color: var(--aura-primary-300);
}

/* --- Button Modifiers --- */

/* Outline */
.aura-btn-outline {
    background: transparent;
    border-width: 1.5px;
}

.aura-btn-outline::before {
    display: none;
}

.aura-btn-outline.aura-btn-primary {
    color: var(--aura-primary-500);
    border-color: var(--aura-primary-300);
}
.aura-btn-outline.aura-btn-primary:hover {
    background: var(--aura-primary-50);
    border-color: var(--aura-primary-500);
}
.dark .aura-btn-outline.aura-btn-primary:hover {
    background: rgba(129, 140, 248, 0.1);
}

.aura-btn-outline.aura-btn-success {
    color: var(--aura-success-500);
    border-color: var(--aura-success-300);
}
.aura-btn-outline.aura-btn-success:hover {
    background: var(--aura-success-50);
    border-color: var(--aura-success-500);
}
.dark .aura-btn-outline.aura-btn-success:hover {
    background: rgba(52, 211, 153, 0.1);
}

.aura-btn-outline.aura-btn-warning {
    color: var(--aura-warning-600);
    border-color: var(--aura-warning-300);
}
.aura-btn-outline.aura-btn-warning:hover {
    background: var(--aura-warning-50);
    border-color: var(--aura-warning-500);
}

.aura-btn-outline.aura-btn-danger {
    color: var(--aura-danger-500);
    border-color: var(--aura-danger-300);
}
.aura-btn-outline.aura-btn-danger:hover {
    background: var(--aura-danger-50);
    border-color: var(--aura-danger-500);
}
.dark .aura-btn-outline.aura-btn-danger:hover {
    background: rgba(248, 113, 113, 0.1);
}

.aura-btn-outline.aura-btn-secondary {
    color: var(--aura-text-secondary);
    border-color: var(--aura-border-default);
}
.aura-btn-outline.aura-btn-secondary:hover {
    background: var(--aura-surface-100);
    border-color: var(--aura-border-strong);
}

/* Gradient */
.aura-btn-gradient {
    border: none;
    color: var(--aura-text-inverse);
}

.aura-btn-gradient.aura-btn-primary {
    background: var(--aura-gradient-primary);
}
.aura-btn-gradient.aura-btn-success {
    background: var(--aura-gradient-success);
}
.aura-btn-gradient.aura-btn-warning {
    background: var(--aura-gradient-warning);
    color: var(--aura-surface-900);
}
.aura-btn-gradient.aura-btn-danger {
    background: var(--aura-gradient-danger);
}
.aura-btn-gradient.aura-btn-secondary {
    background: var(--aura-gradient-secondary);
}

.aura-btn-gradient:hover {
    filter: brightness(1.1);
    box-shadow: var(--aura-shadow-xl);
}

/* Loading */
.aura-btn-loading {
    pointer-events: none;
    position: relative;
    color: transparent !important;
}

.aura-btn-loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: aura-spin 0.6s linear infinite;
}

.aura-btn-loading.aura-btn-secondary::after,
.aura-btn-loading.aura-btn-ghost::after,
.aura-btn-loading.aura-btn-outline::after {
    border-color: rgba(100, 116, 139, 0.2);
    border-top-color: var(--aura-text-secondary);
}

/* --- Button Sizes --- */
.aura-btn-xs {
    padding: 4px 10px;
    font-size: 12px;
    gap: 4px;
    border-radius: var(--aura-radius-sm);
}
.aura-btn-xs svg, .aura-btn-xs .aura-btn-icon {
    width: 12px;
    height: 12px;
}

.aura-btn-sm {
    padding: 6px 14px;
    font-size: 13px;
    gap: 6px;
}
.aura-btn-sm svg, .aura-btn-sm .aura-btn-icon {
    width: 14px;
    height: 14px;
}

/* md is default — no override needed */

.aura-btn-lg {
    padding: 12px 24px;
    font-size: 15px;
    gap: 10px;
    border-radius: var(--aura-radius-lg);
}
.aura-btn-lg svg, .aura-btn-lg .aura-btn-icon {
    width: 18px;
    height: 18px;
}

.aura-btn-xl {
    padding: 16px 32px;
    font-size: 16px;
    gap: 10px;
    border-radius: var(--aura-radius-lg);
}
.aura-btn-xl svg, .aura-btn-xl .aura-btn-icon {
    width: 20px;
    height: 20px;
}

/* -------------------------------------------------------
   5. INPUT
   ------------------------------------------------------- */
.aura-input-wrapper {
    display: flex;
    flex-direction: column;
    gap: 6px;
    width: 100%;
    max-width: 340px;
}

.aura-input-label {
    font-size: 13px;
    font-weight: 550;
    color: var(--aura-text-primary);
    letter-spacing: -0.01em;
}

.aura-input-label .aura-required {
    color: var(--aura-danger-500);
    margin-left: 2px;
}

.aura-input {
    width: 100%;
    padding: 10px 14px;
    font-family: inherit;
    font-size: 14px;
    line-height: 1.5;
    color: var(--aura-text-primary);
    background: var(--aura-surface-100);
    border: 1px solid var(--aura-border-light);
    border-radius: var(--aura-radius-md);
    outline: none;
    transition: all var(--aura-duration-normal) var(--aura-ease-out);
    box-sizing: border-box;
}

.aura-input::placeholder {
    color: var(--aura-text-tertiary);
}

.aura-input:hover {
    border-color: var(--aura-border-default);
    background: var(--aura-surface-50);
}

.aura-input:focus {
    border-color: var(--aura-primary-500);
    background: var(--aura-surface-0);
    box-shadow: var(--aura-glow-primary);
}

.aura-input-hint {
    font-size: 12px;
    color: var(--aura-text-tertiary);
    line-height: 1.4;
}

/* Error State */
.aura-input-wrapper.aura-has-error .aura-input {
    border-color: var(--aura-danger-500);
    background: var(--aura-danger-50);
}

.aura-input-wrapper.aura-has-error .aura-input:focus {
    box-shadow: var(--aura-glow-danger);
    background: var(--aura-surface-0);
}

.dark .aura-input-wrapper.aura-has-error .aura-input {
    background: rgba(248, 113, 113, 0.06);
}

.aura-input-error {
    font-size: 12px;
    color: var(--aura-danger-500);
    font-weight: 450;
    display: flex;
    align-items: center;
    gap: 4px;
    animation: aura-shake 0.4s var(--aura-ease-out);
}

/* Prefix / Suffix */
.aura-input-group {
    display: flex;
    align-items: stretch;
    border-radius: var(--aura-radius-md);
    overflow: hidden;
}

.aura-input-group .aura-input {
    border-radius: 0;
    flex: 1;
}

.aura-input-prefix,
.aura-input-suffix {
    display: flex;
    align-items: center;
    padding: 0 12px;
    font-size: 13px;
    color: var(--aura-text-tertiary);
    background: var(--aura-surface-200);
    border: 1px solid var(--aura-border-light);
    white-space: nowrap;
}

.aura-input-prefix {
    border-right: none;
    border-radius: var(--aura-radius-md) 0 0 var(--aura-radius-md);
}

.aura-input-suffix {
    border-left: none;
    border-radius: 0 var(--aura-radius-md) var(--aura-radius-md) 0;
}

/* Input Sizes */
.aura-input-sm .aura-input,
.aura-input-sm.aura-input {
    padding: 6px 10px;
    font-size: 13px;
}

.aura-input-lg .aura-input,
.aura-input-lg.aura-input {
    padding: 14px 18px;
    font-size: 15px;
}

/* -------------------------------------------------------
   6. TEXTAREA
   ------------------------------------------------------- */
.aura-textarea {
    width: 100%;
    min-height: 100px;
    padding: 10px 14px;
    font-family: inherit;
    font-size: 14px;
    line-height: 1.6;
    color: var(--aura-text-primary);
    background: var(--aura-surface-100);
    border: 1px solid var(--aura-border-light);
    border-radius: var(--aura-radius-md);
    outline: none;
    resize: vertical;
    transition: all var(--aura-duration-normal) var(--aura-ease-out);
    box-sizing: border-box;
}

.aura-textarea::placeholder {
    color: var(--aura-text-tertiary);
}

.aura-textarea:hover {
    border-color: var(--aura-border-default);
    background: var(--aura-surface-50);
}

.aura-textarea:focus {
    border-color: var(--aura-primary-500);
    background: var(--aura-surface-0);
    box-shadow: var(--aura-glow-primary);
}

.aura-input-wrapper.aura-has-error .aura-textarea {
    border-color: var(--aura-danger-500);
    background: var(--aura-danger-50);
}

.aura-input-wrapper.aura-has-error .aura-textarea:focus {
    box-shadow: var(--aura-glow-danger);
    background: var(--aura-surface-0);
}

/* -------------------------------------------------------
   7. SELECT
   ------------------------------------------------------- */
.aura-select {
    width: 100%;
    padding: 10px 38px 10px 14px;
    font-family: inherit;
    font-size: 14px;
    line-height: 1.5;
    color: var(--aura-text-primary);
    background: var(--aura-surface-100);
    border: 1px solid var(--aura-border-light);
    border-radius: var(--aura-radius-md);
    outline: none;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px;
    transition: all var(--aura-duration-normal) var(--aura-ease-out);
    box-sizing: border-box;
}

.aura-select:hover {
    border-color: var(--aura-border-default);
    background-color: var(--aura-surface-50);
}

.aura-select:focus {
    border-color: var(--aura-primary-500);
    background-color: var(--aura-surface-0);
    box-shadow: var(--aura-glow-primary);
}

.aura-input-wrapper.aura-has-error .aura-select {
    border-color: var(--aura-danger-500);
}

/* -------------------------------------------------------
   8. CHECKBOX
   ------------------------------------------------------- */
.aura-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    cursor: pointer;
    position: relative;
    user-select: none;
}

.aura-checkbox input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.aura-checkbox-box {
    flex-shrink: 0;
    width: 18px;
    height: 18px;
    margin-top: 1px;
    border: 2px solid var(--aura-border-default);
    border-radius: 5px;
    background: var(--aura-surface-0);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--aura-duration-normal) var(--aura-ease-spring);
}

.aura-checkbox-box svg {
    width: 12px;
    height: 12px;
    stroke: white;
    stroke-width: 3;
    fill: none;
    opacity: 0;
    transform: scale(0);
    transition: all var(--aura-duration-normal) var(--aura-ease-spring);
}

.aura-checkbox:hover .aura-checkbox-box {
    border-color: var(--aura-primary-400);
}

.aura-checkbox input:checked + .aura-checkbox-box {
    background: var(--aura-primary-500);
    border-color: var(--aura-primary-500);
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15);
}

.aura-checkbox input:checked + .aura-checkbox-box svg {
    opacity: 1;
    transform: scale(1);
}

.aura-checkbox input:focus-visible + .aura-checkbox-box {
    box-shadow: var(--aura-glow-primary);
}

.aura-checkbox-content {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.aura-checkbox-label {
    font-size: 14px;
    font-weight: 450;
    color: var(--aura-text-primary);
    line-height: 1.4;
}

.aura-checkbox-description {
    font-size: 12px;
    color: var(--aura-text-tertiary);
    line-height: 1.4;
}

/* -------------------------------------------------------
   9. RADIO
   ------------------------------------------------------- */
.aura-radio {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    cursor: pointer;
    position: relative;
    user-select: none;
}

.aura-radio input[type="radio"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.aura-radio-circle {
    flex-shrink: 0;
    width: 18px;
    height: 18px;
    margin-top: 1px;
    border: 2px solid var(--aura-border-default);
    border-radius: 50%;
    background: var(--aura-surface-0);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--aura-duration-normal) var(--aura-ease-spring);
}

.aura-radio-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
    opacity: 0;
    transform: scale(0);
    transition: all var(--aura-duration-normal) var(--aura-ease-spring);
}

.aura-radio:hover .aura-radio-circle {
    border-color: var(--aura-primary-400);
}

.aura-radio input:checked + .aura-radio-circle {
    background: var(--aura-primary-500);
    border-color: var(--aura-primary-500);
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15);
}

.aura-radio input:checked + .aura-radio-circle .aura-radio-dot {
    opacity: 1;
    transform: scale(1);
}

.aura-radio input:focus-visible + .aura-radio-circle {
    box-shadow: var(--aura-glow-primary);
}

.aura-radio-label {
    font-size: 14px;
    font-weight: 450;
    color: var(--aura-text-primary);
    line-height: 1.4;
}

.aura-radio-group {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* -------------------------------------------------------
   10. TOGGLE / SWITCH
   ------------------------------------------------------- */
.aura-toggle {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    user-select: none;
    position: relative;
}

.aura-toggle input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.aura-toggle-track {
    position: relative;
    width: 44px;
    height: 24px;
    background: var(--aura-surface-300);
    border-radius: var(--aura-radius-full);
    transition: all var(--aura-duration-slow) var(--aura-ease-out);
    flex-shrink: 0;
}

.aura-toggle-knob {
    position: absolute;
    top: 2px;
    left: 2px;
    width: 20px;
    height: 20px;
    background: white;
    border-radius: 50%;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.1);
    transition: all var(--aura-duration-slow) var(--aura-ease-spring);
}

.aura-toggle input:checked + .aura-toggle-track {
    background: var(--aura-primary-500);
}

.aura-toggle input:checked + .aura-toggle-track .aura-toggle-knob {
    transform: translateX(20px);
}

.aura-toggle:hover .aura-toggle-track {
    box-shadow: 0 0 0 2px rgba(100, 116, 139, 0.1);
}

.aura-toggle input:checked:hover + .aura-toggle-track {
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15);
}

.aura-toggle input:focus-visible + .aura-toggle-track {
    box-shadow: var(--aura-glow-primary);
}

.aura-toggle-label {
    font-size: 14px;
    font-weight: 450;
    color: var(--aura-text-primary);
}

/* Toggle Sizes */
.aura-toggle-sm .aura-toggle-track {
    width: 36px;
    height: 20px;
}
.aura-toggle-sm .aura-toggle-knob {
    width: 16px;
    height: 16px;
}
.aura-toggle-sm input:checked + .aura-toggle-track .aura-toggle-knob {
    transform: translateX(16px);
}

.aura-toggle-lg .aura-toggle-track {
    width: 52px;
    height: 28px;
}
.aura-toggle-lg .aura-toggle-knob {
    width: 24px;
    height: 24px;
}
.aura-toggle-lg input:checked + .aura-toggle-track .aura-toggle-knob {
    transform: translateX(24px);
}

/* -------------------------------------------------------
   11. BADGE
   ------------------------------------------------------- */
.aura-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 10px;
    font-size: 12px;
    font-weight: 550;
    line-height: 1.4;
    border-radius: var(--aura-radius-sm);
    white-space: nowrap;
    transition: all var(--aura-duration-normal) var(--aura-ease-out);
}

/* Badge Variants */
.aura-badge-primary {
    background: var(--aura-primary-100);
    color: var(--aura-primary-700);
}
.dark .aura-badge-primary {
    background: rgba(129, 140, 248, 0.15);
    color: var(--aura-primary-300);
}

.aura-badge-secondary {
    background: var(--aura-surface-200);
    color: var(--aura-text-secondary);
}
.dark .aura-badge-secondary {
    background: var(--aura-surface-200);
    color: var(--aura-surface-600);
}

.aura-badge-success {
    background: var(--aura-success-100);
    color: var(--aura-success-700);
}
.dark .aura-badge-success {
    background: rgba(52, 211, 153, 0.15);
    color: var(--aura-success-300);
}

.aura-badge-warning {
    background: var(--aura-warning-100);
    color: var(--aura-warning-700);
}
.dark .aura-badge-warning {
    background: rgba(251, 191, 36, 0.15);
    color: var(--aura-warning-300);
}

.aura-badge-danger {
    background: var(--aura-danger-100);
    color: var(--aura-danger-700);
}
.dark .aura-badge-danger {
    background: rgba(248, 113, 113, 0.15);
    color: var(--aura-danger-300);
}

.aura-badge-info {
    background: var(--aura-info-100);
    color: var(--aura-info-700);
}
.dark .aura-badge-info {
    background: rgba(56, 189, 248, 0.15);
    color: var(--aura-info-300);
}

/* Badge Outline */
.aura-badge-outline {
    background: transparent;
    border: 1.5px solid currentColor;
}

/* Badge Dot */
.aura-badge-dot::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
    flex-shrink: 0;
}

/* Badge Sizes */
.aura-badge-sm {
    padding: 1px 6px;
    font-size: 11px;
    gap: 4px;
}
.aura-badge-sm.aura-badge-dot::before {
    width: 5px;
    height: 5px;
}

.aura-badge-lg {
    padding: 5px 14px;
    font-size: 13px;
}

/* Badge Pill */
.aura-badge-pill {
    border-radius: var(--aura-radius-full);
}

/* -------------------------------------------------------
   12. ALERT
   ------------------------------------------------------- */
.aura-alert {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 16px;
    border-radius: var(--aura-radius-lg);
    border-left: 4px solid;
    position: relative;
    transition: all var(--aura-duration-normal) var(--aura-ease-out);
}

.aura-alert-icon {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    margin-top: 1px;
}

.aura-alert-content {
    flex: 1;
    min-width: 0;
}

.aura-alert-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
    line-height: 1.4;
}

.aura-alert-message {
    font-size: 13px;
    line-height: 1.5;
    opacity: 0.85;
}

.aura-alert-dismiss {
    flex-shrink: 0;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: transparent;
    cursor: pointer;
    border-radius: var(--aura-radius-sm);
    color: inherit;
    opacity: 0.5;
    transition: all var(--aura-duration-fast) var(--aura-ease-out);
}

.aura-alert-dismiss:hover {
    opacity: 1;
    background: rgba(0, 0, 0, 0.05);
}
.dark .aura-alert-dismiss:hover {
    background: rgba(255, 255, 255, 0.08);
}

/* Alert Variants */
.aura-alert-info {
    background: var(--aura-info-50);
    border-color: var(--aura-info-500);
    color: var(--aura-info-800);
}
.dark .aura-alert-info {
    background: rgba(14, 165, 233, 0.08);
    color: var(--aura-info-200);
}

.aura-alert-success {
    background: var(--aura-success-50);
    border-color: var(--aura-success-500);
    color: var(--aura-success-800);
}
.dark .aura-alert-success {
    background: rgba(16, 185, 129, 0.08);
    color: var(--aura-success-200);
}

.aura-alert-warning {
    background: var(--aura-warning-50);
    border-color: var(--aura-warning-500);
    color: var(--aura-warning-800);
}
.dark .aura-alert-warning {
    background: rgba(245, 158, 11, 0.08);
    color: var(--aura-warning-200);
}

.aura-alert-danger {
    background: var(--aura-danger-50);
    border-color: var(--aura-danger-500);
    color: var(--aura-danger-800);
}
.dark .aura-alert-danger {
    background: rgba(239, 68, 68, 0.08);
    color: var(--aura-danger-200);
}

/* -------------------------------------------------------
   13. CARD
   ------------------------------------------------------- */
.aura-card {
    background: var(--aura-surface-0);
    border: 1px solid var(--aura-border-light);
    border-radius: var(--aura-radius-lg);
    box-shadow: var(--aura-shadow-md);
    overflow: hidden;
    transition: all var(--aura-duration-slow) var(--aura-ease-out);
}

.aura-card-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid var(--aura-border-light);
}

.aura-card-header-title {
    font-size: 16px;
    font-weight: 650;
    color: var(--aura-text-primary);
    margin: 0;
    letter-spacing: -0.01em;
}

.aura-card-header-subtitle {
    font-size: 13px;
    color: var(--aura-text-tertiary);
    margin-top: 4px;
}

.aura-card-body {
    padding: 20px 24px;
}

.aura-card-footer {
    padding: 16px 24px;
    border-top: 1px solid var(--aura-border-light);
    background: var(--aura-surface-50);
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
}

/* Card Hover */
.aura-card-hover:hover {
    box-shadow: var(--aura-shadow-xl);
    transform: translateY(-2px);
    border-color: var(--aura-border-default);
}

/* Card Glass */
.aura-card-glass {
    background: var(--aura-gradient-glass);
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.2);
}
.dark .aura-card-glass {
    border-color: rgba(255, 255, 255, 0.08);
}

/* -------------------------------------------------------
   14. MODAL
   ------------------------------------------------------- */
.aura-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: var(--aura-z-modal);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: rgba(15, 23, 42, 0.5);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    animation: aura-fade-in var(--aura-duration-slow) var(--aura-ease-out);
}

.dark .aura-modal-overlay {
    background: rgba(0, 0, 0, 0.65);
}

.aura-modal {
    position: relative;
    width: 100%;
    max-width: 480px;
    max-height: calc(100vh - 48px);
    background: var(--aura-surface-0);
    border: 1px solid var(--aura-border-light);
    border-radius: var(--aura-radius-xl);
    box-shadow: var(--aura-shadow-2xl);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    animation: aura-scale-in var(--aura-duration-slower) var(--aura-ease-spring);
}

.aura-modal-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid var(--aura-border-light);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.aura-modal-title {
    font-size: 17px;
    font-weight: 650;
    color: var(--aura-text-primary);
    margin: 0;
    letter-spacing: -0.02em;
}

.aura-modal-close {
    flex-shrink: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: transparent;
    color: var(--aura-text-tertiary);
    border-radius: var(--aura-radius-sm);
    cursor: pointer;
    transition: all var(--aura-duration-fast) var(--aura-ease-out);
}

.aura-modal-close:hover {
    background: var(--aura-surface-100);
    color: var(--aura-text-primary);
}

.aura-modal-body {
    padding: 20px 24px;
    overflow-y: auto;
    font-size: 14px;
    color: var(--aura-text-secondary);
    line-height: 1.6;
}

.aura-modal-footer {
    padding: 16px 24px;
    border-top: 1px solid var(--aura-border-light);
    background: var(--aura-surface-50);
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
}

/* -------------------------------------------------------
   15. DROPDOWN
   ------------------------------------------------------- */
.aura-dropdown {
    position: relative;
    display: inline-block;
}

.aura-dropdown-menu {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    z-index: var(--aura-z-dropdown);
    min-width: 200px;
    padding: 6px;
    background: var(--aura-surface-0);
    border: 1px solid var(--aura-border-light);
    border-radius: var(--aura-radius-lg);
    box-shadow: var(--aura-shadow-xl);
    animation: aura-slide-down var(--aura-duration-slow) var(--aura-ease-out);
    transform-origin: top left;
}

.aura-dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 8px 12px;
    font-family: inherit;
    font-size: 13px;
    font-weight: 450;
    color: var(--aura-text-primary);
    background: transparent;
    border: none;
    border-radius: var(--aura-radius-sm);
    cursor: pointer;
    text-align: left;
    transition: all var(--aura-duration-fast) var(--aura-ease-out);
    text-decoration: none;
    line-height: 1.4;
}

.aura-dropdown-item:hover {
    background: var(--aura-surface-100);
    color: var(--aura-text-primary);
}

.aura-dropdown-item svg,
.aura-dropdown-item .aura-dropdown-icon {
    width: 16px;
    height: 16px;
    color: var(--aura-text-tertiary);
    flex-shrink: 0;
}

.aura-dropdown-item:hover svg,
.aura-dropdown-item:hover .aura-dropdown-icon {
    color: var(--aura-text-secondary);
}

/* Danger Item */
.aura-dropdown-item-danger {
    color: var(--aura-danger-600);
}
.aura-dropdown-item-danger:hover {
    background: var(--aura-danger-50);
    color: var(--aura-danger-700);
}
.dark .aura-dropdown-item-danger {
    color: var(--aura-danger-400);
}
.dark .aura-dropdown-item-danger:hover {
    background: rgba(248, 113, 113, 0.1);
    color: var(--aura-danger-300);
}

.aura-dropdown-item-danger svg,
.aura-dropdown-item-danger .aura-dropdown-icon {
    color: var(--aura-danger-400);
}

/* Separator */
.aura-dropdown-separator {
    height: 1px;
    margin: 6px 0;
    background: var(--aura-border-light);
}

/* -------------------------------------------------------
   16. TOOLTIP
   ------------------------------------------------------- */
.aura-tooltip-wrapper {
    position: relative;
    display: inline-flex;
}

.aura-tooltip {
    position: absolute;
    bottom: calc(100% + 8px);
    left: 50%;
    transform: translateX(-50%);
    z-index: var(--aura-z-tooltip);
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 500;
    color: #fff;
    background: var(--aura-surface-900);
    border-radius: var(--aura-radius-sm);
    white-space: nowrap;
    pointer-events: none;
    opacity: 0;
    animation: aura-tooltip-in var(--aura-duration-slow) var(--aura-ease-out) forwards;
    box-shadow: var(--aura-shadow-lg);
}

.dark .aura-tooltip {
    background: var(--aura-surface-700);
    color: var(--aura-surface-900);
}

/* Tooltip Arrow */
.aura-tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 5px solid transparent;
    border-top-color: var(--aura-surface-900);
}

.dark .aura-tooltip::after {
    border-top-color: var(--aura-surface-700);
}

/* Tooltip visible state (for demo) */
.aura-tooltip-visible .aura-tooltip {
    opacity: 1;
}

/* -------------------------------------------------------
   17. AVATAR
   ------------------------------------------------------- */
.aura-avatar {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    overflow: hidden;
    background: var(--aura-gradient-primary);
    color: white;
    font-weight: 600;
    flex-shrink: 0;
    transition: all var(--aura-duration-normal) var(--aura-ease-out);
}

.aura-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

/* Avatar Sizes */
.aura-avatar-xs {
    width: 24px;
    height: 24px;
    font-size: 10px;
}

.aura-avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 12px;
}

.aura-avatar-md {
    width: 40px;
    height: 40px;
    font-size: 14px;
}

.aura-avatar-lg {
    width: 48px;
    height: 48px;
    font-size: 18px;
}

.aura-avatar-xl {
    width: 64px;
    height: 64px;
    font-size: 24px;
}

/* Avatar Status Indicator */
.aura-avatar-status {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 25%;
    height: 25%;
    min-width: 8px;
    min-height: 8px;
    border-radius: 50%;
    border: 2px solid var(--aura-surface-0);
    box-sizing: content-box;
}

.aura-avatar-status-online {
    background: var(--aura-success-500);
}

.aura-avatar-status-offline {
    background: var(--aura-surface-400);
}

.aura-avatar-status-busy {
    background: var(--aura-danger-500);
}

/* Avatar Group (overlap) */
.aura-avatar-group {
    display: flex;
    flex-direction: row-reverse;
}

.aura-avatar-group .aura-avatar {
    margin-left: -8px;
    border: 2px solid var(--aura-surface-0);
    box-sizing: content-box;
}

.aura-avatar-group .aura-avatar:last-child {
    margin-left: 0;
}

.aura-avatar-group .aura-avatar:hover {
    z-index: 1;
    transform: translateY(-2px);
}

/* -------------------------------------------------------
   18. SPINNER
   ------------------------------------------------------- */
.aura-spinner {
    display: inline-block;
    border-radius: 50%;
    border: 3px solid var(--aura-surface-200);
    border-top-color: var(--aura-primary-500);
    animation: aura-spin 0.7s linear infinite;
}

/* Spinner with gradient stroke effect */
.aura-spinner-gradient {
    border-color: transparent;
    background:
        linear-gradient(var(--aura-surface-0), var(--aura-surface-0)) padding-box,
        conic-gradient(
            from 0deg,
            transparent 0%,
            var(--aura-primary-500) 75%,
            transparent 100%
        ) border-box;
    border: 3px solid transparent;
    border-radius: 50%;
    animation: aura-spin 0.8s linear infinite;
}

.dark .aura-spinner-gradient {
    background:
        linear-gradient(var(--aura-surface-0), var(--aura-surface-0)) padding-box,
        conic-gradient(
            from 0deg,
            transparent 0%,
            var(--aura-primary-500) 75%,
            transparent 100%
        ) border-box;
}

/* Spinner Sizes */
.aura-spinner-sm {
    width: 16px;
    height: 16px;
    border-width: 2px;
}

.aura-spinner-md {
    width: 24px;
    height: 24px;
    border-width: 3px;
}

.aura-spinner-lg {
    width: 36px;
    height: 36px;
    border-width: 3px;
}

/* -------------------------------------------------------
   19. SKELETON
   ------------------------------------------------------- */
.aura-skeleton {
    position: relative;
    overflow: hidden;
    background: var(--aura-surface-200);
    border-radius: var(--aura-radius-md);
}

.aura-skeleton::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        90deg,
        transparent 0%,
        rgba(255, 255, 255, 0.4) 50%,
        transparent 100%
    );
    animation: aura-shimmer 1.8s ease-in-out infinite;
}

.dark .aura-skeleton {
    background: var(--aura-surface-200);
}

.dark .aura-skeleton::after {
    background: linear-gradient(
        90deg,
        transparent 0%,
        rgba(255, 255, 255, 0.06) 50%,
        transparent 100%
    );
}

/* Skeleton shapes */
.aura-skeleton-text {
    height: 14px;
    margin-bottom: 8px;
}

.aura-skeleton-text:last-child {
    width: 75%;
}

.aura-skeleton-title {
    height: 20px;
    width: 60%;
    margin-bottom: 16px;
}

.aura-skeleton-circle {
    border-radius: 50%;
}

.aura-skeleton-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    flex-shrink: 0;
}

.aura-skeleton-button {
    height: 38px;
    width: 100px;
    border-radius: var(--aura-radius-md);
}

.aura-skeleton-image {
    height: 200px;
    border-radius: var(--aura-radius-lg);
}

/* -------------------------------------------------------
   KEYFRAME ANIMATIONS
   ------------------------------------------------------- */
@keyframes aura-spin {
    to { transform: rotate(360deg); }
}

@keyframes aura-fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes aura-scale-in {
    from {
        opacity: 0;
        transform: scale(0.92);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes aura-slide-down {
    from {
        opacity: 0;
        transform: translateY(-8px) scale(0.96);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes aura-shake {
    0%, 100% { transform: translateX(0); }
    20% { transform: translateX(-4px); }
    40% { transform: translateX(4px); }
    60% { transform: translateX(-3px); }
    80% { transform: translateX(2px); }
}

@keyframes aura-shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

@keyframes aura-tooltip-in {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(4px);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}

@keyframes aura-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* -------------------------------------------------------
   UTILITY HELPERS
   ------------------------------------------------------- */
.aura-sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

.aura-flex {
    display: flex;
}

.aura-flex-col {
    display: flex;
    flex-direction: column;
}

.aura-items-center {
    align-items: center;
}

.aura-gap-2 { gap: 8px; }
.aura-gap-3 { gap: 12px; }
.aura-gap-4 { gap: 16px; }

.aura-w-full { width: 100%; }
.aura-max-w-sm { max-width: 280px; }
.aura-max-w-md { max-width: 340px; }
.aura-max-w-lg { max-width: 480px; }

/* Color preview blocks (for playground) */
.aura-color-swatch {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    border-radius: var(--aura-radius-md);
    background: var(--aura-surface-0);
    border: 1px solid var(--aura-border-light);
}

.aura-color-swatch-dot {
    width: 28px;
    height: 28px;
    border-radius: var(--aura-radius-sm);
    flex-shrink: 0;
    box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.08);
}

.aura-color-swatch-label {
    font-size: 13px;
    font-weight: 500;
    color: var(--aura-text-primary);
}

.aura-color-swatch-value {
    font-size: 12px;
    color: var(--aura-text-tertiary);
    font-family: 'JetBrains Mono', 'Fira Code', monospace;
}

/* Code preview */
.aura-code-preview {
    padding: 16px 20px;
    background: var(--aura-surface-900);
    color: #e2e8f0;
    font-family: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', monospace;
    font-size: 13px;
    line-height: 1.6;
    border-radius: var(--aura-radius-lg);
    overflow-x: auto;
    margin-top: 12px;
}

.dark .aura-code-preview {
    background: #020617;
    border: 1px solid var(--aura-border-default);
}

/* Dark mode preview container */
.aura-dark-preview {
    padding: 24px;
    border-radius: var(--aura-radius-lg);
    background: #0f172a;
    border: 1px solid #293548;
}

/* Inline example containers */
.aura-example-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 16px;
}

/* -------------------------------------------------------
   20. EMPTY STATE
   ------------------------------------------------------- */
.aura-empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 48px 24px;
    text-align: center;
}

.aura-empty-state-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 64px;
    height: 64px;
    margin-bottom: 16px;
    background: var(--aura-surface-100);
    border-radius: var(--aura-radius-full);
    color: var(--aura-text-tertiary);
}

.dark .aura-empty-state-icon {
    background: var(--aura-surface-200);
}

.aura-empty-state-title {
    margin: 0 0 8px 0;
    font-size: 16px;
    font-weight: 600;
    color: var(--aura-text-primary);
}

.aura-empty-state-description {
    margin: 0 0 20px 0;
    font-size: 14px;
    color: var(--aura-text-tertiary);
    max-width: 360px;
    line-height: 1.5;
}

.aura-empty-state-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

/* -------------------------------------------------------
   21. STATS CARD
   ------------------------------------------------------- */
.aura-stats-card {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 20px 24px;
    background: var(--aura-surface-0);
    border: 1px solid var(--aura-border-light);
    border-radius: var(--aura-radius-lg);
    box-shadow: var(--aura-shadow-sm);
    text-decoration: none;
    transition: all var(--aura-duration-slow) var(--aura-ease-out);
}

.aura-stats-card:hover {
    box-shadow: var(--aura-shadow-md);
}

a.aura-stats-card:hover {
    box-shadow: var(--aura-shadow-xl);
    transform: translateY(-2px);
    border-color: var(--aura-border-default);
}

.aura-stats-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.aura-stats-title {
    margin: 0;
    font-size: 13px;
    font-weight: 500;
    color: var(--aura-text-tertiary);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.aura-stats-value {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    color: var(--aura-text-primary);
    letter-spacing: -0.02em;
    line-height: 1.2;
}

.aura-stats-change {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-top: 4px;
    font-size: 13px;
    font-weight: 550;
}

.aura-stats-change-positive {
    color: var(--aura-success-600);
}
.dark .aura-stats-change-positive {
    color: var(--aura-success-400);
}

.aura-stats-change-negative {
    color: var(--aura-danger-600);
}
.dark .aura-stats-change-negative {
    color: var(--aura-danger-400);
}

.aura-stats-change-neutral {
    color: var(--aura-text-tertiary);
}

.aura-stats-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background: var(--aura-primary-50);
    border-radius: var(--aura-radius-lg);
    color: var(--aura-primary-500);
    flex-shrink: 0;
}

.dark .aura-stats-icon {
    background: rgba(129, 140, 248, 0.12);
}

/* -------------------------------------------------------
   22. PROGRESS BAR
   ------------------------------------------------------- */
.aura-progress {
    width: 100%;
}

.aura-progress-track {
    width: 100%;
    background: var(--aura-surface-200);
    border-radius: var(--aura-radius-full);
    overflow: hidden;
}

.aura-progress-bar {
    height: 100%;
    border-radius: var(--aura-radius-full);
    transition: width 0.6s var(--aura-ease-out);
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding-right: 8px;
    min-width: 0;
}

/* Progress Sizes */
.aura-progress-sm .aura-progress-track {
    height: 6px;
}
.aura-progress-md .aura-progress-track {
    height: 10px;
}
.aura-progress-lg .aura-progress-track {
    height: 16px;
}

/* Progress Colors */
.aura-progress-primary {
    background: var(--aura-gradient-primary);
}
.aura-progress-secondary {
    background: var(--aura-gradient-secondary);
}
.aura-progress-success {
    background: var(--aura-gradient-success);
}
.aura-progress-warning {
    background: var(--aura-gradient-warning);
}
.aura-progress-danger {
    background: var(--aura-gradient-danger);
}

/* Progress Label */
.aura-progress-label {
    font-size: 10px;
    font-weight: 600;
    color: white;
    white-space: nowrap;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.aura-progress-sm .aura-progress-label {
    display: none;
}

/* Progress Striped */
.aura-progress-striped {
    background-image: linear-gradient(
        45deg,
        rgba(255, 255, 255, 0.2) 25%,
        transparent 25%,
        transparent 50%,
        rgba(255, 255, 255, 0.2) 50%,
        rgba(255, 255, 255, 0.2) 75%,
        transparent 75%,
        transparent
    );
    background-size: 20px 20px;
}

/* Progress Animated (striped + moving) */
.aura-progress-animated {
    background-image: linear-gradient(
        45deg,
        rgba(255, 255, 255, 0.2) 25%,
        transparent 25%,
        transparent 50%,
        rgba(255, 255, 255, 0.2) 50%,
        rgba(255, 255, 255, 0.2) 75%,
        transparent 75%,
        transparent
    );
    background-size: 20px 20px;
    animation: aura-progress-stripes 1s linear infinite;
}

@keyframes aura-progress-stripes {
    from { background-position: 20px 0; }
    to { background-position: 0 0; }
}

/* -------------------------------------------------------
   23. DATATABLE
   ------------------------------------------------------- */
.aura-datatable {
    width: 100%;
}

.aura-datatable-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 16px 20px;
    border-bottom: 1px solid var(--aura-border-light);
}

.aura-datatable-toolbar {
    display: flex;
    align-items: center;
    gap: 8px;
}

.aura-datatable-bulk-bar {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 20px;
    background: var(--aura-primary-50);
    border-bottom: 1px solid var(--aura-primary-100);
    font-size: 13px;
    color: var(--aura-primary-700);
    font-weight: 500;
}

.dark .aura-datatable-bulk-bar {
    background: rgba(129, 140, 248, 0.08);
    border-color: rgba(129, 140, 248, 0.15);
    color: var(--aura-primary-300);
}

.aura-datatable table {
    width: 100%;
    border-collapse: collapse;
}

.aura-datatable thead th {
    padding: 10px 16px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--aura-text-tertiary);
    text-align: left;
    border-bottom: 1px solid var(--aura-border-light);
    background: var(--aura-surface-50);
    white-space: nowrap;
    user-select: none;
}

.aura-datatable tbody td {
    padding: 12px 16px;
    font-size: 14px;
    color: var(--aura-text-primary);
    border-bottom: 1px solid var(--aura-border-light);
    vertical-align: middle;
}

.aura-datatable tbody tr:hover {
    background: var(--aura-surface-50);
}

.dark .aura-datatable tbody tr:hover {
    background: var(--aura-surface-100);
}

.aura-datatable tbody tr.aura-row-selected {
    background: var(--aura-primary-50);
}
.dark .aura-datatable tbody tr.aura-row-selected {
    background: rgba(129, 140, 248, 0.06);
}

.aura-datatable-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 12px 20px;
    border-top: 1px solid var(--aura-border-light);
    font-size: 13px;
    color: var(--aura-text-tertiary);
}

.aura-datatable-pagination {
    display: flex;
    align-items: center;
    gap: 4px;
}

.aura-datatable-page-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    padding: 0 8px;
    font-family: inherit;
    font-size: 13px;
    font-weight: 500;
    color: var(--aura-text-secondary);
    background: transparent;
    border: 1px solid var(--aura-border-light);
    border-radius: var(--aura-radius-sm);
    cursor: pointer;
    transition: all var(--aura-duration-fast) var(--aura-ease-out);
}

.aura-datatable-page-btn:hover {
    background: var(--aura-surface-100);
    border-color: var(--aura-border-default);
}

.aura-datatable-page-btn.active {
    background: var(--aura-primary-500);
    color: white;
    border-color: var(--aura-primary-500);
}

.aura-datatable-per-page {
    display: flex;
    align-items: center;
    gap: 8px;
}

.aura-datatable-per-page select {
    padding: 4px 28px 4px 8px;
    font-family: inherit;
    font-size: 13px;
    color: var(--aura-text-primary);
    background: var(--aura-surface-0);
    border: 1px solid var(--aura-border-light);
    border-radius: var(--aura-radius-sm);
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 6px center;
    cursor: pointer;
}

/* Nav section title for grouping */
.aura-nav-title {
    padding: 8px 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--aura-text-tertiary);
    margin-top: 12px;
}

.aura-nav-title:first-child {
    margin-top: 0;
}

.aura-nav-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 450;
    color: var(--aura-text-secondary);
    text-decoration: none;
    border-left: 3px solid transparent;
    transition: all var(--aura-duration-normal) var(--aura-ease-out);
}

.aura-nav-link:hover {
    color: var(--aura-primary-500);
    background: var(--aura-primary-50);
    border-left-color: var(--aura-primary-200);
}

.dark .aura-nav-link:hover {
    background: rgba(129, 140, 248, 0.08);
}

/* -------------------------------------------------------
   PHASE 3 — FORM COMPONENTS
   ------------------------------------------------------- */

/* === DatePicker === */
.aura-datepicker-wrapper { position: relative; }
.aura-datepicker-input-wrap { position: relative; }
.aura-datepicker-input { padding-right: 60px !important; cursor: pointer; }
.aura-datepicker-icons {
    position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
    display: flex; align-items: center; gap: 4px;
}
.aura-datepicker-icon { color: var(--aura-surface-400, #94a3b8); display: flex; }
.aura-datepicker-clear {
    background: none; border: none; cursor: pointer; padding: 2px;
    color: var(--aura-surface-400, #94a3b8); display: flex; border-radius: 50%;
    transition: all 150ms;
}
.aura-datepicker-clear:hover { color: var(--aura-danger-500); background: var(--aura-danger-50); }
.aura-datepicker-dropdown {
    position: absolute; top: 100%; left: 0; z-index: 50;
    margin-top: 4px; padding: 12px;
    border-radius: var(--aura-radius-lg, 12px);
    box-shadow: var(--aura-shadow-lg); min-width: 280px;
    background: var(--aura-surface-0, #fff);
    border: 1px solid var(--aura-surface-200, #e2e8f0);
}
.dark .aura-datepicker-dropdown {
    background: var(--aura-surface-50, #1e293b);
    border-color: var(--aura-surface-200, #475569);
}
.aura-datepicker-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 8px; gap: 4px;
}
.aura-datepicker-nav {
    background: none; border: none; cursor: pointer; padding: 4px;
    border-radius: var(--aura-radius-sm, 6px); color: var(--aura-surface-700, #334155);
    display: flex; align-items: center; transition: all 150ms;
}
.aura-datepicker-nav:hover { background: var(--aura-surface-100, #f1f5f9); }
.dark .aura-datepicker-nav { color: var(--aura-surface-300, #cbd5e1); }
.dark .aura-datepicker-nav:hover { background: var(--aura-surface-100, #334155); }
.aura-datepicker-title {
    font-weight: 600; font-size: 0.875rem; flex: 1; text-align: center;
    color: var(--aura-surface-800, #1e293b);
}
.dark .aura-datepicker-title { color: var(--aura-surface-800, #e2e8f0); }
.aura-datepicker-weekdays {
    display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; margin-bottom: 4px;
}
.aura-datepicker-weekday {
    text-align: center; font-size: 0.7rem; font-weight: 600;
    color: var(--aura-surface-400, #94a3b8); padding: 4px;
    text-transform: uppercase;
}
.aura-datepicker-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
.aura-datepicker-day {
    border: none; background: none; cursor: pointer; padding: 6px 4px;
    border-radius: var(--aura-radius-sm, 6px); font-size: 0.8rem;
    color: var(--aura-surface-800, #1e293b); text-align: center;
    transition: all 150ms;
}
.dark .aura-datepicker-day { color: var(--aura-surface-800, #e2e8f0); }
.aura-datepicker-day:hover:not(:disabled) { background: var(--aura-primary-50); color: var(--aura-primary-600); }
.dark .aura-datepicker-day:hover:not(:disabled) { background: rgba(129,140,248,0.15); }
.aura-datepicker-day-other { color: var(--aura-surface-300, #cbd5e1) !important; }
.aura-datepicker-day-today {
    font-weight: 700; border: 1px solid var(--aura-primary-300);
}
.aura-datepicker-day-selected {
    background: var(--aura-primary-500) !important; color: #fff !important;
    font-weight: 600; box-shadow: 0 0 0 2px rgba(99,102,241,0.2);
}
.aura-datepicker-day-disabled { opacity: 0.3; cursor: not-allowed !important; }
.aura-datepicker-time {
    display: flex; align-items: center; gap: 6px; margin-top: 10px;
    padding-top: 10px; border-top: 1px solid var(--aura-surface-200, #e2e8f0);
}
.aura-datepicker-time-label { font-size: 0.8rem; font-weight: 500; color: var(--aura-surface-700); }
.aura-datepicker-time-input {
    width: 50px; text-align: center; font-size: 0.85rem;
    padding: 4px; border: 1px solid var(--aura-surface-200, #e2e8f0);
    border-radius: var(--aura-radius-sm, 6px); background: var(--aura-surface-0, #fff);
    color: var(--aura-surface-800); font-variant-numeric: tabular-nums;
}
.dark .aura-datepicker-time-input {
    background: var(--aura-surface-100, #334155); border-color: var(--aura-surface-200, #475569);
    color: var(--aura-surface-800, #e2e8f0);
}
.aura-datepicker-time-sep { font-weight: 700; color: var(--aura-surface-400); }

/* Transition classes */
.aura-transition-enter { transition: all 150ms ease-out; }
.aura-transition-enter-start { opacity: 0; transform: translateY(-4px) scale(0.97); }
.aura-transition-enter-end { opacity: 1; transform: translateY(0) scale(1); }
.aura-transition-leave { transition: all 100ms ease-in; }
.aura-transition-leave-start { opacity: 1; transform: scale(1); }
.aura-transition-leave-end { opacity: 0; transform: scale(0.97); }

/* === TimePicker === */
.aura-timepicker-wrapper { position: relative; }
.aura-timepicker-input-wrap { position: relative; }
.aura-timepicker-input { padding-right: 60px !important; cursor: pointer; }
.aura-timepicker-dropdown {
    position: absolute; top: 100%; left: 0; z-index: 50;
    margin-top: 4px; border-radius: var(--aura-radius-lg, 12px);
    box-shadow: var(--aura-shadow-lg); min-width: 160px;
    background: var(--aura-surface-0, #fff); border: 1px solid var(--aura-surface-200, #e2e8f0);
}
.dark .aura-timepicker-dropdown {
    background: var(--aura-surface-50, #1e293b); border-color: var(--aura-surface-200, #475569);
}
.aura-timepicker-search { padding: 8px; border-bottom: 1px solid var(--aura-surface-200, #e2e8f0); }
.aura-timepicker-list { max-height: 200px; overflow-y: auto; padding: 4px; }
.aura-timepicker-option {
    display: block; width: 100%; text-align: left; padding: 6px 12px;
    border: none; background: none; cursor: pointer; font-size: 0.85rem;
    border-radius: var(--aura-radius-sm, 6px); color: var(--aura-surface-800, #1e293b);
    transition: all 100ms; font-variant-numeric: tabular-nums;
}
.dark .aura-timepicker-option { color: var(--aura-surface-800, #e2e8f0); }
.aura-timepicker-option:hover { background: var(--aura-primary-50); color: var(--aura-primary-600); }
.dark .aura-timepicker-option:hover { background: rgba(129,140,248,0.15); }
.aura-timepicker-option-selected {
    background: var(--aura-primary-500) !important; color: #fff !important; font-weight: 600;
}

/* === File Upload === */
.aura-file-upload-wrapper {}
.aura-file-upload-input { display: none !important; }
.aura-file-upload-zone {
    border: 2px dashed var(--aura-surface-300, #cbd5e1);
    border-radius: var(--aura-radius-lg, 12px);
    padding: 32px 16px; text-align: center; cursor: pointer;
    transition: all 200ms ease; background: var(--aura-surface-50, #f8fafc);
}
.dark .aura-file-upload-zone {
    background: var(--aura-surface-50, #1e293b); border-color: var(--aura-surface-200, #475569);
}
.aura-file-upload-zone:hover {
    border-color: var(--aura-primary-400);
    background: var(--aura-primary-50);
}
.dark .aura-file-upload-zone:hover {
    background: rgba(129,140,248,0.08); border-color: var(--aura-primary-400);
}
.aura-file-upload-dragging {
    border-color: var(--aura-primary-500) !important;
    background: var(--aura-primary-50) !important;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    transform: scale(1.01);
}
.aura-file-upload-disabled { opacity: 0.5; cursor: not-allowed !important; }
.aura-file-upload-icon { color: var(--aura-surface-400); margin-bottom: 8px; }
.aura-file-upload-text { font-size: 0.875rem; color: var(--aura-surface-700); font-weight: 500; }
.aura-file-upload-hint { font-size: 0.75rem; color: var(--aura-surface-400); margin-top: 4px; }
.aura-file-upload-list { margin-top: 8px; display: flex; flex-direction: column; gap: 6px; }
.aura-file-upload-item {
    display: flex; align-items: center; gap: 10px; padding: 8px 12px;
    background: var(--aura-surface-50, #f8fafc); border-radius: var(--aura-radius-md, 8px);
    border: 1px solid var(--aura-surface-200, #e2e8f0);
}
.dark .aura-file-upload-item {
    background: var(--aura-surface-50, #1e293b); border-color: var(--aura-surface-200, #475569);
}
.aura-file-upload-preview { width: 40px; height: 40px; object-fit: cover; border-radius: var(--aura-radius-sm, 6px); }
.aura-file-upload-file-icon { color: var(--aura-surface-400); }
.aura-file-upload-info { flex: 1; min-width: 0; }
.aura-file-upload-name { font-size: 0.85rem; font-weight: 500; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.aura-file-upload-size { font-size: 0.75rem; color: var(--aura-surface-400); }
.aura-file-upload-remove {
    background: none; border: none; cursor: pointer; padding: 4px;
    color: var(--aura-surface-400); border-radius: 50%; transition: all 150ms;
}
.aura-file-upload-remove:hover { color: var(--aura-danger-500); background: var(--aura-danger-50); }

/* === Autocomplete === */
.aura-autocomplete-wrapper { position: relative; }
.aura-autocomplete-input-wrap { position: relative; }
.aura-autocomplete-dropdown {
    position: absolute; top: 100%; left: 0; right: 0; z-index: 50;
    margin-top: 4px; max-height: 240px; overflow-y: auto;
    border-radius: var(--aura-radius-lg, 12px); box-shadow: var(--aura-shadow-lg);
    background: var(--aura-surface-0, #fff); border: 1px solid var(--aura-surface-200, #e2e8f0);
    padding: 4px;
}
.dark .aura-autocomplete-dropdown {
    background: var(--aura-surface-50, #1e293b); border-color: var(--aura-surface-200, #475569);
}
.aura-autocomplete-option {
    display: block; width: 100%; text-align: left; padding: 8px 12px;
    border: none; background: none; cursor: pointer; font-size: 0.875rem;
    border-radius: var(--aura-radius-sm, 6px); color: var(--aura-surface-800, #1e293b);
    transition: all 100ms;
}
.dark .aura-autocomplete-option { color: var(--aura-surface-800, #e2e8f0); }
.aura-autocomplete-option:hover, .aura-autocomplete-option-highlighted {
    background: var(--aura-primary-50); color: var(--aura-primary-600);
}
.dark .aura-autocomplete-option:hover, .dark .aura-autocomplete-option-highlighted {
    background: rgba(129,140,248,0.15);
}
.aura-autocomplete-option-selected {
    background: var(--aura-primary-500) !important; color: #fff !important; font-weight: 600;
}
.aura-autocomplete-no-results {
    padding: 12px; text-align: center; font-size: 0.85rem;
    color: var(--aura-surface-400);
}

/* === Tags Input === */
.aura-tags-wrapper { position: relative; }
.aura-tags-container {
    display: flex; flex-wrap: wrap; gap: 6px; align-items: center;
    padding: 6px 10px; min-height: 42px;
    border: 1px solid var(--aura-surface-200, #e2e8f0);
    border-radius: var(--aura-radius-md, 8px); background: var(--aura-surface-0, #fff);
    transition: all 200ms; cursor: text;
}
.dark .aura-tags-container {
    background: var(--aura-surface-50, #1e293b); border-color: var(--aura-surface-200, #475569);
}
.aura-tags-container:focus-within {
    border-color: var(--aura-primary-500);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
}
.aura-tags-disabled { opacity: 0.5; cursor: not-allowed !important; }
.aura-tag {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 2px 8px 2px 10px; font-size: 0.8rem; font-weight: 500;
    background: var(--aura-primary-100, #e0e7ff); color: var(--aura-primary-700, #4338ca);
    border-radius: var(--aura-radius-full, 9999px); white-space: nowrap;
    animation: aura-scale-in 150ms var(--aura-ease-spring, cubic-bezier(0.34,1.56,0.64,1));
}
.dark .aura-tag { background: rgba(129,140,248,0.2); color: var(--aura-primary-300); }
.aura-tag-remove {
    background: none; border: none; cursor: pointer; padding: 1px;
    color: inherit; opacity: 0.6; border-radius: 50%; display: flex; transition: all 100ms;
}
.aura-tag-remove:hover { opacity: 1; background: rgba(0,0,0,0.1); }
.aura-tags-input-field {
    flex: 1; min-width: 80px; border: none !important; outline: none !important;
    background: transparent !important; padding: 2px 4px !important;
    font-size: 0.875rem; box-shadow: none !important;
}
.aura-tags-suggestions {
    position: absolute; top: 100%; left: 0; right: 0; z-index: 50;
    margin-top: 4px; max-height: 160px; overflow-y: auto;
    border-radius: var(--aura-radius-lg, 12px); box-shadow: var(--aura-shadow-lg);
    background: var(--aura-surface-0, #fff); border: 1px solid var(--aura-surface-200, #e2e8f0);
    padding: 4px;
}
.dark .aura-tags-suggestions {
    background: var(--aura-surface-50, #1e293b); border-color: var(--aura-surface-200, #475569);
}
.aura-tags-suggestion {
    display: block; width: 100%; text-align: left; padding: 6px 12px;
    border: none; background: none; cursor: pointer; font-size: 0.85rem;
    border-radius: var(--aura-radius-sm, 6px); color: var(--aura-surface-800); transition: all 100ms;
}
.aura-tags-suggestion:hover, .aura-tags-suggestion-highlighted {
    background: var(--aura-primary-50); color: var(--aura-primary-600);
}
.aura-tags-count {
    font-size: 0.75rem; color: var(--aura-surface-400); margin-top: 4px; text-align: right;
}

/* === Color Picker === */
.aura-color-picker-wrapper { position: relative; }
.aura-color-picker-button { display: flex !important; align-items: center !important; gap: 8px !important; cursor: pointer; }
.aura-color-swatch-preview {
    width: 24px; height: 24px; border-radius: var(--aura-radius-sm, 6px);
    border: 1px solid var(--aura-surface-200, #e2e8f0); flex-shrink: 0;
    background: repeating-conic-gradient(#ddd 0% 25%, transparent 0% 50%) 50% / 12px 12px;
}
.aura-color-swatch-sm { width: 28px; height: 28px; border-radius: var(--aura-radius-sm, 6px); flex-shrink: 0; }
.aura-color-value { font-size: 0.85rem; color: var(--aura-surface-700); font-family: var(--aura-font-mono, monospace); }
.aura-color-picker-dropdown {
    position: absolute; top: 100%; left: 0; z-index: 50;
    margin-top: 4px; padding: 12px; min-width: 220px;
    border-radius: var(--aura-radius-lg, 12px); box-shadow: var(--aura-shadow-lg);
    background: var(--aura-surface-0, #fff); border: 1px solid var(--aura-surface-200, #e2e8f0);
}
.dark .aura-color-picker-dropdown {
    background: var(--aura-surface-50, #1e293b); border-color: var(--aura-surface-200, #475569);
}
.aura-color-swatches {
    display: grid; grid-template-columns: repeat(5, 1fr); gap: 6px; margin-bottom: 10px;
}
.aura-color-swatch {
    width: 32px; height: 32px; border-radius: var(--aura-radius-sm, 6px);
    border: 2px solid transparent; cursor: pointer; transition: all 150ms;
    box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);
}
.aura-color-swatch:hover { transform: scale(1.15); box-shadow: var(--aura-shadow-md); }
.aura-color-swatch-active { border-color: var(--aura-primary-500) !important; transform: scale(1.1); }
.aura-color-hex-input { display: flex; align-items: center; gap: 8px; }
.aura-color-hex-input .aura-input { flex: 1; font-family: var(--aura-font-mono, monospace); }

/* === Slider === */
.aura-slider-wrapper {}
.aura-slider-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
.aura-slider-value {
    font-weight: 600; font-size: 0.9rem; color: var(--aura-primary-500);
    font-variant-numeric: tabular-nums;
}
.aura-slider-track-wrapper { position: relative; }
.aura-slider {
    -webkit-appearance: none; appearance: none; width: 100%; height: 6px;
    border-radius: var(--aura-radius-full, 9999px); outline: none; cursor: pointer;
    background: linear-gradient(to right, var(--aura-primary-500) var(--aura-slider-progress, 0%), var(--aura-surface-200, #e2e8f0) var(--aura-slider-progress, 0%));
    transition: background 100ms;
}
.dark .aura-slider {
    background: linear-gradient(to right, var(--aura-primary-400) var(--aura-slider-progress, 0%), var(--aura-surface-200, #475569) var(--aura-slider-progress, 0%));
}
.aura-slider::-webkit-slider-thumb {
    -webkit-appearance: none; appearance: none;
    width: 20px; height: 20px; border-radius: 50%;
    background: var(--aura-primary-500); border: 3px solid #fff;
    box-shadow: var(--aura-shadow-md); cursor: pointer; transition: all 150ms;
}
.aura-slider::-webkit-slider-thumb:hover { transform: scale(1.15); box-shadow: var(--aura-shadow-lg); }
.aura-slider::-moz-range-thumb {
    width: 20px; height: 20px; border-radius: 50%;
    background: var(--aura-primary-500); border: 3px solid #fff;
    box-shadow: var(--aura-shadow-md); cursor: pointer;
}
.aura-slider-labels {
    display: flex; justify-content: space-between; margin-top: 4px;
    font-size: 0.7rem; color: var(--aura-surface-400);
}
.aura-slider-primary::-webkit-slider-thumb { background: var(--aura-primary-500); }
.aura-slider-success::-webkit-slider-thumb { background: var(--aura-success-500); }
.aura-slider-danger::-webkit-slider-thumb { background: var(--aura-danger-500); }

/* === OTP Input === */
.aura-otp-wrapper {}
.aura-otp-inputs { display: flex; gap: 8px; align-items: center; }
.aura-otp-separator { font-size: 1.2rem; color: var(--aura-surface-400); font-weight: 300; }
.aura-otp-digit {
    width: 44px; height: 52px; text-align: center;
    font-size: 1.25rem; font-weight: 600; font-variant-numeric: tabular-nums;
    border: 1px solid var(--aura-surface-200, #e2e8f0);
    border-radius: var(--aura-radius-md, 8px); background: var(--aura-surface-0, #fff);
    color: var(--aura-surface-800); transition: all 200ms; outline: none;
}
.dark .aura-otp-digit {
    background: var(--aura-surface-50, #1e293b); border-color: var(--aura-surface-200, #475569);
    color: var(--aura-surface-800, #e2e8f0);
}
.aura-otp-digit:focus {
    border-color: var(--aura-primary-500);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
}
.aura-otp-sm .aura-otp-digit { width: 36px; height: 42px; font-size: 1rem; }
.aura-otp-lg .aura-otp-digit { width: 52px; height: 60px; font-size: 1.5rem; }

/* === Rich Text Editor === */
.aura-editor-wrapper {}
.aura-editor {
    border: 1px solid var(--aura-surface-200, #e2e8f0);
    border-radius: var(--aura-radius-lg, 12px); overflow: hidden;
    background: var(--aura-surface-0, #fff); transition: all 200ms;
}
.dark .aura-editor {
    background: var(--aura-surface-50, #1e293b); border-color: var(--aura-surface-200, #475569);
}
.aura-editor:focus-within {
    border-color: var(--aura-primary-500);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
}
.aura-editor-error { border-color: var(--aura-danger-500) !important; }
.aura-editor-disabled { opacity: 0.5; }
.aura-editor-toolbar {
    display: flex; gap: 2px; padding: 6px 8px; flex-wrap: wrap;
    border-bottom: 1px solid var(--aura-surface-200, #e2e8f0);
    background: var(--aura-surface-50, #f8fafc);
}
.dark .aura-editor-toolbar { background: var(--aura-surface-100, #334155); }
.aura-editor-btn {
    background: none; border: none; cursor: pointer; padding: 6px;
    border-radius: var(--aura-radius-sm, 6px); color: var(--aura-surface-600, #475569);
    display: flex; align-items: center; transition: all 100ms;
}
.aura-editor-btn:hover { background: var(--aura-surface-200, #e2e8f0); color: var(--aura-primary-600); }
.dark .aura-editor-btn { color: var(--aura-surface-300, #cbd5e1); }
.dark .aura-editor-btn:hover { background: var(--aura-surface-200, #475569); }
.aura-editor-content {
    padding: 12px 16px; font-size: 0.875rem; line-height: 1.6;
    color: var(--aura-surface-800, #1e293b); outline: none;
}
.dark .aura-editor-content { color: var(--aura-surface-800, #e2e8f0); }
.aura-editor-content:empty::before {
    content: attr(data-placeholder); color: var(--aura-surface-400, #94a3b8);
}
.aura-editor-content h3 { font-size: 1.1rem; font-weight: 600; margin: 8px 0; }
.aura-editor-content ul, .aura-editor-content ol { padding-left: 24px; margin: 4px 0; }
.aura-editor-content a { color: var(--aura-primary-500); text-decoration: underline; }

/* === Form Layout === */
.aura-form { display: flex; flex-direction: column; gap: 24px; }
.aura-form-section {
    padding-bottom: 24px; border-bottom: 1px solid var(--aura-surface-200, #e2e8f0);
}
.aura-form-section:last-of-type { border-bottom: none; padding-bottom: 0; }
.aura-form-section-aside {
    display: grid; grid-template-columns: 280px 1fr; gap: 32px; align-items: start;
}
@media (max-width: 768px) { .aura-form-section-aside { grid-template-columns: 1fr; gap: 16px; } }
.aura-form-section-header { margin-bottom: 16px; }
.aura-form-section-title { font-size: 1rem; font-weight: 600; color: var(--aura-surface-900, #0f172a); }
.dark .aura-form-section-title { color: var(--aura-surface-900, #f8fafc); }
.aura-form-section-description { font-size: 0.85rem; color: var(--aura-surface-500, #64748b); margin-top: 2px; }
.aura-form-section-content { display: flex; flex-direction: column; gap: 16px; }
.aura-form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.aura-form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
@media (max-width: 640px) { .aura-form-grid-2, .aura-form-grid-3 { grid-template-columns: 1fr; } }
.aura-form-actions {
    display: flex; gap: 12px; padding-top: 20px;
    border-top: 1px solid var(--aura-surface-200, #e2e8f0);
}
.aura-form-actions-end { justify-content: flex-end; }
.aura-form-actions-start { justify-content: flex-start; }
.aura-form-actions-center { justify-content: center; }
.aura-form-actions-between { justify-content: space-between; }

/* -------------------------------------------------------
   22. BREADCRUMBS
   ------------------------------------------------------- */
.aura-breadcrumbs { padding: 8px 0; }
.aura-breadcrumbs-list {
    display: flex; align-items: center; flex-wrap: wrap; gap: 0;
    list-style: none; margin: 0; padding: 0;
}
.aura-breadcrumbs-item { display: flex; align-items: center; gap: 6px; font-size: 0.875rem; }
.aura-breadcrumbs-link {
    color: var(--aura-text-secondary); text-decoration: none;
    transition: color var(--aura-duration-fast) var(--aura-ease-out);
    display: flex; align-items: center; gap: 4px;
}
.aura-breadcrumbs-link:hover { color: var(--aura-primary-500); }
.aura-breadcrumbs-current { color: var(--aura-text-primary); font-weight: 500; }
.aura-breadcrumbs-current span { display: flex; align-items: center; gap: 4px; }
.dark .aura-breadcrumbs-link { color: var(--aura-surface-400); }
.dark .aura-breadcrumbs-link:hover { color: var(--aura-primary-400); }
.dark .aura-breadcrumbs-current { color: var(--aura-surface-100); }
.aura-breadcrumbs-separator {
    color: var(--aura-surface-400); margin: 0 8px;
    font-size: 0.875rem; user-select: none; list-style: none;
}

/* -------------------------------------------------------
   23. TABS
   ------------------------------------------------------- */
.aura-tabs { width: 100%; }
.aura-tabs-list {
    display: flex; gap: 0; border-bottom: 2px solid var(--aura-border-light);
    margin-bottom: 16px; overflow-x: auto;
}
.dark .aura-tabs-list { border-bottom-color: var(--aura-surface-700); }
.aura-tabs-trigger {
    display: flex; align-items: center; gap: 6px; padding: 10px 16px;
    font-size: 0.875rem; font-weight: 500; color: var(--aura-text-secondary);
    background: none; border: none; border-bottom: 2px solid transparent;
    margin-bottom: -2px; cursor: pointer; white-space: nowrap;
    transition: all var(--aura-duration-fast) var(--aura-ease-out);
}
.aura-tabs-trigger:hover { color: var(--aura-primary-500); }
.aura-tabs-trigger.aura-tabs-active {
    color: var(--aura-primary-600); border-bottom-color: var(--aura-primary-500);
}
.aura-tabs-trigger:disabled { opacity: 0.5; cursor: not-allowed; }
.dark .aura-tabs-trigger { color: var(--aura-surface-400); }
.dark .aura-tabs-trigger:hover { color: var(--aura-primary-400); }
.dark .aura-tabs-trigger.aura-tabs-active { color: var(--aura-primary-400); border-bottom-color: var(--aura-primary-400); }
.aura-tabs-badge {
    background: var(--aura-primary-100); color: var(--aura-primary-700);
    font-size: 0.7rem; font-weight: 600; padding: 1px 6px; border-radius: var(--aura-radius-full);
}
.dark .aura-tabs-badge { background: var(--aura-primary-900); color: var(--aura-primary-300); }
.aura-tabs-panel { padding: 4px 0; }
/* Pills variant */
.aura-tabs-pills .aura-tabs-list { border-bottom: none; gap: 4px; margin-bottom: 16px; }
.aura-tabs-pills .aura-tabs-trigger {
    border-bottom: none; margin-bottom: 0; border-radius: var(--aura-radius-md);
    padding: 8px 14px;
}
.aura-tabs-pills .aura-tabs-trigger.aura-tabs-active {
    background: var(--aura-primary-500); color: white; border-bottom: none;
}
.dark .aura-tabs-pills .aura-tabs-trigger.aura-tabs-active { background: var(--aura-primary-600); }
/* Bordered variant */
.aura-tabs-bordered .aura-tabs-list { border: 1px solid var(--aura-border-light); border-radius: var(--aura-radius-md); padding: 4px; gap: 4px; border-bottom-width: 1px; }
.aura-tabs-bordered .aura-tabs-trigger { border-bottom: none; margin-bottom: 0; border-radius: var(--aura-radius-sm); }
.aura-tabs-bordered .aura-tabs-trigger.aura-tabs-active { background: var(--aura-surface-100); border-bottom: none; }
.dark .aura-tabs-bordered .aura-tabs-list { border-color: var(--aura-surface-700); }
.dark .aura-tabs-bordered .aura-tabs-trigger.aura-tabs-active { background: var(--aura-surface-700); }
/* Vertical variant */
.aura-tabs-vertical { display: flex; gap: 16px; }
.aura-tabs-vertical .aura-tabs-list {
    flex-direction: column; border-bottom: none; border-right: 2px solid var(--aura-border-light);
    margin-bottom: 0; padding-right: 0; min-width: 160px;
}
.aura-tabs-vertical .aura-tabs-trigger {
    border-bottom: none; border-right: 2px solid transparent; margin-bottom: 0; margin-right: -2px;
    text-align: left; justify-content: flex-start;
}
.aura-tabs-vertical .aura-tabs-trigger.aura-tabs-active { border-right-color: var(--aura-primary-500); border-bottom: none; }
.aura-tabs-vertical .aura-tabs-panels { flex: 1; }
.dark .aura-tabs-vertical .aura-tabs-list { border-right-color: var(--aura-surface-700); }

/* -------------------------------------------------------
   24. ACCORDION
   ------------------------------------------------------- */
.aura-accordion { width: 100%; }
.aura-accordion-bordered .aura-accordion-item {
    border: 1px solid var(--aura-border-light); border-radius: var(--aura-radius-md);
    margin-bottom: 8px; overflow: hidden;
}
.dark .aura-accordion-bordered .aura-accordion-item { border-color: var(--aura-surface-700); }
.aura-accordion-trigger {
    display: flex; align-items: center; justify-content: space-between;
    width: 100%; padding: 12px 16px; font-size: 0.9rem; font-weight: 500;
    color: var(--aura-text-primary); background: var(--aura-surface-50);
    border: none; cursor: pointer;
    transition: background var(--aura-duration-fast) var(--aura-ease-out);
}
.aura-accordion-trigger:hover { background: var(--aura-surface-100); }
.aura-accordion-trigger:disabled { opacity: 0.5; cursor: not-allowed; }
.dark .aura-accordion-trigger { color: var(--aura-surface-100); background: var(--aura-surface-800); }
.dark .aura-accordion-trigger:hover { background: var(--aura-surface-700); }
.aura-accordion-trigger-text { display: flex; align-items: center; gap: 8px; }
.aura-accordion-chevron {
    transition: transform var(--aura-duration-normal) var(--aura-ease-out);
    flex-shrink: 0;
}
.aura-accordion-chevron-open { transform: rotate(180deg); }
.aura-accordion-body { padding: 12px 16px; font-size: 0.875rem; color: var(--aura-text-secondary); }
.dark .aura-accordion-body { color: var(--aura-surface-400); }

/* -------------------------------------------------------
   25. STEPS / WIZARD
   ------------------------------------------------------- */
.aura-steps { width: 100%; }
.aura-steps-list { display: flex; align-items: flex-start; }
.aura-steps-horizontal .aura-steps-list { flex-direction: row; }
.aura-steps-vertical .aura-steps-list { flex-direction: column; }
.aura-steps-item {
    display: flex; align-items: center; gap: 10px; flex: 1; position: relative;
}
.aura-steps-horizontal .aura-steps-item:not(:last-child)::after {
    content: ''; flex: 1; height: 2px; background: var(--aura-border-light);
    margin: 0 12px;
}
.dark .aura-steps-horizontal .aura-steps-item:not(:last-child)::after { background: var(--aura-surface-700); }
.aura-steps-vertical .aura-steps-item { flex: none; padding-bottom: 24px; }
.aura-steps-indicator {
    width: 32px; height: 32px; border-radius: 50%; display: flex;
    align-items: center; justify-content: center; flex-shrink: 0;
    font-size: 0.8rem; font-weight: 600; border: 2px solid var(--aura-border-light);
    color: var(--aura-text-secondary); background: var(--aura-surface-0);
    transition: all var(--aura-duration-normal) var(--aura-ease-out);
}
.dark .aura-steps-indicator { border-color: var(--aura-surface-600); color: var(--aura-surface-400); background: var(--aura-surface-800); }
.aura-steps-sm .aura-steps-indicator { width: 24px; height: 24px; font-size: 0.7rem; }
.aura-steps-lg .aura-steps-indicator { width: 40px; height: 40px; font-size: 0.9rem; }
.aura-steps-number { line-height: 1; }
.aura-steps-check { display: flex; align-items: center; justify-content: center; }
.aura-steps-completed .aura-steps-indicator {
    background: var(--aura-primary-500); border-color: var(--aura-primary-500); color: white;
}
.aura-steps-active .aura-steps-indicator {
    border-color: var(--aura-primary-500); color: var(--aura-primary-600);
    box-shadow: var(--aura-glow-primary);
}
.dark .aura-steps-active .aura-steps-indicator { color: var(--aura-primary-400); }
.aura-steps-content { display: flex; flex-direction: column; gap: 2px; }
.aura-steps-label { font-size: 0.85rem; font-weight: 500; color: var(--aura-text-primary); }
.dark .aura-steps-label { color: var(--aura-surface-200); }
.aura-steps-pending .aura-steps-label { color: var(--aura-text-tertiary); }
.aura-steps-description { font-size: 0.75rem; color: var(--aura-text-tertiary); }

/* -------------------------------------------------------
   26. CONFIRMATION DIALOG
   ------------------------------------------------------- */
.aura-confirm-overlay {
    position: fixed; inset: 0; z-index: var(--aura-z-modal, 60);
    display: flex; align-items: center; justify-content: center;
    background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);
}
.aura-confirm-dialog {
    background: var(--aura-surface-0); border-radius: var(--aura-radius-xl);
    padding: 24px; text-align: center;
    box-shadow: var(--aura-shadow-2xl);
}
.dark .aura-confirm-dialog { background: var(--aura-surface-800); }
.aura-confirm-xs { max-width: 320px; width: 90%; }
.aura-confirm-sm { max-width: 400px; width: 90%; }
.aura-confirm-md { max-width: 480px; width: 90%; }
.aura-confirm-lg { max-width: 560px; width: 90%; }
.aura-confirm-icon {
    width: 48px; height: 48px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
}
.aura-confirm-danger-icon { background: var(--aura-danger-100); color: var(--aura-danger-500); }
.aura-confirm-warning-icon { background: var(--aura-warning-100); color: var(--aura-warning-500); }
.aura-confirm-info-icon { background: var(--aura-info-100); color: var(--aura-info-500); }
.dark .aura-confirm-danger-icon { background: rgba(239, 68, 68, 0.15); }
.dark .aura-confirm-warning-icon { background: rgba(245, 158, 11, 0.15); }
.dark .aura-confirm-info-icon { background: rgba(14, 165, 233, 0.15); }
.aura-confirm-title {
    font-size: 1.1rem; font-weight: 600; color: var(--aura-text-primary); margin-bottom: 8px;
}
.dark .aura-confirm-title { color: var(--aura-surface-100); }
.aura-confirm-message { font-size: 0.875rem; color: var(--aura-text-secondary); margin-bottom: 16px; }
.dark .aura-confirm-message { color: var(--aura-surface-400); }
.aura-confirm-input { margin-bottom: 16px; text-align: left; }
.aura-confirm-input-label { display: block; font-size: 0.85rem; color: var(--aura-text-secondary); margin-bottom: 6px; }
.aura-confirm-actions { display: flex; gap: 8px; justify-content: center; }

/* -------------------------------------------------------
   27. TOAST NOTIFICATIONS
   ------------------------------------------------------- */
.aura-toasts {
    position: fixed; display: flex; flex-direction: column; gap: 8px;
    pointer-events: none; padding: 16px; max-width: 420px; width: 100%;
}
.aura-toasts-top-right { top: 0; right: 0; }
.aura-toasts-top-left { top: 0; left: 0; }
.aura-toasts-top-center { top: 0; left: 50%; transform: translateX(-50%); }
.aura-toasts-bottom-right { bottom: 0; right: 0; flex-direction: column-reverse; }
.aura-toasts-bottom-left { bottom: 0; left: 0; flex-direction: column-reverse; }
.aura-toasts-bottom-center { bottom: 0; left: 50%; transform: translateX(-50%); flex-direction: column-reverse; }
.aura-toast {
    pointer-events: auto; background: var(--aura-surface-0);
    border-radius: var(--aura-radius-lg); box-shadow: var(--aura-shadow-lg);
    display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px;
    position: relative; overflow: hidden;
    border-left: 4px solid var(--aura-info-500);
}
.dark .aura-toast { background: var(--aura-surface-800); }
.aura-toast-success { border-left-color: var(--aura-success-500); }
.aura-toast-danger, .aura-toast-error { border-left-color: var(--aura-danger-500); }
.aura-toast-warning { border-left-color: var(--aura-warning-500); }
.aura-toast-info { border-left-color: var(--aura-info-500); }
.aura-toast-icon { flex-shrink: 0; margin-top: 1px; }
.aura-toast-success .aura-toast-icon { color: var(--aura-success-500); }
.aura-toast-danger .aura-toast-icon, .aura-toast-error .aura-toast-icon { color: var(--aura-danger-500); }
.aura-toast-warning .aura-toast-icon { color: var(--aura-warning-500); }
.aura-toast-info .aura-toast-icon { color: var(--aura-info-500); }
.aura-toast-content { flex: 1; min-width: 0; }
.aura-toast-title { font-size: 0.875rem; font-weight: 600; color: var(--aura-text-primary); margin-bottom: 2px; }
.dark .aura-toast-title { color: var(--aura-surface-100); }
.aura-toast-message { font-size: 0.8rem; color: var(--aura-text-secondary); }
.dark .aura-toast-message { color: var(--aura-surface-400); }
.aura-toast-close {
    flex-shrink: 0; background: none; border: none; cursor: pointer;
    color: var(--aura-surface-400); padding: 2px;
    transition: color var(--aura-duration-fast) var(--aura-ease-out);
}
.aura-toast-close:hover { color: var(--aura-text-primary); }
.dark .aura-toast-close:hover { color: var(--aura-surface-200); }
.aura-toast-progress {
    position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
    background: var(--aura-surface-100);
}
.dark .aura-toast-progress { background: var(--aura-surface-700); }
.aura-toast-progress-bar {
    height: 100%; transition: width 50ms linear;
}
.aura-toast-success .aura-toast-progress-bar { background: var(--aura-success-500); }
.aura-toast-danger .aura-toast-progress-bar, .aura-toast-error .aura-toast-progress-bar { background: var(--aura-danger-500); }
.aura-toast-warning .aura-toast-progress-bar { background: var(--aura-warning-500); }
.aura-toast-info .aura-toast-progress-bar { background: var(--aura-info-500); }

/* -------------------------------------------------------
   28. SIDEBAR NAVIGATION
   ------------------------------------------------------- */
.aura-sidebar {
    display: flex; flex-direction: column; height: 100vh;
    background: var(--aura-surface-0); border-right: 1px solid var(--aura-border-light);
    transition: width var(--aura-duration-slow) var(--aura-ease-out);
    overflow: hidden; position: relative; flex-shrink: 0;
}
.dark .aura-sidebar { background: var(--aura-surface-900); border-right-color: var(--aura-surface-700); }
.aura-sidebar-brand {
    display: flex; align-items: center; gap: 12px; padding: 16px;
    text-decoration: none; color: var(--aura-text-primary); font-weight: 600;
    border-bottom: 1px solid var(--aura-border-light);
}
.dark .aura-sidebar-brand { color: var(--aura-surface-100); border-bottom-color: var(--aura-surface-700); }
.aura-sidebar-section { padding: 8px 0; }
.aura-sidebar-section-label {
    font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;
    color: var(--aura-text-tertiary); padding: 8px 16px 4px;
}
.aura-sidebar-section-items { display: flex; flex-direction: column; gap: 1px; }
.aura-sidebar-item {
    display: flex; align-items: center; gap: 10px; width: 100%;
    padding: 8px 16px; font-size: 0.875rem; color: var(--aura-text-secondary);
    background: none; border: none; cursor: pointer; text-decoration: none;
    transition: all var(--aura-duration-fast) var(--aura-ease-out);
}
.aura-sidebar-item:hover { background: var(--aura-surface-100); color: var(--aura-text-primary); }
.dark .aura-sidebar-item { color: var(--aura-surface-400); }
.dark .aura-sidebar-item:hover { background: var(--aura-surface-800); color: var(--aura-surface-200); }
.aura-sidebar-item-active {
    background: var(--aura-primary-50); color: var(--aura-primary-600); font-weight: 500;
}
.aura-sidebar-item-active:hover { background: var(--aura-primary-50); }
.dark .aura-sidebar-item-active { background: rgba(99, 102, 241, 0.1); color: var(--aura-primary-400); }
.aura-sidebar-item-icon { flex-shrink: 0; display: flex; }
.aura-sidebar-item-label { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.aura-sidebar-item-arrow {
    margin-left: auto; transition: transform var(--aura-duration-fast) var(--aura-ease-out);
    flex-shrink: 0;
}
.aura-sidebar-item-arrow-open { transform: rotate(180deg); }
.aura-sidebar-subitems { padding-left: 40px; }
.aura-sidebar-subitem {
    display: block; padding: 6px 16px; font-size: 0.825rem;
    color: var(--aura-text-secondary); text-decoration: none;
    transition: color var(--aura-duration-fast) var(--aura-ease-out);
}
.aura-sidebar-subitem:hover { color: var(--aura-primary-500); }
.aura-sidebar-subitem-active { color: var(--aura-primary-600); font-weight: 500; }
.dark .aura-sidebar-subitem { color: var(--aura-surface-400); }
.dark .aura-sidebar-subitem:hover { color: var(--aura-primary-400); }
.dark .aura-sidebar-subitem-active { color: var(--aura-primary-400); }
.aura-sidebar-toggle {
    position: absolute; bottom: 16px; right: -12px;
    width: 24px; height: 24px; border-radius: 50%;
    background: var(--aura-surface-0); border: 1px solid var(--aura-border-light);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; box-shadow: var(--aura-shadow-sm);
    transition: transform var(--aura-duration-fast) var(--aura-ease-out);
}
.dark .aura-sidebar-toggle { background: var(--aura-surface-800); border-color: var(--aura-surface-600); }
.aura-sidebar-toggle-rotated { transform: rotate(180deg); }

/* -------------------------------------------------------
   29. TREE VIEW
   ------------------------------------------------------- */
.aura-tree { width: 100%; }
.aura-tree-list { list-style: none; margin: 0; padding: 0; }
.aura-tree-children { list-style: none; margin: 0; padding: 0; padding-left: 20px; }
.aura-tree-connectors .aura-tree-children {
    border-left: 1px solid var(--aura-border-light); margin-left: 10px; padding-left: 10px;
}
.dark .aura-tree-connectors .aura-tree-children { border-left-color: var(--aura-surface-700); }
.aura-tree-node { margin: 0; }
.aura-tree-node-content {
    display: flex; align-items: center; gap: 4px; padding: 4px 8px;
    border-radius: var(--aura-radius-sm); cursor: default;
    transition: background var(--aura-duration-fast) var(--aura-ease-out);
}
.aura-tree-node-content:hover { background: var(--aura-surface-100); }
.dark .aura-tree-node-content:hover { background: var(--aura-surface-800); }
.aura-tree-node-selected { background: var(--aura-primary-50); }
.dark .aura-tree-node-selected { background: rgba(99, 102, 241, 0.1); }
.aura-tree-node-toggle {
    background: none; border: none; cursor: pointer; padding: 2px;
    color: var(--aura-text-tertiary); display: flex; align-items: center;
}
.aura-tree-node-spacer { width: 16px; flex-shrink: 0; }
.aura-tree-chevron {
    transition: transform var(--aura-duration-fast) var(--aura-ease-out);
}
.aura-tree-chevron-open { transform: rotate(90deg); }
.aura-tree-node-icon { flex-shrink: 0; color: var(--aura-text-tertiary); display: flex; }
.aura-tree-node-label {
    font-size: 0.875rem; color: var(--aura-text-primary); cursor: pointer; user-select: none;
}
.dark .aura-tree-node-label { color: var(--aura-surface-200); }

/* -------------------------------------------------------
   30. COMMAND PALETTE
   ------------------------------------------------------- */
.aura-command-overlay {
    position: fixed; inset: 0; z-index: var(--aura-z-command, 75);
    display: flex; align-items: flex-start; justify-content: center;
    padding-top: 15vh; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);
}
.aura-command-dialog {
    background: var(--aura-surface-0); border-radius: var(--aura-radius-xl);
    box-shadow: var(--aura-shadow-2xl); max-width: 560px; width: 90%;
    overflow: hidden;
}
.dark .aura-command-dialog { background: var(--aura-surface-800); }
.aura-command-input-wrapper {
    display: flex; align-items: center; gap: 10px; padding: 14px 16px;
    border-bottom: 1px solid var(--aura-border-light);
}
.dark .aura-command-input-wrapper { border-bottom-color: var(--aura-surface-700); }
.aura-command-input-icon { flex-shrink: 0; color: var(--aura-text-tertiary); }
.aura-command-input {
    flex: 1; border: none; outline: none; font-size: 0.95rem;
    background: transparent; color: var(--aura-text-primary);
}
.dark .aura-command-input { color: var(--aura-surface-100); }
.aura-command-input::placeholder { color: var(--aura-text-tertiary); }
.aura-command-kbd {
    font-size: 0.7rem; padding: 2px 6px; border-radius: var(--aura-radius-sm);
    background: var(--aura-surface-100); color: var(--aura-text-tertiary);
    border: 1px solid var(--aura-border-light); font-family: inherit;
}
.dark .aura-command-kbd { background: var(--aura-surface-700); border-color: var(--aura-surface-600); color: var(--aura-surface-400); }
.aura-command-list { max-height: 300px; overflow-y: auto; padding: 8px; }
.aura-command-group { margin-bottom: 8px; }
.aura-command-group:last-child { margin-bottom: 0; }
.aura-command-group-heading {
    font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;
    color: var(--aura-text-tertiary); padding: 6px 8px;
}
.aura-command-item {
    display: flex; align-items: center; gap: 10px; width: 100%;
    padding: 10px 12px; border-radius: var(--aura-radius-md);
    background: none; border: none; cursor: pointer; text-align: left;
    color: var(--aura-text-primary); font-size: 0.875rem;
    transition: background var(--aura-duration-fast) var(--aura-ease-out);
}
.aura-command-item:hover { background: var(--aura-surface-100); }
.dark .aura-command-item { color: var(--aura-surface-200); }
.dark .aura-command-item:hover { background: var(--aura-surface-700); }
.aura-command-item-icon { flex-shrink: 0; color: var(--aura-text-tertiary); display: flex; }
.aura-command-item-content { flex: 1; display: flex; flex-direction: column; gap: 1px; }
.aura-command-item-label { font-weight: 500; }
.aura-command-item-description { font-size: 0.75rem; color: var(--aura-text-tertiary); }
.aura-command-item-shortcut {
    font-size: 0.7rem; padding: 2px 6px; border-radius: var(--aura-radius-sm);
    background: var(--aura-surface-100); color: var(--aura-text-tertiary);
    border: 1px solid var(--aura-border-light); font-family: inherit;
}
.dark .aura-command-item-shortcut { background: var(--aura-surface-700); border-color: var(--aura-surface-600); }
.aura-command-empty {
    padding: 24px; text-align: center; font-size: 0.875rem; color: var(--aura-text-tertiary);
}
.aura-command-footer {
    display: flex; gap: 16px; padding: 10px 16px; justify-content: center;
    border-top: 1px solid var(--aura-border-light); font-size: 0.75rem; color: var(--aura-text-tertiary);
}
.dark .aura-command-footer { border-top-color: var(--aura-surface-700); }
.aura-command-hint { display: flex; align-items: center; gap: 4px; }
.aura-command-hint kbd {
    font-size: 0.65rem; padding: 1px 4px; border-radius: 3px;
    background: var(--aura-surface-100); border: 1px solid var(--aura-border-light); font-family: inherit;
}
.dark .aura-command-hint kbd { background: var(--aura-surface-700); border-color: var(--aura-surface-600); }

/* -------------------------------------------------------
   31. CHARTS
   ------------------------------------------------------- */
.aura-chart {
    background: var(--aura-surface-0); border-radius: var(--aura-radius-lg);
    padding: 16px;
}
.dark .aura-chart { background: var(--aura-surface-800); }
.aura-chart canvas { width: 100% !important; }

/* -------------------------------------------------------
   32. CALENDAR
   ------------------------------------------------------- */
.aura-calendar {
    background: var(--aura-surface-0); border-radius: var(--aura-radius-lg);
    border: 1px solid var(--aura-border-light); overflow: hidden;
}
.dark .aura-calendar { background: var(--aura-surface-800); border-color: var(--aura-surface-700); }
.aura-calendar-header {
    display: flex; align-items: center; gap: 8px; padding: 12px 16px;
    border-bottom: 1px solid var(--aura-border-light);
}
.dark .aura-calendar-header { border-bottom-color: var(--aura-surface-700); }
.aura-calendar-title {
    flex: 1; text-align: center; font-weight: 600; font-size: 0.95rem;
    color: var(--aura-text-primary); text-transform: capitalize;
}
.dark .aura-calendar-title { color: var(--aura-surface-100); }
.aura-calendar-nav {
    background: none; border: 1px solid var(--aura-border-light); border-radius: var(--aura-radius-sm);
    padding: 6px; cursor: pointer; color: var(--aura-text-secondary);
    display: flex; align-items: center;
    transition: all var(--aura-duration-fast) var(--aura-ease-out);
}
.aura-calendar-nav:hover { background: var(--aura-surface-100); color: var(--aura-text-primary); }
.dark .aura-calendar-nav { border-color: var(--aura-surface-600); color: var(--aura-surface-400); }
.dark .aura-calendar-nav:hover { background: var(--aura-surface-700); color: var(--aura-surface-200); }
.aura-calendar-grid {
    display: grid; grid-template-columns: repeat(7, 1fr); gap: 0;
}
.aura-calendar-dayname {
    padding: 8px 4px; text-align: center; font-size: 0.75rem; font-weight: 600;
    color: var(--aura-text-tertiary); text-transform: uppercase;
}
.aura-calendar-cell {
    min-height: 80px; padding: 4px; border-top: 1px solid var(--aura-border-light);
    border-right: 1px solid var(--aura-border-light);
    font-size: 0.8rem;
}
.aura-calendar-cell:nth-child(7n) { border-right: none; }
.dark .aura-calendar-cell { border-color: var(--aura-surface-700); }
.aura-calendar-date {
    display: inline-flex; align-items: center; justify-content: center;
    width: 24px; height: 24px; border-radius: 50%; font-size: 0.8rem;
    color: var(--aura-text-primary); margin-bottom: 2px;
}
.dark .aura-calendar-date { color: var(--aura-surface-300); }
.aura-calendar-today .aura-calendar-date {
    background: var(--aura-primary-500); color: white; font-weight: 600;
}
.aura-calendar-other { background: var(--aura-surface-50); }
.aura-calendar-other .aura-calendar-date { color: var(--aura-text-tertiary); }
.dark .aura-calendar-other { background: var(--aura-surface-900); }
.dark .aura-calendar-other .aura-calendar-date { color: var(--aura-surface-600); }
.aura-calendar-event {
    font-size: 0.7rem; padding: 2px 4px; border-radius: 3px;
    background: var(--aura-primary-100); color: var(--aura-primary-700);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px;
}
.dark .aura-calendar-event { background: var(--aura-primary-900); color: var(--aura-primary-300); }

/* -------------------------------------------------------
   33. KANBAN BOARD
   ------------------------------------------------------- */
.aura-kanban { width: 100%; overflow-x: auto; }
.aura-kanban-board {
    display: flex; gap: 16px; min-width: min-content; padding: 4px;
}
.aura-kanban-column {
    min-width: 280px; max-width: 320px; flex-shrink: 0;
    background: var(--aura-surface-50); border-radius: var(--aura-radius-lg);
    display: flex; flex-direction: column;
}
.dark .aura-kanban-column { background: var(--aura-surface-800); }
.aura-kanban-column-over { outline: 2px dashed var(--aura-primary-400); outline-offset: -2px; }
.aura-kanban-column-header {
    display: flex; align-items: center; gap: 8px; padding: 12px 16px;
    font-weight: 600; font-size: 0.875rem; color: var(--aura-text-primary);
}
.dark .aura-kanban-column-header { color: var(--aura-surface-200); }
.aura-kanban-column-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.aura-kanban-column-title { flex: 1; }
.aura-kanban-column-count {
    font-size: 0.75rem; font-weight: 500; color: var(--aura-text-tertiary);
    background: var(--aura-surface-200); padding: 1px 8px; border-radius: var(--aura-radius-full);
}
.dark .aura-kanban-column-count { background: var(--aura-surface-700); color: var(--aura-surface-400); }
.aura-kanban-column-body {
    flex: 1; padding: 0 8px 8px; display: flex; flex-direction: column; gap: 8px;
    min-height: 100px;
}
.aura-kanban-card {
    background: var(--aura-surface-0); border-radius: var(--aura-radius-md);
    padding: 12px; box-shadow: var(--aura-shadow-sm); border: 1px solid var(--aura-border-light);
    cursor: grab; font-size: 0.875rem; color: var(--aura-text-primary);
    transition: box-shadow var(--aura-duration-fast) var(--aura-ease-out);
}
.aura-kanban-card:hover { box-shadow: var(--aura-shadow-md); }
.dark .aura-kanban-card { background: var(--aura-surface-900); border-color: var(--aura-surface-700); color: var(--aura-surface-200); }
.aura-kanban-card-dragging { opacity: 0.5; }
</style>
