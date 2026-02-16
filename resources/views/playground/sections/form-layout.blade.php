<section id="form-layout" class="playground-section space-y-6">
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700">Form Layout</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Form with Sections</h3>
        <div class="flex flex-col gap-3">
            <x-aura::form>
                <x-aura::form.section title="Informazioni personali" description="Compila i dati anagrafici dell'utente." :columns="2">
                    <x-aura::input label="Nome" placeholder="Mario" />
                    <x-aura::input label="Cognome" placeholder="Rossi" />
                    <x-aura::input label="Email" type="email" placeholder="mario@esempio.it" />
                    <x-aura::input label="Telefono" type="tel" placeholder="+39 02 1234567" />
                </x-aura::form.section>

                <x-aura::form.section title="Indirizzo" description="Indirizzo di residenza o fatturazione.">
                    <x-aura::input label="Via" placeholder="Via Roma 1" />
                </x-aura::form.section>

                <x-aura::form.section :columns="3">
                    <x-aura::input label="Citta'" placeholder="Venezia" />
                    <x-aura::input label="Provincia" placeholder="VE" />
                    <x-aura::input label="CAP" placeholder="30100" />
                </x-aura::form.section>

                <x-aura::form.actions>
                    <x-aura::button variant="ghost">Annulla</x-aura::button>
                    <x-aura::button variant="primary">Salva</x-aura::button>
                </x-aura::form.actions>
            </x-aura::form>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Form.Section Aside Layout</h3>
        <div class="flex flex-col gap-3">
            <x-aura::form>
                <x-aura::form.section title="Profilo" description="Queste informazioni saranno visibili pubblicamente." :aside="true">
                    <x-aura::input label="Username" placeholder="mario_rossi" />
                    <x-aura::textarea label="Bio" :rows="3" placeholder="Scrivi qualcosa su di te..." />
                </x-aura::form.section>

                <x-aura::form.section title="Notifiche" description="Configura come ricevere le notifiche." :aside="true">
                    <x-aura::toggle label="Notifiche email" checked />
                    <x-aura::toggle label="Notifiche push" />
                    <x-aura::toggle label="Newsletter settimanale" />
                </x-aura::form.section>

                <x-aura::form.actions>
                    <x-aura::button variant="ghost">Annulla</x-aura::button>
                    <x-aura::button variant="primary">Salva preferenze</x-aura::button>
                </x-aura::form.actions>
            </x-aura::form>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Form.Actions Alignment</h3>
        <div class="flex flex-col gap-4">
            <div>
                <p class="text-xs text-aura-surface-400 leading-snug mb-2">align="end" (default)</p>
                <x-aura::form.actions align="end">
                    <x-aura::button variant="ghost">Annulla</x-aura::button>
                    <x-aura::button variant="primary">Salva</x-aura::button>
                </x-aura::form.actions>
            </div>
            <div>
                <p class="text-xs text-aura-surface-400 leading-snug mb-2">align="start"</p>
                <x-aura::form.actions align="start">
                    <x-aura::button variant="ghost">Annulla</x-aura::button>
                    <x-aura::button variant="primary">Salva</x-aura::button>
                </x-aura::form.actions>
            </div>
            <div>
                <p class="text-xs text-aura-surface-400 leading-snug mb-2">align="center"</p>
                <x-aura::form.actions align="center">
                    <x-aura::button variant="ghost">Annulla</x-aura::button>
                    <x-aura::button variant="primary">Salva</x-aura::button>
                </x-aura::form.actions>
            </div>
            <div>
                <p class="text-xs text-aura-surface-400 leading-snug mb-2">align="between"</p>
                <x-aura::form.actions align="between">
                    <x-aura::button variant="danger">Elimina account</x-aura::button>
                    <div class="flex gap-2">
                        <x-aura::button variant="ghost">Annulla</x-aura::button>
                        <x-aura::button variant="primary">Salva</x-aura::button>
                    </div>
                </x-aura::form.actions>
            </div>
        </div>
    </div>

    {{-- Editor Section --}}
    <h2 class="text-xl font-bold text-aura-surface-900 dark:text-aura-surface-100 pb-3 border-b border-aura-surface-200 dark:border-aura-surface-700 mt-8">Editor</h2>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Basic Editor</h3>
        <div class="flex flex-col gap-3">
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
                <label class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">Descrizione</label>
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
                <span class="text-xs text-aura-surface-400 leading-snug">Usa la toolbar per formattare il testo.</span>
            </div>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Editor with Content</h3>
        <div class="flex flex-col gap-3">
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
                <label class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">Note (con contenuto)</label>
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
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Editor Disabled</h3>
        <div class="flex flex-col gap-3">
            <div class="aura-editor-wrapper">
                <label class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">Contenuto (sola lettura)</label>
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
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-aura-surface-400">Editor Error State</h3>
        <div class="flex flex-col gap-3">
            <div class="aura-editor-wrapper">
                <label class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">Messaggio <span class="text-aura-danger-500">*</span></label>
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
                <span class="text-xs text-aura-danger-500 font-medium flex items-center gap-1">
                    <x-aura::icon name="x-circle" size="xs" />
                    Il campo messaggio e' obbligatorio.
                </span>
            </div>
        </div>
    </div>
</section>
