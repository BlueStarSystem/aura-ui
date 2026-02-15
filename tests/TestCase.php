<?php

namespace BlueStarSystem\AuraUI\Tests;

use BlueStarSystem\AuraUI\AuraUIServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            AuraUIServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('aura-ui.playground.enabled', true);
        $app['config']->set('app.key', 'base64:' . base64_encode(random_bytes(32)));
    }
}
