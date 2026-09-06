<?php

namespace BlueStarSystem\AuraUI;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuraUIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/aura-ui.php', 'aura-ui');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'aura');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'aura-ui');

        $this->registerComponents();
        $this->registerPlayground();

        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
            $this->registerCommands();
        }
    }

    protected function registerComponents(): void
    {
        $this->registerComponentOverrides();

        // Anonymous Blade components from resources/views/components/
        Blade::anonymousComponentPath(
            __DIR__.'/../resources/views/components',
            'aura'
        );
    }

    /**
     * Let the application override a single component by publishing it to
     * resources/views/vendor/aura/components/, the directory the views tag
     * already publishes to. loadViewsFrom() does this lookup for dotted
     * namespaces; anonymousComponentPath() does not, so we register the
     * directory ourselves, ahead of the package path, and only once -- the
     * Pro package shares the same prefix and calls this too.
     */
    protected function registerComponentOverrides(): void
    {
        $registered = array_column(Blade::getAnonymousComponentPaths(), 'path');

        foreach ((array) $this->app['config']->get('view.paths', []) as $viewPath) {
            $overridePath = $viewPath.'/vendor/aura/components';

            if (is_dir($overridePath) && ! in_array($overridePath, $registered, true)) {
                Blade::anonymousComponentPath($overridePath, 'aura');
            }
        }
    }

    protected function registerPlayground(): void
    {
        $config = $this->app['config']->get('aura-ui.playground', []);

        if (! ($config['enabled'] ?? false)) {
            return;
        }

        Route::middleware($config['middleware'] ?? ['web'])
            ->group(function () use ($config) {
                $path = $config['path'] ?? 'aura/playground';

                Route::get($path, function () {
                    return view('aura::playground.index');
                })->name('aura.playground');
            });
    }

    protected function registerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/aura-ui.php' => config_path('aura-ui.php'),
        ], 'aura-ui-config');

        $this->publishes([
            __DIR__.'/../resources/css' => resource_path('css/vendor/aura-ui'),
        ], 'aura-ui-css');

        $this->publishes([
            __DIR__.'/../resources/views/components' => resource_path('views/vendor/aura/components'),
        ], 'aura-ui-views');

        $this->publishes([
            __DIR__.'/../resources/js/vendor' => public_path('js/vendor'),
        ], 'aura-ui-assets');

        $this->publishes([
            __DIR__.'/../resources/lang' => $this->app->langPath('vendor/aura-ui'),
        ], 'aura-ui-lang');
    }

    protected function registerCommands(): void
    {
        $this->commands([
            Commands\InstallCommand::class,
            Commands\ManifestCommand::class,
            Commands\AddCommand::class,
            Commands\InitCommand::class,
            Commands\DoctorCommand::class,
        ]);
    }
}
