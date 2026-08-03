<?php

namespace BlueStarSystem\AuraUI\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

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

    /** @var list<array{level: string, check: string, message: string, file: string|null, line: int|null}> */
    private array $findings = [];

    public function handle(): int
    {
        if (! $this->option('skip-setup')) {
            $this->checkCssSetup();
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
