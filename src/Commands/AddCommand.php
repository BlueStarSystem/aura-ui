<?php

namespace BlueStarSystem\AuraUI\Commands;

use BlueStarSystem\AuraUI\Support\ComponentInstaller;
use BlueStarSystem\AuraUI\Support\ComponentManifest;
use Illuminate\Console\Command;

class AddCommand extends Command
{
    protected $signature = 'aura:add {components* : Component name(s) to copy into your project}
        {--path= : Destination components directory}
        {--force : Overwrite existing files}
        {--dry-run : Show what would be written without writing}
        {--no-deps : Do not copy dependencies}
        {--free-root= : (testing) override the free package root}
        {--pro-root= : (testing) override the pro package root}';

    protected $description = 'Copy Aura component source into your project (own-the-code)';

    public function handle(): int
    {
        $freeRoot = $this->option('free-root') ?: dirname(__DIR__, 2);
        $proRoot = $this->option('pro-root') ?: base_path('vendor/bluestarsystem/aura-ui-pro');
        $proPresent = is_dir($proRoot.'/resources/views/components');

        $manifest = ComponentManifest::fromJsonFiles(array_filter([
            $freeRoot.'/resources/aura-registry.json',
            $proPresent ? $proRoot.'/resources/aura-registry.json' : null,
        ]));

        $requested = $this->argument('components');
        $resolved = [];

        foreach ($requested as $name) {
            if (! $manifest->has($name)) {
                $this->error("Unknown Aura component: {$name}");

                return self::FAILURE;
            }

            if ($manifest->tier($name) === 'pro' && ! $proPresent) {
                $this->error("\"{$name}\" is a Pro component. Run first: composer require bluestarsystem/aura-ui-pro");

                return self::FAILURE;
            }

            foreach ($this->option('no-deps') ? [$name] : $manifest->resolve($name) as $component) {
                $resolved[] = $component;
            }
        }

        $resolved = array_values(array_unique($resolved));

        foreach ($resolved as $name) {
            if ($manifest->tier($name) === 'pro' && ! $proPresent) {
                $this->error("\"{$name}\" is a Pro component. Run first: composer require bluestarsystem/aura-ui-pro");

                return self::FAILURE;
            }
        }

        $sourceBasePaths = ['free' => $freeRoot.'/resources/views/components'];

        if ($proPresent) {
            $sourceBasePaths['pro'] = $proRoot.'/resources/views/components';
        }

        $dest = $this->option('path') ?: resource_path('views/components/aura');

        $installer = new ComponentInstaller($sourceBasePaths, $dest);
        $report = $installer->install($resolved, $manifest, (bool) $this->option('force'), (bool) $this->option('dry-run'));

        foreach ($report['written'] as $file) {
            $this->components->info(($this->option('dry-run') ? 'Would write ' : 'Wrote ').$file);
        }

        foreach ($report['skipped'] as $file) {
            $this->components->warn("Skipped existing {$file} (use --force)");
        }

        return self::SUCCESS;
    }
}
