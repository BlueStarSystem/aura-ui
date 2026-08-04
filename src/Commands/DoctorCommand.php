<?php

namespace BlueStarSystem\AuraUI\Commands;

use BlueStarSystem\AuraUI\Support\Contrast;
use BlueStarSystem\AuraUI\Support\ThemeColors;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use InvalidArgumentException;
use Throwable;

/**
 * Static checks for an application that consumes Aura UI.
 *
 * Catches the failure modes that are silent at runtime: components that render
 * unstyled because Tailwind never scanned Aura's Blade, component names that do
 * not exist (typos, or Pro components used without Pro installed), variants
 * that fall through to no styling, and icon-only buttons that a screen reader
 * announces as nothing.
 *
 * Exits non-zero when something is found, so it can gate CI.
 */
class DoctorCommand extends Command
{
    protected $signature = 'aura:doctor
        {--path=* : Directories to scan (defaults to resources/views)}
        {--json : Output findings as JSON}
        {--a11y : Also run the accessibility checks}
        {--skip-setup : Only run the Blade checks}';

    protected $description = 'Check an app for Aura UI setup and component usage problems';

    /**
     * Variants each component actually styles. Anything else silently renders
     * with no variant classes at all.
     *
     * @var array<string, list<string>>
     */
    private const VARIANTS = [
        'button' => ['primary', 'secondary', 'success', 'warning', 'danger', 'ghost', 'outline'],
        'badge' => ['primary', 'secondary', 'success', 'warning', 'danger', 'info', 'outline'],
        'alert' => ['success', 'warning', 'danger', 'info'],
    ];

    /**
     * Shades that components render as a solid background under white (or, for
     * warning, dark) text. A customer who overrides these owns the contrast
     * problem, and today nothing tells them. Verified 2026-08-04 against the
     * current Blade (button.blade.php's $variantClasses match()): 'primary' is
     * bg-aura-primary-600, 'success' is bg-aura-success-700, 'danger' is
     * bg-aura-danger-600, all text-white; 'warning' is bg-aura-warning-500
     * text-aura-surface-900 (#0f172a). These shades changed since Aura's
     * earlier releases -- do not assume this list without re-checking the Blade.
     *
     * @var array<string, string> shade => text colour rendered on top
     */
    private const SOLID_ON_TEXT = [
        'primary-600' => '#ffffff',
        'success-700' => '#ffffff',
        'danger-600' => '#ffffff',
        'warning-500' => '#0f172a',
    ];

    /**
     * Contrast conversion for oklch() colours round-trips through 8-bit-per-
     * channel hex, which carries roughly ±0.2% of error. A ratio computed this
     * close to the WCAG AA line could be wrong on either side of it, so a
     * result inside this margin is reported as inconclusive rather than as a
     * definite pass or fail.
     */
    private const BORDERLINE_MARGIN = 0.05;

    /** @var list<array{level: string, check: string, message: string, file: string|null, line: int|null}> */
    private array $findings = [];

    public function handle(): int
    {
        if (! $this->option('skip-setup')) {
            $this->checkCssSetup();
        }

        if ($this->option('a11y')) {
            $this->checkThemeContrast();
        }

        $this->checkBladeUsage();

        return $this->report();
    }

    /**
     * Tailwind 4 only generates classes it has seen. Without an @source pointing
     * at Aura's views, every component renders unstyled -- and nothing errors.
     */
    private function checkCssSetup(): void
    {
        $css = resource_path('css/app.css');

        if (! File::exists($css)) {
            $this->add('warning', 'css', 'resources/css/app.css not found — skipping CSS checks.');

            return;
        }

        $contents = File::get($css);

        if (! str_contains($contents, 'vendor/aura-ui/aura.css')) {
            $this->add('error', 'css', 'app.css does not import the Aura stylesheet. Add: @import "./vendor/aura-ui/aura.css";', 'resources/css/app.css');
        }

        $scansVendor = str_contains($contents, 'bluestarsystem/aura-ui/resources/views');
        $scansPublished = preg_match('/@source[^;]*components\/aura/', $contents) === 1;

        if (! $scansVendor && ! $scansPublished) {
            $this->add(
                'error',
                'tailwind',
                'No @source directive covers Aura views, so Tailwind will not generate their classes and components will render unstyled. Add: @source "../../vendor/bluestarsystem/aura-ui/resources/views/**/*.blade.php";',
                'resources/css/app.css'
            );
        }
    }

    /**
     * The piece no competing library checks: not Aura's own palette, but the
     * one the customer overrode. A colour that fails AA under the text
     * components render on top of it is invisible-in-practice, and nothing
     * else would catch it before a real user does.
     *
     * Never blocks CI on something it could not read: a missing app.css is
     * checkCssSetup's problem, an empty/absent @theme block is not an error
     * (Aura's own defaults already pass AA), and a colour Contrast cannot
     * parse is skipped with a warning rather than crashing the scan.
     *
     * Only covers the colours as written in the top-level @theme block. This
     * app's dark mode is not a `dark:` utility system -- dark-mode.css
     * redefines --color-aura-* again inside a `.dark` selector, inverting the
     * surface scale and re-pointing only the -500 accents. A customer's
     * override here applies in *both* themes unless they also wrote their own
     * `.dark` block, and this check has no visibility into that second block
     * at all. It is a light-mode (and shared-value) check only.
     */
    private function checkThemeContrast(): void
    {
        $path = resource_path('css/app.css');

        if (! File::exists($path)) {
            return;   // checkCssSetup has already warned about this
        }

        try {
            $css = (string) File::get($path);
        } catch (Throwable) {
            // Never let an unreadable file (permissions, a race with something
            // else writing it, ...) crash the whole scan -- the same "never
            // throws" contract ThemeColors::parse() itself honours.
            $this->add('warning', 'a11y-theme', 'Could not read resources/css/app.css — skipping the theme contrast check.', 'resources/css/app.css');

            return;
        }

        // A block that opened but never closed (or similar) was not actually
        // read. Saying "using Aura defaults, which meet WCAG AA" here would be
        // a false assurance about a file whose content is unknown -- worse
        // than saying nothing, so this is reported as its own, distinct warning.
        if (ThemeColors::hasUnreadableThemeBlock($css)) {
            $this->add('warning', 'a11y-theme', 'Found an @theme block in resources/css/app.css that could not be fully read (e.g. an unclosed brace) — its colours were not checked.', 'resources/css/app.css');

            return;
        }

        $colors = ThemeColors::parse($css);

        if ($colors === []) {
            $this->add('warning', 'a11y-theme', 'No Aura colour overrides found in a @theme block — using Aura defaults, which meet WCAG AA.', 'resources/css/app.css');

            return;
        }

        foreach (self::SOLID_ON_TEXT as $shade => $text) {
            if (! isset($colors[$shade])) {
                continue;
            }

            try {
                $ratio = Contrast::ratio($colors[$shade], $text);
            } catch (InvalidArgumentException) {
                $this->add('warning', 'a11y-theme', "Could not read --color-aura-{$shade} (\"{$colors[$shade]}\") — skipping its contrast check.", 'resources/css/app.css');

                continue;
            }

            $this->reportThemeContrast($shade, $text, $ratio);
        }
    }

    private function reportThemeContrast(string $shade, string $text, float $ratio): void
    {
        $borderline = abs($ratio - Contrast::AA_NORMAL) <= self::BORDERLINE_MARGIN;
        $passes = $ratio >= Contrast::AA_NORMAL;

        if ($passes && ! $borderline) {
            return;   // clearly fine, nothing to say
        }

        $rendersAs = "Components render this shade as a solid background under {$text} text, so the label will be ".($passes ? 'hard to read if the true ratio is actually lower than measured' : 'hard to read').'.';

        if ($borderline) {
            $this->add(
                'warning',
                'a11y-theme',
                "--color-aura-{$shade} gives {$ratio}:1 against {$text}, within ".self::BORDERLINE_MARGIN.' of the WCAG AA minimum of '.Contrast::AA_NORMAL.":1 -- borderline, verify manually. Aura's contrast check converts oklch() colours through a lossy round-trip, so a ratio this close to the line is not a reliable pass or fail. {$rendersAs}",
                'resources/css/app.css'
            );

            return;
        }

        $this->add(
            'error',
            'a11y-theme',
            "--color-aura-{$shade} gives {$ratio}:1 against {$text}, below the WCAG AA minimum of ".Contrast::AA_NORMAL.":1. {$rendersAs} Pick a darker shade.",
            'resources/css/app.css'
        );
    }

    private function checkBladeUsage(): void
    {
        /** @var list<string> $paths */
        $paths = $this->option('path') ?: [resource_path('views')];

        foreach ($paths as $path) {
            if (! File::isDirectory($path)) {
                $this->add('warning', 'scan', "Path not found: {$path}");

                continue;
            }

            foreach (File::allFiles($path) as $file) {
                if (! str_ends_with($file->getFilename(), '.blade.php')) {
                    continue;
                }

                $this->inspect($file->getPathname(), (string) File::get($file->getPathname()));
            }
        }
    }

    private function inspect(string $path, string $contents): void
    {
        $relative = str_replace(base_path().DIRECTORY_SEPARATOR, '', $path);

        // Commented-out or WIP markup never renders, so no check should see it.
        // Stripped once here, before any regex runs, so every check -- old and
        // new -- benefits without repeating the work.
        $contents = $this->stripBladeComments($contents);

        preg_match_all('/<x-aura::([a-z0-9.-]+)([^>]*)>/i', $contents, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        foreach ($matches as $match) {
            $name = strtolower($match[1][0]);
            $attributes = $match[2][0];
            $line = substr_count(substr($contents, 0, (int) $match[0][1]), "\n") + 1;
            $root = explode('.', $name)[0];

            // <x-aura::blocks.{{ $name }}> and friends: the tag name is built at
            // runtime, so there is nothing static to resolve.
            if (str_ends_with($name, '.') || str_ends_with($name, '-') || str_contains($attributes, '{{')) {
                continue;
            }

            if (! $this->componentExists($name) && ! $this->componentExists($root)) {
                $this->add('error', 'unknown-component', "<x-aura::{$name}> is not an Aura component. Check the spelling, or install Aura UI Pro if it is a Pro component.", $relative, $line);

                continue;
            }

            $this->checkVariant($root, $attributes, $relative, $line);
        }

        $this->checkIconOnlyButtons($contents, $relative);

        if ($this->option('a11y')) {
            $this->checkAccessibility($contents, $relative);
        }
    }

    /**
     * Blanks out {{-- ... --}} regions, character for character except
     * newlines, so no check ever matches markup that never renders --
     * while every line number computed downstream (by counting "\n" up to
     * a match's offset) stays exactly right.
     */
    private function stripBladeComments(string $contents): string
    {
        return preg_replace_callback(
            '/\{\{--.*?--\}\}/s',
            fn (array $m): string => preg_replace('/[^\n]/', ' ', $m[0]) ?? $m[0],
            $contents
        ) ?? $contents;
    }

    private function checkVariant(string $component, string $attributes, string $file, int $line): void
    {
        if (! isset(self::VARIANTS[$component])) {
            return;
        }

        if (preg_match('/\bvariant\s*=\s*"([a-z-]+)"/i', $attributes, $found) !== 1) {
            return;
        }

        $variant = strtolower($found[1]);

        if (! in_array($variant, self::VARIANTS[$component], true)) {
            $this->add(
                'error',
                'invalid-variant',
                "variant=\"{$variant}\" is not styled by <x-aura::{$component}>. Valid: ".implode(', ', self::VARIANTS[$component]).'.',
                $file,
                $line
            );
        }
    }

    /**
     * A button whose only content is an icon announces nothing to a screen
     * reader unless it carries an accessible name.
     */
    private function checkIconOnlyButtons(string $contents, string $file): void
    {
        preg_match_all('/<x-aura::button([^>]*)>(.*?)<\/x-aura::button>/is', $contents, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        foreach ($matches as $match) {
            $attributes = $match[1][0];
            $inner = $match[2][0];

            $withoutIcons = trim(preg_replace('/<x-aura::icon[^>]*\/?>/i', '', $inner) ?? '');
            $withoutIcons = trim(strip_tags($withoutIcons));

            if ($withoutIcons !== '') {
                continue;
            }

            if (preg_match('/\baria-label\s*=|\btitle\s*=|\bsr-only\b/i', $attributes.$inner) === 1) {
                continue;
            }

            $line = substr_count(substr($contents, 0, (int) $match[0][1]), "\n") + 1;

            $this->add('error', 'a11y', 'Icon-only <x-aura::button> has no accessible name. Add aria-label="…".', $file, $line);
        }
    }

    /** Components whose accessible name comes from a label prop. */
    private const LABELLED = ['input', 'select', 'textarea', 'floating-input', 'checkbox', 'radio', 'toggle', 'multiselect'];

    private const GENERIC_LINK_TEXT = ['clicca qui', 'qui', 'leggi di più', 'click here', 'here', 'read more', 'learn more'];

    private function checkAccessibility(string $contents, string $file): void
    {
        $this->checkFieldLabels($contents, $file);
        $this->checkImageAlt($contents, $file);
        $this->checkTabIndex($contents, $file);
        $this->checkLinkText($contents, $file);
        $this->checkDialogTitles($contents, $file);
        $this->checkHeadingOrder($contents, $file);
    }

    private function checkFieldLabels(string $contents, string $file): void
    {
        $names = implode('|', self::LABELLED);

        // The (?![\w.-]) boundary stops e.g. <x-aura::select.option> being
        // mistaken for a bare, unlabelled <x-aura::select> -- without it every
        // sub-component tag whose name starts with a labelled component's name
        // was misread as that component's opening tag.
        preg_match_all('/<x-aura::('.$names.')(?![\w.-])((?:[^>"\']|"[^"]*"|\'[^\']*\')*)\/?>/i', $contents, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        $wrappingLabels = $this->nativeLabelRanges($contents);

        foreach ($matches as $match) {
            $attributes = $match[2][0];
            $offset = (int) $match[0][1];

            // :label="$x", label="..." and aria-label all give it a name;
            // wire:model alone does not.
            if (preg_match('/(^|\s):?label\s*=|(^|\s)aria-label\s*=|(^|\s)aria-labelledby\s*=/i', $attributes) === 1) {
                continue;
            }

            if ($this->hasMatchingNativeLabel($contents, $attributes)) {
                continue;
            }

            if ($this->isWithinLabelRange($offset, $wrappingLabels)) {
                continue;
            }

            $line = substr_count(substr($contents, 0, $offset), "\n") + 1;

            $this->add('error', 'a11y', "<x-aura::{$match[1][0]}> has no accessible name. Add label=\"…\" or aria-label=\"…\".", $file, $line);
        }
    }

    /**
     * The canonical WCAG pattern is a native <label for="x"> paired with an
     * id="x" on the control -- Blade's :label prop is a convenience, not the
     * only valid way to name a field. Without this, that standard pattern
     * would be flagged as inaccessible, which it is not.
     *
     * A dynamic id (`:id="$x"` or `id="{{ $x }}"`) cannot be resolved
     * statically against a <label for>, so it is treated as satisfied rather
     * than flagged: per the governing rule, an unresolvable case must not
     * become a false positive.
     */
    private function hasMatchingNativeLabel(string $contents, string $attributes): bool
    {
        if (preg_match('/(^|\s):id\s*=/i', $attributes) === 1) {
            return true;
        }

        if (preg_match('/(^|\s)id\s*=\s*"([^"]*)"/i', $attributes, $found) !== 1
            && preg_match('/(^|\s)id\s*=\s*\'([^\']*)\'/i', $attributes, $found) !== 1) {
            return false;
        }

        $id = $found[2];

        if ($id === '' || str_contains($id, '{{')) {
            return true;
        }

        return preg_match('/<label\b[^>]*\bfor\s*=\s*["\']'.preg_quote($id, '/').'["\'][^>]*>/i', $contents) === 1;
    }

    /**
     * The other canonical WCAG pattern: a <label> that wraps the control
     * instead of pointing at it with for/id -- the association comes from
     * containment. <label> elements don't legitimately nest, so opening and
     * closing tags are paired in file order with a stack: the Nth </label>
     * closes the Nth-from-the-end still-open <label>. That correctly leaves
     * an earlier, already-closed <label>...</label> out of every later
     * pair's range, so it cannot wrongly "cover" a component that comes
     * after it -- only a component that is genuinely between a specific
     * pair's open and close tags falls inside that pair's range.
     *
     * An unterminated <label> (no matching </label>) never completes a pair,
     * so nothing inside it is treated as wrapped; that is the conservative
     * side of an already-invalid-markup edge case, not the one this check
     * exists to protect against.
     *
     * @return list<array{0: int, 1: int}> [start, end) byte-offset ranges,
     *                                     one per matched <label>...</label> pair
     */
    private function nativeLabelRanges(string $contents): array
    {
        preg_match_all('/<label\b[^>]*>|<\/label\s*>/i', $contents, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        $openTagEnds = [];
        $ranges = [];

        foreach ($matches as $match) {
            $tag = $match[0][0];
            $offset = (int) $match[0][1];

            if (stripos($tag, '</label') === 0) {
                if ($openTagEnds !== []) {
                    $ranges[] = [array_pop($openTagEnds), $offset];
                }

                continue;
            }

            $openTagEnds[] = $offset + strlen($tag);
        }

        return $ranges;
    }

    /**
     * @param  list<array{0: int, 1: int}>  $ranges
     */
    private function isWithinLabelRange(int $offset, array $ranges): bool
    {
        foreach ($ranges as [$start, $end]) {
            if ($offset >= $start && $offset < $end) {
                return true;
            }
        }

        return false;
    }

    private function checkImageAlt(string $contents, string $file): void
    {
        preg_match_all('/<img\b((?:[^>"\']|"[^"]*"|\'[^\']*\')*)>/i', $contents, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        foreach ($matches as $match) {
            $attributes = $match[1][0];

            if (preg_match('/(^|\s):?alt\s*=/i', $attributes) === 1) {
                continue;
            }

            // role="presentation" / role="none" is the ARIA-recognised way to
            // mark an image decorative -- axe-core accepts either as an
            // alternative to alt="", so this check does too.
            if (preg_match('/(^|\s)role\s*=\s*["\'](presentation|none)["\']/i', $attributes) === 1) {
                continue;
            }

            $line = substr_count(substr($contents, 0, (int) $match[0][1]), "\n") + 1;

            $this->add('error', 'a11y', '<img> has no alt attribute. Use alt="" if the image is decorative.', $file, $line);
        }
    }

    private function checkTabIndex(string $contents, string $file): void
    {
        preg_match_all('/\btabindex\s*=\s*"([0-9]+)"/i', $contents, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        foreach ($matches as $match) {
            if ((int) $match[1][0] <= 0) {
                continue;
            }

            $line = substr_count(substr($contents, 0, (int) $match[0][1]), "\n") + 1;

            $this->add('error', 'a11y', 'Positive tabindex overrides the natural focus order. Use 0 or -1.', $file, $line);
        }
    }

    private function checkLinkText(string $contents, string $file): void
    {
        preg_match_all('/<a\b[^>]*>(.*?)<\/a>/is', $contents, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        foreach ($matches as $match) {
            $text = strtolower(trim(strip_tags($match[1][0])));

            if (! in_array($text, self::GENERIC_LINK_TEXT, true)) {
                continue;
            }

            $line = substr_count(substr($contents, 0, (int) $match[0][1]), "\n") + 1;

            $this->add('warning', 'a11y', "Link text \"{$text}\" makes no sense out of context to someone listing the links on the page.", $file, $line);
        }
    }

    /**
     * <x-aura::modal> and <x-aura::drawer> both take a `title` prop. Without it
     * -- or an explicit aria-label -- the dialog opens and a screen reader
     * announces nothing about what it is.
     *
     * `title` can arrive either as an attribute (`title="…"`) or as a named
     * slot (`<x-slot:title>…</x-slot:title>` / `<x-slot name="title">…`),
     * since Blade binds a named slot to the same variable an attribute would.
     * Missing the slot form would flag every dialog that uses it -- a false
     * positive on a first-class, common pattern.
     */
    private function checkDialogTitles(string $contents, string $file): void
    {
        preg_match_all('/<x-aura::(modal|drawer)(?![\w.-])((?:[^>"\']|"[^"]*"|\'[^\']*\')*)(\/)?>/i', $contents, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        foreach ($matches as $match) {
            $tag = $match[1][0];
            $attributes = $match[2][0];
            $selfClosing = isset($match[3]) && $match[3][0] !== '';
            $offset = (int) $match[0][1];

            if (preg_match('/(^|\s):?title\s*=|(^|\s)aria-label\s*=|(^|\s)aria-labelledby\s*=/i', $attributes) === 1) {
                continue;
            }

            if (! $selfClosing) {
                $tagEnd = $offset + strlen($match[0][0]);
                $closeTagPos = stripos($contents, "</x-aura::{$tag}>", $tagEnd);
                $body = $closeTagPos !== false
                    ? substr($contents, $tagEnd, $closeTagPos - $tagEnd)
                    : substr($contents, $tagEnd);

                if (preg_match('/<x-slot:title\b|<x-slot\s+name\s*=\s*["\']title["\']/i', $body) === 1) {
                    continue;
                }
            }

            $line = substr_count(substr($contents, 0, $offset), "\n") + 1;

            $this->add('error', 'a11y', "<x-aura::{$tag}> has no accessible name. Add title=\"…\" or aria-label=\"…\".", $file, $line);
        }
    }

    /**
     * Skipping a heading level breaks the outline screen-reader users navigate by.
     *
     * A warning, never an error: a Blade file is usually a fragment of a page,
     * so a file that opens at h3 may be perfectly correct once included. Only
     * skips *within the same file* are reported, and only forward ones.
     */
    private function checkHeadingOrder(string $contents, string $file): void
    {
        preg_match_all('/<h([1-6])\b|<x-aura::heading[^>]*\blevel\s*=\s*"([1-6])"/i', $contents, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        $previous = null;

        foreach ($matches as $match) {
            $level = (int) ($match[1][0] !== '' ? $match[1][0] : $match[2][0]);

            if ($previous !== null && $level > $previous + 1) {
                $line = substr_count(substr($contents, 0, (int) $match[0][1]), "\n") + 1;

                $this->add('warning', 'a11y', "Heading jumps from h{$previous} to h{$level}, leaving a gap in the document outline.", $file, $line);
            }

            $previous = $level;
        }
    }

    /** @var list<string>|null */
    private ?array $hints = null;

    /**
     * Whether <x-aura::name> resolves to a real component.
     *
     * Asks the view finder rather than a static list, so Pro components count
     * as known when Pro is installed. Every Aura package shares the
     * <x-aura::*> tag prefix but registers its own view namespace -- free
     * under "aura", Pro under "aura-pro" -- so all aura* hints are checked.
     */
    private function componentExists(string $name): bool
    {
        foreach ($this->componentHints() as $hint) {
            if (View::exists("{$hint}::components.{$name}") || View::exists("{$hint}::{$name}")) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return list<string>
     */
    private function componentHints(): array
    {
        if ($this->hints !== null) {
            return $this->hints;
        }

        $hints = array_keys(View::getFinder()->getHints());

        return $this->hints = array_values(array_filter(
            array_map('strval', $hints),
            fn (string $hint): bool => str_starts_with($hint, 'aura')
        ));
    }

    private function add(string $level, string $check, string $message, ?string $file = null, ?int $line = null): void
    {
        $this->findings[] = compact('level', 'check', 'message', 'file', 'line');
    }

    private function report(): int
    {
        $errors = array_filter($this->findings, fn (array $f): bool => $f['level'] === 'error');

        if ($this->option('json')) {
            $this->line((string) json_encode([
                'errors' => count($errors),
                'warnings' => count($this->findings) - count($errors),
                'findings' => $this->findings,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            return $errors === [] ? self::SUCCESS : self::FAILURE;
        }

        if ($this->findings === []) {
            $this->components->info('Aura UI: no problems found.');

            return self::SUCCESS;
        }

        foreach ($this->findings as $finding) {
            $where = $finding['file'] ?? '';
            if ($finding['line'] !== null) {
                $where .= ':'.$finding['line'];
            }

            $this->components->twoColumnDetail(
                ($finding['level'] === 'error' ? '<fg=red>ERROR</>' : '<fg=yellow>WARN</>').' '.$finding['check'],
                $where
            );
            $this->line('    '.$finding['message']);
        }

        $this->newLine();
        $this->components->error(count($errors).' error(s), '.(count($this->findings) - count($errors)).' warning(s).');

        return $errors === [] ? self::SUCCESS : self::FAILURE;
    }
}
