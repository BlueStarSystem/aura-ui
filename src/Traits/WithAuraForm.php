<?php

namespace BlueStarSystem\AuraUI\Traits;

trait WithAuraForm
{
    public bool $formDirty = false;
    public array $formErrors = [];
    public ?string $formSuccessMessage = null;

    /**
     * Track original form values for dirty detection.
     */
    protected array $originalFormValues = [];

    /**
     * Properties to track for dirty detection.
     * Override in component to specify which properties to track.
     */
    public function formFields(): array
    {
        return [];
    }

    /**
     * Mount form state — captures initial values.
     */
    public function mountWithAuraForm(): void
    {
        $this->captureOriginalValues();
    }

    /**
     * Capture current form values as original (clean) state.
     */
    public function captureOriginalValues(): void
    {
        $this->originalFormValues = [];

        foreach ($this->formFields() as $field) {
            $this->originalFormValues[$field] = $this->{$field} ?? null;
        }

        $this->formDirty = false;
    }

    /**
     * Check if form has been modified from its original state.
     */
    public function checkDirty(): bool
    {
        foreach ($this->formFields() as $field) {
            $current = $this->{$field} ?? null;
            $original = $this->originalFormValues[$field] ?? null;

            if ($current !== $original) {
                $this->formDirty = true;

                return true;
            }
        }

        $this->formDirty = false;

        return false;
    }

    /**
     * Reset form to original values.
     */
    public function resetForm(): void
    {
        foreach ($this->formFields() as $field) {
            if (isset($this->originalFormValues[$field])) {
                $this->{$field} = $this->originalFormValues[$field];
            }
        }

        $this->formDirty = false;
        $this->formErrors = [];
        $this->formSuccessMessage = null;
    }

    /**
     * Set a form-level success message (auto-clears after timeout via JS).
     */
    public function formSuccess(string $message): void
    {
        $this->formSuccessMessage = $message;
        $this->formErrors = [];
        $this->captureOriginalValues();
    }

    /**
     * Set form-level errors.
     */
    public function setFormErrors(array $errors): void
    {
        $this->formErrors = $errors;
        $this->formSuccessMessage = null;
    }

    /**
     * Check if the form has any errors.
     */
    public function hasFormErrors(): bool
    {
        return ! empty($this->formErrors);
    }

    /**
     * Get error for a specific field.
     */
    public function getFormError(string $field): ?string
    {
        return $this->formErrors[$field] ?? null;
    }

    /**
     * Clear all form errors and success message.
     */
    public function clearFormMessages(): void
    {
        $this->formErrors = [];
        $this->formSuccessMessage = null;
    }
}
