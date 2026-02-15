<?php

namespace BlueStarSystem\AuraUI;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuraUIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/aura-ui.php', 'aura-ui');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'aura');

        $this->registerComponents();
        $this->registerPlayground();

        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
            $this->registerCommands();
        }
    }

    protected function registerComponents(): void
    {
        // Anonymous Blade components from resources/views/components/
        Blade::anonymousComponentPath(
            __DIR__ . '/../resources/views/components',
            'aura'
        );
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
            __DIR__ . '/../config/aura-ui.php' => config_path('aura-ui.php'),
        ], 'aura-ui-config');

        $this->publishes([
            __DIR__ . '/../resources/css' => resource_path('css/vendor/aura-ui'),
        ], 'aura-ui-css');

        $this->publishes([
            __DIR__ . '/../resources/views/components' => resource_path('views/vendor/aura/components'),
        ], 'aura-ui-views');
    }

    protected function registerCommands(): void
    {
        $this->commands([
            Commands\InstallCommand::class,
        ]);
    }
}
