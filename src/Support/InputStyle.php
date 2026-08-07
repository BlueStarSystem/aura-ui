<?php

declare(strict_types=1);

namespace BlueStarSystem\AuraUI\Support;

/**
 * The look of a text field, in one place.
 *
 * `.aura-input` carries no CSS: it is a hook for applications to target, and
 * every visible property of a field — its border, its background, its padding —
 * came from utility classes written inside the input component. Five other
 * components borrowed the class name expecting it to style them and rendered
 * borderless, transparent boxes 24 pixels tall: a date picker that looked like
 * a line of text rather than a control you could type into.
 *
 * Anything that draws a field asks here, so a change lands everywhere at once.
 */
final class InputStyle
{
    private const BASE = 'w-full font-[inherit] leading-normal text-aura-surface-900 bg-aura-surface-100 '
        .'border border-aura-surface-500 rounded-aura-md outline-none aura-transition box-border '
        .'placeholder:text-aura-surface-400 '
        .'hover:border-aura-surface-600 hover:bg-aura-surface-50 '
        .'focus:border-aura-primary-500 focus:bg-aura-surface-0 focus:shadow-[var(--aura-glow-primary)] '
        .'disabled:opacity-60 disabled:cursor-not-allowed';

    /**
     * Written out rather than interpolated: Tailwind reads source files as
     * text, so a class built from a variable produces no rule at all.
     */
    private const SIZES = [
        'sm' => 'aura-input-sm py-1.5 px-2.5 text-[13px]',
        'lg' => 'aura-input-lg py-3.5 px-[18px] text-[15px]',
        'md' => 'aura-input-md py-2.5 px-3.5 text-sm',
    ];

    public static function classes(string $size = 'md', bool $error = false, bool $disabled = false): string
    {
        $classes = ['aura-input', self::SIZES[$size] ?? self::SIZES['md'], self::BASE];

        // Hooks only. The red border comes from `.aura-has-error .aura-input`
        // in the stylesheet; repeating the colour here would give the same
        // state two sources of truth that could drift apart.
        if ($error) {
            $classes[] = 'aura-input-error';
        }

        if ($disabled) {
            $classes[] = 'aura-input-disabled';
        }

        return implode(' ', $classes);
    }
}
