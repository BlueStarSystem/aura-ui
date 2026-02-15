<section id="datatable-preview" class="aura-playground-section">
    <h2 class="aura-section-title">DataTable</h2>
    <p class="aura-section-description">
        Preview statico del componente DataTable. Il componente reale richiede Livewire per interattivita' (ricerca, ordinamento, filtri, paginazione).
    </p>

    <h3 class="aura-section-subtitle">Full Table UI</h3>
    <div class="aura-card" style="overflow: hidden;">
        <div class="aura-datatable">
            {{-- Header bar --}}
            <div class="aura-datatable-header">
                <div class="aura-datatable-toolbar">
                    <div style="position: relative;">
                        <svg style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--aura-text-tertiary);" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" class="aura-input" placeholder="Cerca clienti..." style="padding-left: 34px; max-width: 260px; height: 36px; font-size: 13px;">
                    </div>
                </div>
                <div class="aura-datatable-toolbar">
                    <button class="aura-btn aura-btn-secondary aura-btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                        Filtri
                    </button>
                    <button class="aura-btn aura-btn-secondary aura-btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3h7a2 2 0 012 2v14a2 2 0 01-2 2h-7m0-18H5a2 2 0 00-2 2v14a2 2 0 002 2h7m0-18v18"/></svg>
                        Colonne
                    </button>
                    <button class="aura-btn aura-btn-primary aura-btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Nuovo Cliente
                    </button>
                </div>
            </div>

            {{-- Bulk action bar --}}
            <div class="aura-datatable-bulk-bar">
                <span style="font-weight: 600;">3 selezionati</span>
                <button class="aura-btn aura-btn-danger aura-btn-xs">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                    Elimina selezionati
                </button>
                <button class="aura-btn aura-btn-secondary aura-btn-xs">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Esporta CSV
                </button>
            </div>

            {{-- Table --}}
            <table>
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <label class="aura-checkbox" style="justify-content: center;">
                                <input type="checkbox" checked>
                                <span class="aura-checkbox-box">
                                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                </span>
                            </label>
                        </th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Stato</th>
                        <th>Creato il</th>
                        <th style="width: 60px; text-align: center;">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="aura-row-selected">
                        <td style="text-align: center;">
                            <label class="aura-checkbox" style="justify-content: center;">
                                <input type="checkbox" checked>
                                <span class="aura-checkbox-box">
                                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                </span>
                            </label>
                        </td>
                        <td style="font-weight: 500;">Marco Bianchi</td>
                        <td style="color: var(--aura-text-secondary);">marco.bianchi@email.it</td>
                        <td style="color: var(--aura-text-secondary);">+39 02 1234567</td>
                        <td><span class="aura-badge aura-badge-dot aura-badge-success">Attivo</span></td>
                        <td style="color: var(--aura-text-tertiary); font-size: 13px;">14 Feb 2026</td>
                        <td style="text-align: center;">
                            <button class="aura-btn aura-btn-ghost aura-btn-xs" style="padding: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="aura-row-selected">
                        <td style="text-align: center;">
                            <label class="aura-checkbox" style="justify-content: center;">
                                <input type="checkbox" checked>
                                <span class="aura-checkbox-box">
                                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                </span>
                            </label>
                        </td>
                        <td style="font-weight: 500;">Giulia Rossi</td>
                        <td style="color: var(--aura-text-secondary);">giulia.rossi@email.it</td>
                        <td style="color: var(--aura-text-secondary);">+39 06 7654321</td>
                        <td><span class="aura-badge aura-badge-dot aura-badge-success">Attivo</span></td>
                        <td style="color: var(--aura-text-tertiary); font-size: 13px;">12 Feb 2026</td>
                        <td style="text-align: center;">
                            <button class="aura-btn aura-btn-ghost aura-btn-xs" style="padding: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="aura-row-selected">
                        <td style="text-align: center;">
                            <label class="aura-checkbox" style="justify-content: center;">
                                <input type="checkbox" checked>
                                <span class="aura-checkbox-box">
                                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                </span>
                            </label>
                        </td>
                        <td style="font-weight: 500;">Alessandro Verdi</td>
                        <td style="color: var(--aura-text-secondary);">a.verdi@email.it</td>
                        <td style="color: var(--aura-text-secondary);">+39 055 9876543</td>
                        <td><span class="aura-badge aura-badge-dot aura-badge-warning">In attesa</span></td>
                        <td style="color: var(--aura-text-tertiary); font-size: 13px;">10 Feb 2026</td>
                        <td style="text-align: center;">
                            <button class="aura-btn aura-btn-ghost aura-btn-xs" style="padding: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <label class="aura-checkbox" style="justify-content: center;">
                                <input type="checkbox">
                                <span class="aura-checkbox-box">
                                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                </span>
                            </label>
                        </td>
                        <td style="font-weight: 500;">Francesca Neri</td>
                        <td style="color: var(--aura-text-secondary);">f.neri@email.it</td>
                        <td style="color: var(--aura-text-secondary);">+39 011 1122334</td>
                        <td><span class="aura-badge aura-badge-dot aura-badge-danger">Inattivo</span></td>
                        <td style="color: var(--aura-text-tertiary); font-size: 13px;">8 Feb 2026</td>
                        <td style="text-align: center;">
                            <button class="aura-btn aura-btn-ghost aura-btn-xs" style="padding: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <label class="aura-checkbox" style="justify-content: center;">
                                <input type="checkbox">
                                <span class="aura-checkbox-box">
                                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                </span>
                            </label>
                        </td>
                        <td style="font-weight: 500;">Luca Colombo</td>
                        <td style="color: var(--aura-text-secondary);">luca.colombo@email.it</td>
                        <td style="color: var(--aura-text-secondary);">+39 041 5566778</td>
                        <td><span class="aura-badge aura-badge-dot aura-badge-success">Attivo</span></td>
                        <td style="color: var(--aura-text-tertiary); font-size: 13px;">5 Feb 2026</td>
                        <td style="text-align: center;">
                            <button class="aura-btn aura-btn-ghost aura-btn-xs" style="padding: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- Pagination footer --}}
            <div class="aura-datatable-footer">
                <span>Mostra 1-10 di 156</span>
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div class="aura-datatable-per-page">
                        <span>Righe per pagina:</span>
                        <select>
                            <option selected>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>
                    <div class="aura-datatable-pagination">
                        <button class="aura-datatable-page-btn" disabled style="opacity: 0.4; cursor: not-allowed;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <button class="aura-datatable-page-btn active">1</button>
                        <button class="aura-datatable-page-btn">2</button>
                        <button class="aura-datatable-page-btn">3</button>
                        <span style="padding: 0 4px; color: var(--aura-text-tertiary);">...</span>
                        <button class="aura-datatable-page-btn">16</button>
                        <button class="aura-datatable-page-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Empty State</h3>
    <div class="aura-card" style="overflow: hidden;">
        <div class="aura-datatable">
            <div class="aura-datatable-header">
                <div class="aura-datatable-toolbar">
                    <div style="position: relative;">
                        <svg style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--aura-text-tertiary);" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" class="aura-input" placeholder="Cerca..." value="zzzzxxx" style="padding-left: 34px; max-width: 260px; height: 36px; font-size: 13px;">
                    </div>
                </div>
                <div class="aura-datatable-toolbar">
                    <button class="aura-btn aura-btn-secondary aura-btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                        Filtri
                    </button>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <label class="aura-checkbox" style="justify-content: center;">
                                <input type="checkbox" disabled>
                                <span class="aura-checkbox-box">
                                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                </span>
                            </label>
                        </th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Stato</th>
                        <th>Creato il</th>
                        <th style="width: 60px; text-align: center;">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" style="padding: 0; border: none;">
                            <div class="aura-empty-state" style="padding: 48px 24px;">
                                <div class="aura-empty-state-icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                </div>
                                <h3 class="aura-empty-state-title">Nessun risultato</h3>
                                <p class="aura-empty-state-description">Nessun elemento corrisponde ai criteri di ricerca. Prova a modificare la query.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
