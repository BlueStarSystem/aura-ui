<?php

namespace BlueStarSystem\AuraUI\Commands;

use BlueStarSystem\AuraUI\Support\ComponentInstaller;
use BlueStarSystem\AuraUI\Support\ComponentManifest;
use BlueStarSystem\AuraUI\Support\RemoteRegistry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AddCommand extends Command
{
    protected $signature = 'aura:add {components* : Component name(s) to copy into your project}
        {--path= : Destination components directory}
        {--force : Overwrite existing files}
        {--dry-run : Show what would be written without writing}
        {--no-deps : Do not copy dependencies}
        {--free-root= : (testing) override the free package root}
        {--pro-root= : (testing) override the pro package root}
        {--allow-host=* : Trust a registry host for remote installs (non-interactive)}';

    protected $description = 'Copy Aura component source into your project (own-the-code)';

    public function handle(): int
    {
        $requested = $this->argument('components');
        $urls = array_values(array_filter($requested, fn (string $a): bool => RemoteRegistry::isUrl($a)));
        $names = array_values(array_filter($requested, fn (string $a): bool => ! RemoteRegistry::isUrl($a)));

        $dest = $this->option('path') ?: resource_path('views/components/aura');
        $force = (bool) $this->option('force');
        $dryRun = (bool) $this->option('dry-run');
        $report = ['written' => [], 'skipped' => []];

        if ($names !== []) {
            $local = $this->installLocal($names, $dest, $force, $dryRun);
            if ($local === null) {
                return self::FAILURE;
            }
            $report['written'] = array_merge($report['written'], $local['written']);
            $report['skipped'] = array_merge($report['skipped'], $local['skipped']);
        }

        if ($urls !== []) {
            $remote = $this->installRemoteUrls($urls, $dest, $force, $dryRun);
            if ($remote === null) {
                return self::FAILURE;
            }
            $report['written'] = array_merge($report['written'], $remote['written']);
            $report['skipped'] = array_merge($report['skipped'], $remote['skipped']);
        }

        foreach ($report['written'] as $file) {
            $this->components->info(($dryRun ? 'Would write ' : 'Wrote ').$file);
        }
        foreach ($report['skipped'] as $file) {
            $this->components->warn("Skipped existing {$file} (use --force)");
        }

        return self::SUCCESS;
    }

    /**
     * @param  list<string>  $names
     * @return array{written:list<string>, skipped:list<string>}|null
     */
    private function installLocal(array $names, string $dest, bool $force, bool $dryRun): ?array
    {
        $freeRoot = $this->option('free-root') ?: dirname(__DIR__, 2);
        $proRoot = $this->option('pro-root') ?: base_path('vendor/bluestarsystem/aura-ui-pro');
        $proPresent = is_dir($proRoot.'/resources/views/components');

        $manifest = ComponentManifest::fromJsonFiles(array_filter([
            $freeRoot.'/resources/aura-registry.json',
            $proPresent ? $proRoot.'/resources/aura-registry.json' : null,
        ]));

        $resolved = [];

        foreach ($names as $name) {
            if (! $manifest->has($name)) {
                $this->error("Unknown Aura component: {$name}");

                return null;
            }

            if ($manifest->tier($name) === 'pro' && ! $proPresent) {
                $this->error("\"{$name}\" is a Pro component. Run first: composer require bluestarsystem/aura-ui-pro");

                return null;
            }

            foreach ($this->option('no-deps') ? [$name] : $manifest->resolve($name) as $component) {
                $resolved[] = $component;
            }
        }

        $resolved = array_values(array_unique($resolved));

        foreach ($resolved as $name) {
            if ($manifest->tier($name) === 'pro' && ! $proPresent) {
                $this->error("\"{$name}\" is a Pro component. Run first: composer require bluestarsystem/aura-ui-pro");

                return null;
            }
        }

        $sourceBasePaths = ['free' => $freeRoot.'/resources/views/components'];
        if ($proPresent) {
            $sourceBasePaths['pro'] = $proRoot.'/resources/views/components';
        }

        return (new ComponentInstaller($sourceBasePaths, $dest))->install($resolved, $manifest, $force, $dryRun);
    }

    /**
     * @param  list<string>  $urls
     * @return array{written:list<string>, skipped:list<string>}|null
     */
    private function installRemoteUrls(array $urls, string $dest, bool $force, bool $dryRun): ?array
    {
        $allowed = array_merge(
            (array) config('aura-ui.registry.allowed_hosts', ['aura-ui.com']),
            (array) $this->option('allow-host'),
        );
        $maxBytes = (int) config('aura-ui.registry.max_bytes', 512 * 1024);

        $confirm = function (string $host): bool {
            if (! $this->input->isInteractive()) {
                return false;
            }

            return $this->confirm("Install from non-allowlisted registry host \"{$host}\"?", false);
        };

        $fetcher = function (string $url) use ($maxBytes): array {
            $response = Http::timeout(15)->acceptJson()->get($url);

            return ['status' => $response->status(), 'body' => substr($response->body(), 0, $maxBytes + 1)];
        };

        $registry = new RemoteRegistry($allowed, $maxBytes, $confirm, $fetcher);
        $installer = new ComponentInstaller(['free' => $dest], $dest);

        $report = ['written' => [], 'skipped' => []];

        foreach ($urls as $url) {
            try {
                $items = $this->option('no-deps') ? [$registry->fetch($url)] : $registry->resolveTree($url);
            } catch (\RuntimeException $e) {
                $this->error($e->getMessage());

                return null;
            }

            $r = $installer->installRemote($items, $force, $dryRun);
            $report['written'] = array_merge($report['written'], $r['written']);
            $report['skipped'] = array_merge($report['skipped'], $r['skipped']);
        }

        return $report;
    }
}
