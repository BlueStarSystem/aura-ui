<?php

use BlueStarSystem\AuraUI\Traits\WithAuraForm;

// Create a test class that uses the trait
class FormTestComponent
{
    use WithAuraForm;

    public string $name = '';
    public string $email = '';

    public function formFields(): array
    {
        return ['name', 'email'];
    }
}

it('has default state values', function () {
    $component = new FormTestComponent();

    expect($component->formDirty)->toBeFalse();
    expect($component->formErrors)->toBe([]);
    expect($component->formSuccessMessage)->toBeNull();
});

it('captures original values', function () {
    $component = new FormTestComponent();
    $component->name = 'Mario';
    $component->email = 'mario@test.com';
    $component->captureOriginalValues();

    expect($component->formDirty)->toBeFalse();
});

it('detects dirty state when field changes', function () {
    $component = new FormTestComponent();
    $component->name = 'Mario';
    $component->email = 'mario@test.com';
    $component->captureOriginalValues();

    $component->name = 'Luigi';
    $result = $component->checkDirty();

    expect($result)->toBeTrue();
    expect($component->formDirty)->toBeTrue();
});

it('detects clean state when fields unchanged', function () {
    $component = new FormTestComponent();
    $component->name = 'Mario';
    $component->email = 'mario@test.com';
    $component->captureOriginalValues();

    $result = $component->checkDirty();

    expect($result)->toBeFalse();
    expect($component->formDirty)->toBeFalse();
});

it('resets form to original values', function () {
    $component = new FormTestComponent();
    $component->name = 'Mario';
    $component->email = 'mario@test.com';
    $component->captureOriginalValues();

    $component->name = 'Luigi';
    $component->email = 'luigi@test.com';
    $component->resetForm();

    expect($component->name)->toBe('Mario');
    expect($component->email)->toBe('mario@test.com');
    expect($component->formDirty)->toBeFalse();
    expect($component->formErrors)->toBe([]);
    expect($component->formSuccessMessage)->toBeNull();
});

it('sets success message and clears errors', function () {
    $component = new FormTestComponent();
    $component->name = 'Mario';
    $component->captureOriginalValues();

    $component->setFormErrors(['name' => 'Required']);
    $component->formSuccess('Salvato con successo');

    expect($component->formSuccessMessage)->toBe('Salvato con successo');
    expect($component->formErrors)->toBe([]);
});

it('recaptures original values on success', function () {
    $component = new FormTestComponent();
    $component->name = 'Mario';
    $component->captureOriginalValues();

    $component->name = 'Luigi';
    $component->formSuccess('Salvato');

    // After success, Luigi becomes the new "original" value
    $result = $component->checkDirty();
    expect($result)->toBeFalse();
    expect($component->formDirty)->toBeFalse();
});

it('sets form errors and clears success message', function () {
    $component = new FormTestComponent();
    $component->formSuccessMessage = 'Saved';

    $component->setFormErrors(['name' => 'Il nome e obbligatorio', 'email' => 'Email non valida']);

    expect($component->formErrors)->toBe([
        'name' => 'Il nome e obbligatorio',
        'email' => 'Email non valida',
    ]);
    expect($component->formSuccessMessage)->toBeNull();
});

it('checks if form has errors', function () {
    $component = new FormTestComponent();

    expect($component->hasFormErrors())->toBeFalse();

    $component->setFormErrors(['name' => 'Required']);

    expect($component->hasFormErrors())->toBeTrue();
});

it('gets error for specific field', function () {
    $component = new FormTestComponent();
    $component->setFormErrors(['name' => 'Il nome e obbligatorio']);

    expect($component->getFormError('name'))->toBe('Il nome e obbligatorio');
    expect($component->getFormError('email'))->toBeNull();
});

it('clears all form messages', function () {
    $component = new FormTestComponent();
    $component->formSuccessMessage = 'Saved';
    $component->setFormErrors(['name' => 'Error']);

    $component->clearFormMessages();

    expect($component->formErrors)->toBe([]);
    expect($component->formSuccessMessage)->toBeNull();
});

it('resets form clears errors and success message', function () {
    $component = new FormTestComponent();
    $component->name = 'Mario';
    $component->captureOriginalValues();

    $component->setFormErrors(['name' => 'Error']);
    $component->formSuccessMessage = 'Saved';

    $component->resetForm();

    expect($component->formErrors)->toBe([]);
    expect($component->formSuccessMessage)->toBeNull();
});

it('returns empty array from formFields by default', function () {
    // Test the base trait behavior with a minimal class
    $component = new class {
        use WithAuraForm;
    };

    expect($component->formFields())->toBe([]);
});

it('mounts and captures initial values', function () {
    $component = new FormTestComponent();
    $component->name = 'Initial';
    $component->email = 'init@test.com';

    $component->mountWithAuraForm();

    // After mount, changing values should be detected as dirty
    $component->name = 'Changed';

    expect($component->checkDirty())->toBeTrue();
});

it('mount resets dirty flag', function () {
    $component = new FormTestComponent();
    $component->formDirty = true;

    $component->mountWithAuraForm();

    expect($component->formDirty)->toBeFalse();
});
