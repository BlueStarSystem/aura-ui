<?php

namespace BlueStarSystem\AuraUI\Support;

use RuntimeException;

final class ComponentInstaller
{
    /** @param array{free:string, pro?:string} $sourceBasePaths */
    public function __construct(
        private array $sourceBasePaths,
        private string $destPath,
    ) {}

    public static function rewriteNamespace(string $blade): string
    {
        return preg_replace('/(<\/?x-aura)::/', '$1.', $blade);
    }

    /**
     * @param  list<string>  $components
     * @return array{written:list<string>, skipped:list<string>}
     */
    public function install(array $components, ComponentManifest $manifest, bool $force, bool $dryRun): array
    {
        $written = [];
        $skipped = [];

        foreach ($components as $name) {
            $entry = $manifest->get($name);
            $base = $this->sourceBasePaths[$entry['tier']] ?? null;

            if ($base === null) {
                throw new RuntimeException("No source path configured for tier: {$entry['tier']}");
            }

            foreach ($entry['files'] as $relative) {
                $target = $this->destPath.'/'.$relative;

                if (is_file($target) && ! $force) {
                    $skipped[] = $relative;

                    continue;
                }

                $written[] = $relative;

                if ($dryRun) {
                    continue;
                }

                $contents = self::rewriteNamespace((string) file_get_contents($base.'/'.$relative));

                if (! is_dir(dirname($target))) {
                    mkdir(dirname($target), 0755, true);
                }

                file_put_contents($target, $contents);
            }
        }

        return ['written' => $written, 'skipped' => $skipped];
    }

    /**
     * @param  array<int, array{name:string, files:array<string,string>}>  $items
     * @return array{written:list<string>, skipped:list<string>}
     */
    public function installRemote(array $items, bool $force, bool $dryRun): array
    {
        $written = [];
        $skipped = [];

        foreach ($items as $item) {
            foreach ($item['files'] as $relative => $content) {
                if (! RemoteRegistry::pathIsSafe($relative)) {
                    throw new RuntimeException("Unsafe component path: {$relative}");
                }

                $target = $this->destPath.'/'.$relative;

                if (is_file($target) && ! $force) {
                    $skipped[] = $relative;

                    continue;
                }

                $written[] = $relative;

                if ($dryRun) {
                    continue;
                }

                if (! is_dir(dirname($target))) {
                    mkdir(dirname($target), 0755, true);
                }

                file_put_contents($target, self::rewriteNamespace($content));
            }
        }

        return ['written' => $written, 'skipped' => $skipped];
    }
}
