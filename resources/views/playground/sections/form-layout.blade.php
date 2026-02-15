<section id="form-layout" class="aura-playground-section">
    <h2 class="aura-section-title">Form Layout</h2>

    <h3 class="aura-section-subtitle">Form with Sections</h3>
    <div class="aura-component-col">
        <form class="aura-form" onsubmit="return false;">
            <div class="aura-form-section">
                <div class="aura-form-section-header">
                    <h3 class="aura-form-section-title">Informazioni personali</h3>
                    <p class="aura-form-section-description">Compila i dati anagrafici dell'utente.</p>
                </div>
                <div class="aura-form-section-content aura-form-grid-2">
                    <div class="aura-input-wrapper">
                        <label class="aura-label">Nome <span class="aura-required">*</span></label>
                        <input type="text" class="aura-input" placeholder="Mario" />
                    </div>
                    <div class="aura-input-wrapper">
                        <label class="aura-label">Cognome <span class="aura-required">*</span></label>
                        <input type="text" class="aura-input" placeholder="Rossi" />
                    </div>
                    <div class="aura-input-wrapper">
                        <label class="aura-label">Email <span class="aura-required">*</span></label>
                        <input type="email" class="aura-input" placeholder="mario@esempio.it" />
                    </div>
                    <div class="aura-input-wrapper">
                        <label class="aura-label">Telefono</label>
                        <input type="tel" class="aura-input" placeholder="+39 02 1234567" />
                    </div>
                </div>
            </div>

            <div class="aura-form-section">
                <div class="aura-form-section-header">
                    <h3 class="aura-form-section-title">Indirizzo</h3>
                    <p class="aura-form-section-description">Indirizzo di residenza o fatturazione.</p>
                </div>
                <div class="aura-form-section-content aura-form-grid-1">
                    <div class="aura-input-wrapper">
                        <label class="aura-label">Via</label>
                        <input type="text" class="aura-input" placeholder="Via Roma 1" />
                    </div>
                </div>
                <div class="aura-form-section-content aura-form-grid-3">
                    <div class="aura-input-wrapper">
                        <label class="aura-label">Citta'</label>
                        <input type="text" class="aura-input" placeholder="Venezia" />
                    </div>
                    <div class="aura-input-wrapper">
                        <label class="aura-label">Provincia</label>
                        <input type="text" class="aura-input" placeholder="VE" />
                    </div>
                    <div class="aura-input-wrapper">
                        <label class="aura-label">CAP</label>
                        <input type="text" class="aura-input" placeholder="30100" />
                    </div>
                </div>
            </div>

            <div class="aura-form-actions aura-form-actions-end">
                <button type="button" class="aura-btn aura-btn-ghost">Annulla</button>
                <button type="submit" class="aura-btn aura-btn-primary">Salva</button>
            </div>
        </form>
    </div>

    <h3 class="aura-section-subtitle">Form.Section Aside Layout</h3>
    <div class="aura-component-col">
        <form class="aura-form" onsubmit="return false;">
            <div class="aura-form-section aura-form-section-aside">
                <div class="aura-form-section-header">
                    <h3 class="aura-form-section-title">Profilo</h3>
                    <p class="aura-form-section-description">Queste informazioni saranno visibili pubblicamente.</p>
                </div>
                <div class="aura-form-section-content aura-form-grid-1">
                    <div class="aura-input-wrapper">
                        <label class="aura-label">Username</label>
                        <input type="text" class="aura-input" placeholder="mario_rossi" />
                    </div>
                    <div class="aura-input-wrapper">
                        <label class="aura-label">Bio</label>
                        <textarea class="aura-textarea" rows="3" placeholder="Scrivi qualcosa su di te..."></textarea>
                    </div>
                </div>
            </div>

            <div class="aura-form-section aura-form-section-aside">
                <div class="aura-form-section-header">
                    <h3 class="aura-form-section-title">Notifiche</h3>
                    <p class="aura-form-section-description">Configura come ricevere le notifiche.</p>
                </div>
                <div class="aura-form-section-content aura-form-grid-1">
                    <label class="aura-toggle">
                        <input type="checkbox" checked>
                        <span class="aura-toggle-track">
                            <span class="aura-toggle-knob"></span>
                        </span>
                        <span class="aura-toggle-label">Notifiche email</span>
                    </label>
                    <label class="aura-toggle">
                        <input type="checkbox">
                        <span class="aura-toggle-track">
                            <span class="aura-toggle-knob"></span>
                        </span>
                        <span class="aura-toggle-label">Notifiche push</span>
                    </label>
                    <label class="aura-toggle">
                        <input type="checkbox">
                        <span class="aura-toggle-track">
                            <span class="aura-toggle-knob"></span>
                        </span>
                        <span class="aura-toggle-label">Newsletter settimanale</span>
                    </label>
                </div>
            </div>

            <div class="aura-form-actions aura-form-actions-end">
                <button type="button" class="aura-btn aura-btn-ghost">Annulla</button>
                <button type="submit" class="aura-btn aura-btn-primary">Salva preferenze</button>
            </div>
        </form>
    </div>

    <h3 class="aura-section-subtitle">Form.Actions Alignment</h3>
    <div class="aura-component-col">
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <span class="aura-input-hint" style="margin-bottom: 0.5rem; display: block;">align="end" (default)</span>
                <div class="aura-form-actions aura-form-actions-end">
                    <button type="button" class="aura-btn aura-btn-ghost">Annulla</button>
                    <button type="button" class="aura-btn aura-btn-primary">Salva</button>
                </div>
            </div>
            <div>
                <span class="aura-input-hint" style="margin-bottom: 0.5rem; display: block;">align="start"</span>
                <div class="aura-form-actions aura-form-actions-start">
                    <button type="button" class="aura-btn aura-btn-ghost">Annulla</button>
                    <button type="button" class="aura-btn aura-btn-primary">Salva</button>
                </div>
            </div>
            <div>
                <span class="aura-input-hint" style="margin-bottom: 0.5rem; display: block;">align="center"</span>
                <div class="aura-form-actions aura-form-actions-center">
                    <button type="button" class="aura-btn aura-btn-ghost">Annulla</button>
                    <button type="button" class="aura-btn aura-btn-primary">Salva</button>
                </div>
            </div>
            <div>
                <span class="aura-input-hint" style="margin-bottom: 0.5rem; display: block;">align="between"</span>
                <div class="aura-form-actions aura-form-actions-between">
                    <button type="button" class="aura-btn aura-btn-danger">Elimina account</button>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="button" class="aura-btn aura-btn-ghost">Annulla</button>
                        <button type="button" class="aura-btn aura-btn-primary">Salva</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Editor Section --}}
    <h2 class="aura-section-title" style="margin-top: 2rem;">Editor</h2>

    <h3 class="aura-section-subtitle">Basic Editor</h3>
    <div class="aura-component-col">
        <div x-data="{
            exec(cmd) {
                if (cmd === 'link') {
                    let url = prompt('URL:');
                    if (url) document.execCommand('createLink', false, url);
                } else if (cmd === 'heading') {
                    document.execCommand('formatBlock', false, '<h3>');
                } else {
                    document.execCommand(cmd, false, null);
                }
                this.$refs.editable.focus();
            }
        }" class="aura-editor-wrapper">
            <label class="aura-label">Descrizione</label>
            <div class="aura-editor">
                <div class="aura-editor-toolbar">
                    <button type="button" class="aura-editor-btn" x-on:click="exec('bold')" title="Grassetto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"/><path d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" x-on:click="exec('italic')" title="Corsivo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="4" x2="10" y2="4"/><line x1="14" y1="20" x2="5" y2="20"/><line x1="15" y1="4" x2="9" y2="20"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" x-on:click="exec('underline')" title="Sottolineato">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3v7a6 6 0 006 6 6 6 0 006-6V3"/><line x1="4" y1="21" x2="20" y2="21"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" x-on:click="exec('link')" title="Link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" x-on:click="exec('insertOrderedList')" title="Lista numerata">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" x-on:click="exec('insertUnorderedList')" title="Lista puntata">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" x-on:click="exec('heading')" title="Intestazione">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 7 4 4 20 4 20 7"/><line x1="9" y1="20" x2="15" y2="20"/><line x1="12" y1="4" x2="12" y2="20"/></svg>
                    </button>
                </div>
                <div x-ref="editable" class="aura-editor-content" contenteditable="true" style="min-height: 150px;" data-placeholder="Scrivi qui..."></div>
            </div>
            <span class="aura-input-hint">Usa la toolbar per formattare il testo.</span>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Editor with Content</h3>
    <div class="aura-component-col">
        <div x-data="{
            exec(cmd) {
                if (cmd === 'link') {
                    let url = prompt('URL:');
                    if (url) document.execCommand('createLink', false, url);
                } else if (cmd === 'heading') {
                    document.execCommand('formatBlock', false, '<h3>');
                } else {
                    document.execCommand(cmd, false, null);
                }
                this.$refs.editable2.focus();
            }
        }" class="aura-editor-wrapper">
            <label class="aura-label">Note (con contenuto)</label>
            <div class="aura-editor">
                <div class="aura-editor-toolbar">
                    <button type="button" class="aura-editor-btn" x-on:click="exec('bold')" title="Grassetto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"/><path d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" x-on:click="exec('italic')" title="Corsivo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="4" x2="10" y2="4"/><line x1="14" y1="20" x2="5" y2="20"/><line x1="15" y1="4" x2="9" y2="20"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" x-on:click="exec('underline')" title="Sottolineato">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3v7a6 6 0 006 6 6 6 0 006-6V3"/><line x1="4" y1="21" x2="20" y2="21"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" x-on:click="exec('link')" title="Link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" x-on:click="exec('insertUnorderedList')" title="Lista puntata">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    </button>
                </div>
                <div x-ref="editable2" class="aura-editor-content" contenteditable="true" style="min-height: 150px;">
                    <h3>Benvenuto in Aura UI</h3>
                    <p>Questo e' un <strong>editor ricco</strong> con supporto per <em>formattazione</em> inline.</p>
                    <ul>
                        <li>Grassetto, corsivo, sottolineato</li>
                        <li>Link e intestazioni</li>
                        <li>Liste ordinate e non ordinate</li>
                    </ul>
                    <p>L'editor si basa su <code>contenteditable</code> e <code>execCommand</code>.</p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Editor Disabled</h3>
    <div class="aura-component-col">
        <div class="aura-editor-wrapper">
            <label class="aura-label">Contenuto (sola lettura)</label>
            <div class="aura-editor aura-editor-disabled">
                <div class="aura-editor-toolbar">
                    <button type="button" class="aura-editor-btn" disabled title="Grassetto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"/><path d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" disabled title="Corsivo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="4" x2="10" y2="4"/><line x1="14" y1="20" x2="5" y2="20"/><line x1="15" y1="4" x2="9" y2="20"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" disabled title="Sottolineato">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3v7a6 6 0 006 6 6 6 0 006-6V3"/><line x1="4" y1="21" x2="20" y2="21"/></svg>
                    </button>
                </div>
                <div class="aura-editor-content" contenteditable="false" style="min-height: 100px;">
                    <p>Questo contenuto non e' modificabile.</p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="aura-section-subtitle">Editor Error State</h3>
    <div class="aura-component-col">
        <div class="aura-editor-wrapper">
            <label class="aura-label">Messaggio <span class="aura-required">*</span></label>
            <div class="aura-editor aura-editor-error">
                <div class="aura-editor-toolbar">
                    <button type="button" class="aura-editor-btn" disabled title="Grassetto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"/><path d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"/></svg>
                    </button>
                    <button type="button" class="aura-editor-btn" disabled title="Corsivo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="4" x2="10" y2="4"/><line x1="14" y1="20" x2="5" y2="20"/><line x1="15" y1="4" x2="9" y2="20"/></svg>
                    </button>
                </div>
                <div class="aura-editor-content" contenteditable="false" style="min-height: 80px;" data-placeholder="Scrivi un messaggio..."></div>
            </div>
            <span class="aura-input-error-text">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                Il campo messaggio e' obbligatorio.
            </span>
        </div>
    </div>
</section>
