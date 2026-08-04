<?php

use Illuminate\Support\Facades\File;

function auraDoctorViews(string $blade): string
{
    $dir = sys_get_temp_dir().'/aura-doctor-'.uniqid();
    File::ensureDirectoryExists($dir);
    File::put($dir.'/page.blade.php', $blade);

    return $dir;
}

it('passes on a clean view', function () {
    $dir = auraDoctorViews('<x-aura::button variant="primary">Save</x-aura::button>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->expectsOutputToContain('no problems found')
        ->assertSuccessful();

    File::deleteDirectory($dir);
});

it('flags a variant the component does not style', function () {
    $dir = auraDoctorViews('<x-aura::badge variant="neutral">Draft</x-aura::badge>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->expectsOutputToContain('invalid-variant')
        ->assertFailed();

    File::deleteDirectory($dir);
});

it('accepts a variant the component does style', function () {
    $dir = auraDoctorViews('<x-aura::badge variant="info">Draft</x-aura::badge>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->assertSuccessful();

    File::deleteDirectory($dir);
});

it('flags an unknown component name', function () {
    $dir = auraDoctorViews('<x-aura::buton variant="primary">Typo</x-aura::buton>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->expectsOutputToContain('unknown-component')
        ->assertFailed();

    File::deleteDirectory($dir);
});

it('flags an icon-only button with no accessible name', function () {
    $dir = auraDoctorViews('<x-aura::button><x-aura::icon name="trash" /></x-aura::button>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->expectsOutputToContain('a11y')
        ->assertFailed();

    File::deleteDirectory($dir);
});

it('accepts an icon-only button that carries an aria-label', function () {
    $dir = auraDoctorViews('<x-aura::button aria-label="Delete"><x-aura::icon name="trash" /></x-aura::button>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->assertSuccessful();

    File::deleteDirectory($dir);
});

it('reports findings as JSON when asked', function () {
    $dir = auraDoctorViews('<x-aura::badge variant="neutral">Draft</x-aura::badge>');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true, '--json' => true])
        ->expectsOutputToContain('"check": "invalid-variant"')
        ->assertFailed();

    File::deleteDirectory($dir);
});

it('does not flag an unknown component name that only exists inside a Blade comment', function () {
    $dir = auraDoctorViews('{{-- <x-aura::buton variant="primary">Typo</x-aura::buton> --}}');

    $this->artisan('aura:doctor', ['--path' => [$dir], '--skip-setup' => true])
        ->assertSuccessful();

    File::deleteDirectory($dir);
});

describe('--a11y', function () {
    beforeEach(function () {
        $this->views = sys_get_temp_dir().'/aura-doctor-'.uniqid();
        File::makeDirectory($this->views, 0777, true);
    });

    afterEach(function () {
        File::deleteDirectory($this->views);
    });

    function writeView(string $dir, string $name, string $contents): void
    {
        File::put($dir.'/'.$name.'.blade.php', $contents);
    }

    it('flags an input with neither label nor aria-label', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertFailed();
    });

    it('does not flag an input that has a label', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" label="Email" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag an input that has an aria-label', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" aria-label="Email" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag a dynamic label', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" :label="$label" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag an input wrapped by a <label> with no for/id', function () {
        writeView($this->views, 'page', '<label>Email <x-aura::input name="email" /></label>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('still flags an unlabelled input that follows an unrelated, already-closed <label>', function () {
        writeView($this->views, 'page', '<label>Something else</label><x-aura::input name="email" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertFailed();
    });

    it('flags a second, genuinely unlabelled input that follows a wrapping label', function () {
        writeView($this->views, 'page', '<label>Email <x-aura::input name="email" /></label><x-aura::input name="name" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--json' => true, '--skip-setup' => true])
            ->expectsOutputToContain('"errors": 1')
            ->assertFailed();
    });

    it('still flags an input that has an id but no matching <label for>', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" id="email" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertFailed();
    });

    it('does not flag an input associated with a native <label for>', function () {
        writeView($this->views, 'page', '<label for="email">Email</label><x-aura::input name="email" id="email" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag an input with a dynamic id, since the matching label cannot be resolved statically', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" :id="$fieldId" />');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('flags an img without alt', function () {
        writeView($this->views, 'page', '<img src="/logo.png">');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertFailed();
    });

    it('accepts an empty alt as a deliberate decorative image', function () {
        writeView($this->views, 'page', '<img src="/deco.png" alt="">');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('accepts role="presentation" as a deliberate decorative image', function () {
        writeView($this->views, 'page', '<img src="/deco.png" role="presentation">');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('accepts role="none" as a deliberate decorative image', function () {
        writeView($this->views, 'page', '<img src="/deco.png" role="none">');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('warns without failing on generic link text', function () {
        writeView($this->views, 'page', '<a href="/x">clicca qui</a>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();   // warning, non error
    });

    it('flags a positive tabindex', function () {
        writeView($this->views, 'page', '<div tabindex="3">x</div>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertFailed();
    });

    it('does not flag tabindex="-1" or tabindex="0"', function () {
        writeView($this->views, 'page', '<div tabindex="-1">a</div><div tabindex="0">b</div>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('flags a modal with no accessible name', function () {
        writeView($this->views, 'page', '<x-aura::modal name="confirm">body</x-aura::modal>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertFailed();
    });

    it('does not flag a modal that has a title', function () {
        writeView($this->views, 'page', '<x-aura::modal name="confirm" title="Confirm">body</x-aura::modal>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag a modal whose title comes from a named slot', function () {
        writeView($this->views, 'page', '<x-aura::modal name="confirm"><x-slot:title>Confirm</x-slot:title>body</x-aura::modal>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag <x-aura::select.option> as an unlabelled select', function () {
        writeView($this->views, 'page', '<x-aura::select label="Plan"><x-aura::select.option value="a">A</x-aura::select.option></x-aura::select>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('warns without failing when a heading level is skipped', function () {
        writeView($this->views, 'page', '<h1>Title</h1><h3>Sub</h3>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();   // warning, non error
    });

    it('does not warn on a well-ordered outline, nor on going back up', function () {
        writeView($this->views, 'page', '<h1>A</h1><h2>B</h2><h3>C</h3><h2>D</h2>');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--json' => true, '--skip-setup' => true])
            ->expectsOutputToContain('"warnings": 0')
            ->assertSuccessful();
    });

    it('runs no a11y checks without the flag', function () {
        writeView($this->views, 'page', '<x-aura::input name="email" />');

        $this->artisan('aura:doctor', ['--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('does not flag markup that only exists inside a Blade comment', function () {
        writeView($this->views, 'page', '{{-- <x-aura::input name="email" /> --}}{{-- <img src="/x.png"> --}}');

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
            ->assertSuccessful();
    });

    it('reports the correct line number for a finding that follows a multi-line comment', function () {
        writeView($this->views, 'page', "{{--\n  a comment\n  spanning lines\n--}}\n<img src=\"/logo.png\">");

        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--json' => true, '--skip-setup' => true])
            ->expectsOutputToContain('"line": 5')
            ->assertFailed();
    });

    describe('theme contrast', function () {
        it('flags a custom primary that fails AA against white', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: #7dd3fc; }');   // 1.7:1 against white

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views]])
                ->expectsOutputToContain('a11y-theme')
                ->assertFailed();

            File::delete($css);
        });

        it('accepts a custom primary that passes AA', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: #4338ca; }');   // 7.9:1

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->assertSuccessful();

            File::delete($css);
        });

        it('warns instead of failing when a ratio is borderline close to the AA threshold', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: #777777; }');   // 4.48:1, just under 4.5

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('borderline')
                ->assertSuccessful();   // warning, not error -- the tool cannot be certain this close to the line

            File::delete($css);
        });

        it('warns on a borderline pass too, since the tool cannot assert certainty either side of the margin', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: #767676; }');   // 4.54:1, just over 4.5

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('borderline')
                ->assertSuccessful();

            File::delete($css);
        });

        it('warns rather than errors when no @theme block is present, since Aura defaults already pass AA', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@import "tailwindcss";');

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('No Aura colour overrides found')
                ->assertSuccessful();

            File::delete($css);
        });

        it('skips a colour Contrast cannot parse with a warning instead of crashing the scan', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: not-a-colour; }');

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('Could not read')
                ->assertSuccessful();

            File::delete($css);
        });

        it('does not run the theme check without --a11y', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: #7dd3fc; }');   // would otherwise fail

            $this->artisan('aura:doctor', ['--path' => [$this->views], '--skip-setup' => true])
                ->assertSuccessful();

            File::delete($css);
        });

        it('does not flag a colour override that is commented out, since the browser never applies it', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { /* --color-aura-primary-600: #7dd3fc; */ }');   // would fail AA if live

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->assertSuccessful();

            File::delete($css);
        });

        it('still flags a live override that sits right next to a commented-out one in the same block', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { /* --color-aura-danger-600: #4338ca; */ --color-aura-primary-600: #7dd3fc; }');

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('a11y-theme')
                ->assertFailed();

            File::delete($css);
        });

        it('does not let a nested at-rule inside @theme truncate the block, so a later override is still checked', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, <<<'CSS'
            @theme {
                --color-aura-danger-600: #4338ca;
                @media (prefers-color-scheme: dark) {
                    --color-aura-danger-600: #4338ca;
                }
                --color-aura-primary-600: #7dd3fc;
            }
            CSS);

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('a11y-theme')
                ->assertFailed();

            File::delete($css);
        });

        it('warns distinctly, rather than reassuring, when the @theme block could not be fully read', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: #4338ca');   // never closed

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('could not be fully read')
                ->assertSuccessful();   // warning, not error -- did not claim compliance it could not verify

            File::delete($css);
        });

        it('warns rather than crashes when app.css exists but cannot be read', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: #4338ca; }');

            File::partialMock()
                ->shouldReceive('get')
                ->with($css)
                ->andThrow(new RuntimeException('permission denied'));

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('Could not read')
                ->assertSuccessful();

            File::delete($css);
        });

        it('is not fooled by a brace inside a quoted value, and still catches the override that follows it', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --font-label: "weird } quote"; --color-aura-primary-600: #7dd3fc; }');

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('a11y-theme')
                ->assertFailed();

            File::delete($css);
        });

        it('warns rather than guesses when an unterminated comment could hide a live override', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { /* --color-aura-primary-600: #7dd3fc; }');   // note: no closing */

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('could not be fully read')
                ->assertSuccessful();   // warning, not a guessed pass or fail

            File::delete($css);
        });

        it('does not let an unquoted url() token with a stray brace hide a real override', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: url(http://x.com/img}?y=1); --color-aura-danger-600: #7dd3fc; }');

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('a11y-theme')
                ->assertFailed();   // the invalid url() value cannot be read as a colour either -- a genuine finding

            File::delete($css);
        });

        it('honours a backslash escape outside quotes, so a real override right after it is still checked', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --x: a\}b; --color-aura-primary-600: #7dd3fc; }');

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('a11y-theme')
                ->assertFailed();

            File::delete($css);
        });

        it('does not let whitespace between "url" and "(" open a hole for a stray brace to hide a real override', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: url  (http://x.com/img}?y=1); --color-aura-danger-600: #7dd3fc; }');

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('a11y-theme')
                ->assertFailed();   // danger-600 is a genuine, un-lost failing override

            File::delete($css);
        });

        it('does not let a declaration-shaped fragment inside a quoted value spoof a passing override over a real failing one', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: #7dd3fc; --color-aura-danger-600: "junk;--color-aura-primary-600: #4338ca;more"; }');

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('a11y-theme')
                ->assertFailed();   // the real, failing primary-600 must not be spoofed into passing

            File::delete($css);
        });

        it('flushes the last declaration before the closing brace even without a trailing semicolon', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: #7dd3fc }');   // legal CSS, no trailing ";"

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('a11y-theme')
                ->assertFailed();   // must not present as "no overrides found"

            File::delete($css);
        });

        it('does not treat "url(" embedded inside a longer identifier as a url() token, so a real override is not swallowed', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --x: notaurl(void; --color-aura-primary-600: #7dd3fc); }');

            // Without the fix, "notaurl(" would be treated as url(), silently
            // swallowing the override and the ";" that ends it -- reporting
            // "no overrides found" instead. Here the override is captured
            // (with a stray, unmatched ")" trailing its value, from
            // "notaurl("'s own unbalanced paren), which Contrast::ratio()
            // cannot parse as a colour -- a warning, not silence and not an
            // error, is the correct, honest result for this malformed input.
            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('a11y-theme')
                ->assertSuccessful();

            File::delete($css);
        });

        it('does not let a declaration inside a nested at-rule mask a real, failing top-level override', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --color-aura-primary-600: #7dd3fc; @media (min-width:0) { --color-aura-primary-600: #4338ca; } }');

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('a11y-theme')
                ->assertFailed();   // the passing nested value must not mask the failing top-level one

            File::delete($css);
        });

        it('treats a non-ASCII character before "url(" as an identifier character too, so a real override is not swallowed', function () {
            $css = resource_path('css/app.css');
            File::ensureDirectoryExists(dirname($css));
            File::put($css, '@theme { --x: ñurl(void; --color-aura-primary-600: #7dd3fc); --color-aura-danger-600: #7dd3fc; }');

            $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--skip-setup' => true])
                ->expectsOutputToContain('a11y-theme')
                ->assertFailed();   // danger-600 is a genuine, un-lost failing (1.7:1) override

            File::delete($css);
        });
    });

    it('degrades a check that throws to a warning and still runs the others', function () {
        writeView($this->views, 'page', '<img src="/logo.png">');   // a genuine, unrelated a11y finding

        $css = resource_path('css/app.css');
        File::ensureDirectoryExists(dirname($css));
        File::put($css, '@theme { --color-aura-primary-600: #4338ca; }');

        // Simulates the production failure Sentry reported: a consumer whose
        // vendored copy of Aura predates a class the theme check depends on.
        // File::exists() is the first call both checkCssSetup() and
        // checkThemeContrast() make against this exact path, so throwing
        // there exercises the guard around both check groups at once.
        File::partialMock()
            ->shouldReceive('exists')
            ->with($css)
            ->andThrow(new Error('Class "BlueStarSystem\AuraUI\Support\Contrast" not found'));

        // Only one expectsOutputToContain() per artisan() call: report() writes
        // the whole --json payload in a single line() call, and Laravel's test
        // harness matches each expected substring against a *single* output
        // write, consuming it -- a second substring expectation would never see
        // a write left to match. assertFailed() independently proves execution
        // continued past the broken check and reached a real finding: the only
        // possible source of a hard error here is the genuine <img> alt-text
        // issue from the untouched blade-usage check, since css-setup and
        // theme-contrast both degrade to warnings under the mocked throw.
        $this->artisan('aura:doctor', ['--a11y' => true, '--path' => [$this->views], '--json' => true])
            ->expectsOutputToContain('could not complete and was skipped')
            ->assertFailed();

        File::delete($css);
    });
});
