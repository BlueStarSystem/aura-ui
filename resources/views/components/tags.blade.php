@props([
    'label' => null,
    'placeholder' => 'Add tag...',
    'max' => null,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'size' => 'md',
])

@php
    use BlueStarSystem\AuraUI\Support\Html;

    // A label with no `for` and an input with no id: clicking the label
    // does nothing and the error text below is attached to nothing.
    $tagsFieldId = Html::fieldId($attributes->get('id'), null, $label, Html::wireModelFrom($attributes->getAttributes()));
    $tagsFieldIdError = $tagsFieldId.'-error';
@endphp

<div
    {{ $attributes->class(['aura-tags-wrapper relative flex flex-col gap-1.5']) }}
    x-data="{
        tags: @if($attributes->wire('model')->value()) $wire.entangle({{ Js::from($attributes->wire('model')->value()) }}){{ $attributes->wire('model')->hasModifier('live') ? '.live' : '' }} @else [] @endif,
        input: '',
        max: {{ is_null($max) ? 'null' : (int) $max }},
        init() { if (!Array.isArray(this.tags)) this.tags = []; },
        get canAdd() { return this.max === null || this.tags.length < this.max; },
        addTag() {
            const v = this.input.trim();
            if (!v || !this.canAdd || this.tags.includes(v)) { this.input = ''; return; }
            this.tags.push(v);
            this.input = '';
        },
        removeTag(idx) { this.tags.splice(idx, 1); },
        removeLast() { if (this.input === '' && this.tags.length > 0) this.tags.pop(); },
        onKeydown(e) {
            if (e.key === 'Enter') { e.preventDefault(); this.addTag(); }
            else if (e.key === 'Backspace') { this.removeLast(); }
        }
    }"
>
    @if($label)
        <label for="{{ $tagsFieldId }}" class="aura-label">{{ $label }}</label>
    @endif

    {{-- Clicking the padding around the field now lands in the field, which is
         what a 42px box that holds a 24px input has to do to be that box. --}}
    <div class="aura-tags-container flex items-center flex-wrap gap-1.5 min-h-[42px] px-3 py-1.5 border border-aura-surface-500 rounded-aura-md bg-aura-surface-0 aura-transition-fast focus-within:border-aura-primary-500 focus-within:shadow-[var(--aura-glow-primary)]" x-bind:class="{ 'opacity-50 pointer-events-none': {{ $disabled ? 'true' : 'false' }} }" x-on:click="$refs.field?.focus()">
        <template x-for="(tag, idx) in tags" :key="idx">
            <span class="aura-tag inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-aura-primary-50 text-aura-primary-700 rounded-aura-full">
                <span x-text="tag"></span>
                <button type="button" class="aura-tag-remove inline-flex items-center justify-center min-w-6 min-h-6 p-0.5 bg-transparent border-none text-aura-primary-400 cursor-pointer rounded-full aura-transition-fast hover:text-aura-primary-700 hover:bg-aura-primary-100" x-on:click="removeTag(idx)" @if($disabled) disabled @endif aria-label="{{ __('aura-ui::messages.remove') }}">
                    <x-aura::icon name="x" size="xs" />
                </button>
            </span>
        </template>

        <input
            type="text"
            x-ref="field" id="{{ $tagsFieldId }}" @if($error) aria-invalid="true" aria-describedby="{{ $tagsFieldIdError }}" @endif 
            class="aura-tags-field aura-input-{{ $size }} flex-1 min-h-6 min-w-[80px] border-none bg-transparent outline-none text-sm text-aura-surface-900 p-0 shadow-none"
            x-model="input"
            x-on:keydown="onKeydown($event)"
            @if($disabled) disabled @endif
            x-bind:placeholder="tags.length > 0 ? '' : {{ Js::from($placeholder) }}"
            autocomplete="off"
        />
    </div>

    @if(! is_null($max))
        <p class="aura-tags-count text-xs text-aura-surface-400" x-show="tags.length > 0"><span x-text="tags.length"></span>/<span>{{ $max }}</span></p>
    @endif

    @if($error)
        <p role="alert" id="{{ $tagsFieldIdError }}" class="aura-input-error-text">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-input-hint">{{ $hint }}</p>
    @endif
</div>
