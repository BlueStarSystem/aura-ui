<?php

// ========================================
// Form component tests
// ========================================

it('renders form with aura-form class', function () {
    $view = $this->blade('<x-aura::form>Content</x-aura::form>');

    $view->assertSee('aura-form', false);
    $view->assertSee('Content');
});

it('renders form tag', function () {
    $view = $this->blade('<x-aura::form>Content</x-aura::form>');

    $view->assertSee('<form', false);
    $view->assertSee('</form>', false);
});

it('renders form with custom attributes', function () {
    $view = $this->blade('<x-aura::form id="my-form" method="POST">Content</x-aura::form>');

    $view->assertSee('id="my-form"', false);
});

it('renders form with slot content', function () {
    $view = $this->blade('<x-aura::form>
        <input type="text" name="name" />
    </x-aura::form>');

    $view->assertSee('name="name"', false);
});

// ========================================
// Form Section component tests
// ========================================

it('renders section with aura-form-section class', function () {
    $view = $this->blade('<x-aura::form.section>Content</x-aura::form.section>');

    $view->assertSee('aura-form-section', false);
    $view->assertSee('Content');
});

it('renders section with title', function () {
    $view = $this->blade('<x-aura::form.section title="Dati personali">Content</x-aura::form.section>');

    $view->assertSee('Dati personali');
    $view->assertSee('aura-form-section-title', false);
    $view->assertSee('aura-form-section-header', false);
});

it('renders section with description', function () {
    $view = $this->blade('<x-aura::form.section title="Info" description="Inserisci i tuoi dati">Content</x-aura::form.section>');

    $view->assertSee('Inserisci i tuoi dati');
    $view->assertSee('aura-form-section-description', false);
});

it('does not render header when no title or description', function () {
    $view = $this->blade('<x-aura::form.section>Content</x-aura::form.section>');

    $view->assertDontSee('aura-form-section-header', false);
});

it('renders section with default single column grid', function () {
    $view = $this->blade('<x-aura::form.section>Content</x-aura::form.section>');

    $view->assertSee('aura-form-grid-1', false);
});

it('renders section with 2 columns grid', function () {
    $view = $this->blade('<x-aura::form.section :columns="2">Content</x-aura::form.section>');

    $view->assertSee('aura-form-grid-2', false);
});

it('renders section with 3 columns grid', function () {
    $view = $this->blade('<x-aura::form.section :columns="3">Content</x-aura::form.section>');

    $view->assertSee('aura-form-grid-3', false);
});

it('renders section with aside layout', function () {
    $view = $this->blade('<x-aura::form.section :aside="true">Content</x-aura::form.section>');

    $view->assertSee('aura-form-section-aside', false);
});

it('does not render aside class by default', function () {
    $view = $this->blade('<x-aura::form.section>Content</x-aura::form.section>');

    $view->assertDontSee('aura-form-section-aside', false);
});

it('renders section content area', function () {
    $view = $this->blade('<x-aura::form.section>
        <div>Inner content</div>
    </x-aura::form.section>');

    $view->assertSee('aura-form-section-content', false);
    $view->assertSee('Inner content');
});

// ========================================
// Form Actions component tests
// ========================================

it('renders actions with aura-form-actions class', function () {
    $view = $this->blade('<x-aura::form.actions>Buttons</x-aura::form.actions>');

    $view->assertSee('aura-form-actions', false);
    $view->assertSee('Buttons');
});

it('renders actions with default end alignment', function () {
    $view = $this->blade('<x-aura::form.actions>Buttons</x-aura::form.actions>');

    $view->assertSee('aura-form-actions-end', false);
});

it('renders actions with start alignment', function () {
    $view = $this->blade('<x-aura::form.actions align="start">Buttons</x-aura::form.actions>');

    $view->assertSee('aura-form-actions-start', false);
});

it('renders actions with center alignment', function () {
    $view = $this->blade('<x-aura::form.actions align="center">Buttons</x-aura::form.actions>');

    $view->assertSee('aura-form-actions-center', false);
});

it('renders actions with between alignment', function () {
    $view = $this->blade('<x-aura::form.actions align="between">Buttons</x-aura::form.actions>');

    $view->assertSee('aura-form-actions-between', false);
});

it('renders actions with slot content', function () {
    $view = $this->blade('<x-aura::form.actions>
        <button type="submit">Salva</button>
        <button type="button">Annulla</button>
    </x-aura::form.actions>');

    $view->assertSee('Salva');
    $view->assertSee('Annulla');
});
