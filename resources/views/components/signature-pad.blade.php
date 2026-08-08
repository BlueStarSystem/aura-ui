@props([
    'label' => null,
    'name' => 'signature',
    'height' => 160,
    'hint' => null,
    'error' => null,
    'disabled' => false,
    'typedFallback' => true,
])

@php
    use BlueStarSystem\AuraUI\Support\Html;
    use BlueStarSystem\AuraUI\Support\InputStyle;

    /**
     * A signature, with a way to sign that does not need a hand on a mouse.
     *
     * Drawing on a canvas is a pointer gesture, and there is no keyboard
     * equivalent to a curve — which makes a bare signature pad a WCAG 2.1.1
     * failure and, in practice, a form some people simply cannot submit. So
     * typing your name is offered beside it, as a first-class alternative
     * rather than a fallback hidden behind a link, and the field says which of
     * the two produced the value that will be sent.
     *
     * The pointer handlers use Pointer Events, so a stylus and a finger work
     * the same as a mouse, and `touch-action: none` stops the page scrolling
     * out from under a signature on a phone.
     */
    $signatureId = Html::fieldId($attributes->get('id'), $name, $label, Html::wireModelFrom($attributes->getAttributes()));
    $descriptionId = $signatureId.'-description';
    $statusId = $signatureId.'-status';
@endphp

<div
    {{ $attributes->except(['id'])->class(['aura-signature-pad flex w-full max-w-[420px] flex-col gap-1.5']) }}
    x-data="{
        drawn: false,
        typed: '',
        drawing: false,
        context: null,

        init() {
            const canvas = this.$refs.canvas;
            // The canvas is sized in CSS pixels but drawn in device pixels, or
            // the line is a blurry two-pixel smear on any modern screen.
            const ratio = window.devicePixelRatio || 1;
            canvas.width = canvas.clientWidth * ratio;
            canvas.height = canvas.clientHeight * ratio;

            this.context = canvas.getContext('2d');
            this.context.scale(ratio, ratio);
            this.context.lineWidth = 2;
            this.context.lineCap = 'round';
            this.context.lineJoin = 'round';
            this.context.strokeStyle = getComputedStyle(canvas).color;
        },

        start(event) {
            if ({{ $disabled ? 'true' : 'false' }}) return;

            this.drawing = true;
            this.context.beginPath();
            this.context.moveTo(...this.at(event));
            this.$refs.canvas.setPointerCapture(event.pointerId);
        },

        move(event) {
            if (! this.drawing) return;

            this.context.lineTo(...this.at(event));
            this.context.stroke();
            this.drawn = true;
        },

        stop() { this.drawing = false; },

        at(event) {
            const box = this.$refs.canvas.getBoundingClientRect();

            return [event.clientX - box.left, event.clientY - box.top];
        },

        clear() {
            const canvas = this.$refs.canvas;
            this.context.clearRect(0, 0, canvas.width, canvas.height);
            this.drawn = false;
            this.typed = '';
        },

        /** The drawing wins when there is one; otherwise the typed name is it. */
        get value() {
            if (this.drawn) return this.$refs.canvas.toDataURL('image/png');

            return this.typed.trim() === '' ? '' : 'typed:' + this.typed.trim();
        }
    }"
>
    @if($label)
        <span class="aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight">{{ $label }}</span>
    @endif

    <canvas
        x-ref="canvas"
        class="aura-signature-canvas w-full cursor-crosshair rounded-aura-md border border-dashed border-aura-surface-400 bg-aura-surface-0 text-aura-surface-900"
        style="height: {{ (int) $height }}px; touch-action: none;"
        x-on:pointerdown="start($event)"
        x-on:pointermove="move($event)"
        x-on:pointerup="stop()"
        x-on:pointerleave="stop()"
        {{-- Announced for what it is, with the typed field beside it as the way
             in for anyone who cannot draw with a pointer. --}}
        role="img"
        aria-label="{{ __('aura-ui::messages.signature.draw') }}"
    ></canvas>

    <div class="aura-signature-actions flex items-center justify-between gap-3">
        <p id="{{ $statusId }}" class="aura-signature-status text-xs text-aura-surface-600" role="status">
            <span x-show="! drawn && typed.trim() === ''">{{ __('aura-ui::messages.signature.empty') }}</span>
            <span x-show="drawn" x-cloak>{{ __('aura-ui::messages.signature.drawn') }}</span>
            <span x-show="! drawn && typed.trim() !== ''" x-cloak x-text="typed"></span>
        </p>

        <button
            type="button"
            class="aura-signature-clear inline-flex h-8 items-center rounded-aura-md px-3 text-xs font-medium text-aura-surface-700 cursor-pointer hover:bg-aura-surface-100"
            x-on:click="clear()"
            @if($disabled) disabled @endif
        >{{ __('aura-ui::messages.signature.clear') }}</button>
    </div>

    @if($typedFallback)
        <label for="{{ $signatureId }}" class="aura-signature-typed-label text-xs text-aura-surface-600">{{ __('aura-ui::messages.signature.type') }}</label>
        <input
            id="{{ $signatureId }}"
            type="text"
            class="{{ InputStyle::classes('sm', (bool) $error, (bool) $disabled) }}"
            autocomplete="name"
            x-model="typed"
            x-bind:disabled="drawn"
            @if($disabled) disabled @endif
            @if($error) aria-invalid="true" aria-describedby="{{ $descriptionId }}" @endif
        />
    @endif

    <input type="hidden" name="{{ $name }}" x-bind:value="value" />

    @if($error)
        <p id="{{ $descriptionId }}" role="alert" class="aura-signature-error text-xs font-medium text-aura-danger-700 dark:text-aura-danger-500">{{ $error }}</p>
    @elseif($hint)
        <p class="aura-signature-hint text-xs text-aura-surface-600">{{ $hint }}</p>
    @endif
</div>
