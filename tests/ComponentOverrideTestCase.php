<?php

namespace BlueStarSystem\AuraUI\Tests;

use Illuminate\Filesystem\Filesystem;

/**
 * Boots the package with an application override directory already in place,
 * the way a consumer who published a single component would have it.
 */
abstract class ComponentOverrideTestCase extends TestCase
{
    protected string $viewPath;

    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $this->viewPath = sys_get_temp_dir().'/aura-ui-override-'.uniqid();

        (new Filesystem)->ensureDirectoryExists($this->viewPath.'/vendor/aura/components');
        file_put_contents(
            $this->viewPath.'/vendor/aura/components/badge.blade.php',
            '<span class="overridden-badge">{{ $slot }}</span>'
        );

        $app['config']->set('view.paths', [$this->viewPath]);
    }

    protected function tearDown(): void
    {
        (new Filesystem)->deleteDirectory($this->viewPath);

        parent::tearDown();
    }
}
