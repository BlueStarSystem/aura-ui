@props([
    'label' => null,
    'placeholder' => 'Aggiungi tag...',
    'suggestions' => [],
    'max' => null,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'size' => 'md',
])

@php
    $inputClasses = ['aura-tags-input-field', "aura-input-{$size}"];
    if ($error) $inputClasses[] = 'aura-input-error';
@endphp

<div
    {{ $attributes->class(['aura-tags-wrapper']) }}
    x-data="{
        tags: @entangle($attributes->wire('model')),
        input: '',
        suggestions: {{ json_encode(array_values($suggestions)) }},
        showSuggestions: false,
        max: {{ $max ?? 'null' }},
        highlightIndex: -1,

        init() {
            if (!Array.isArray(this.tags)) this.tags = [];
        },

        get filteredSuggestions() {
            if (!this.input) return [];
            let q = this.input.toLowerCase();
            return this.suggestions.filter(s =>
                s.toLowerCase().includes(q) && !this.tags.includes(s)
            );
        },

        get canAdd() {
            return this.max === null || this.tags.length < this.max;
        },

        addTag(tag) {
            tag = tag.trim();
            if (!tag || !this.canAdd) return;
            if (this.tags.includes(tag)) return;
            this.tags.push(tag);
            this.input = '';
            this.showSuggestions = false;
            this.highlightIndex = -1;
        },

        removeTag(idx) {
            this.tags.splice(idx, 1);
        },

        removeLast() {
            if (this.input === '' && this.tags.length > 0) {
                this.tags.pop();
            }
        },

        onKeydown(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (this.highlightIndex >= 0 && this.filteredSuggestions[this.highlightIndex]) {
                    this.addTag(this.filteredSuggestions[this.highlightIndex]);
                } else if (this.input) {
                    this.addTag(this.input);
                }
            } else if (e.key === 'Backspace') {
                this.removeLast();
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                this.highlightIndex = Math.min(this.highlightIndex + 1, this.filteredSuggestions.length - 1);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                this.highlightIndex = Math.max(this.highlightIndex - 1, 0);
            } else if (e.key === 'Escape') {
                this.showSuggestions = false;
            }
        },

        onInput() {
            this.showSuggestions = this.input.length > 0 && this.filteredSuggestions.length > 0;
            this.highlightIndex = -1;
        }
    }"
    x-on:click.outside="showSuggestions = false"
>
    @if($label)
        <label class="aura-label">{{ $label }}</label>
    @endif

    <div class="aura-tags-container" x-bind:class="{ 'aura-tags-disabled': {{ $disabled ? 'true' : 'false' }} }">
        {{-- Tags --}}
        <template x-for="(tag, idx) in tags" :key="idx">
            <span class="aura-tag">
                <span x-text="tag"></span>
                <button
                    type="button"
                    class="aura-tag-remove"
                    x-on:click="removeTag(idx)"
                    @if($disabled) disabled @endif
                    aria-label="Rimuovi"
                >
                    <x-aura::icon name="x" size="xs" />
                </button>
            </span>
        </template>

        {{-- Input --}}
        <input
            type="text"
            class="{{ implode(' ', $inputClasses) }}"
            x-model="input"
            x-on:input="onInput()"
            x-on:keydown="onKeydown($event)"
            x-on:focus="if (input) showSuggestions = true"
            placeholder="{{ $placeholder }}"
            @if($disabled) disabled @endif
            x-bind:placeholder="tags.length > 0 ? '' : '{{ $placeholder }}'"
            autocomplete="off"
        />
    </div>

    {{-- Suggestions --}}
    <div
        class="aura-tags-suggestions aura-glass"
        x-show="showSuggestions"
        x-transition
        x-cloak
    >
        <template x-for="(sug, idx) in filteredSuggestions" :key="sug">
            <button
                type="button"
                class="aura-tags-suggestion"
                x-text="sug"
                x-bind:class="{ 'aura-tags-suggestion-highlighted': highlightIndex === idx }"
                x-on:click="addTag(sug)"
            ></button>
        </template>
    </div>

    @if($max)
        <p class="aura-tags-count" x-show="tags.length > 0">
            <span x-text="tags.length"></span>/<span>{{ $max }}</span>
        </p>
    @endif

    @if($error)
        <p class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
