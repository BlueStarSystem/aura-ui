<?php

namespace BlueStarSystem\AuraUI\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class ManifestCommand extends Command
{
    protected $signature = 'aura:manifest {--source=} {--output=} {--tier=free}';

    protected $description = 'Regenerate the Aura component manifest (maintainer tool)';

    protected $hidden = true;

    public function handle(): int
    {
        $source = $this->option('source') ?: dirname(__DIR__, 2).'/resources/views/components';
        $output = $this->option('output') ?: dirname(__DIR__, 2).'/resources/aura-registry.json';
        $tier = (string) $this->option('tier');

        if (! is_dir($source)) {
            $this->error("Source directory not found: {$source}");

            return self::FAILURE;
        }

        $manifest = [];

        foreach (Finder::create()->files()->name('*.blade.php')->depth(0)->in($source) as $file) {
            $name = $file->getFilenameWithoutExtension();
            $name = preg_replace('/\.blade$/', '', $name);

            $files = [$name.'.blade.php'];

            if (is_dir($source.'/'.$name)) {
                foreach (Finder::create()->files()->name('*.blade.php')->in($source.'/'.$name)->sortByName() as $sub) {
                    $files[] = $name.'/'.str_replace('\\', '/', $sub->getRelativePathname());
                }
            }

            $manifest[$name] = [
                'tier' => $tier,
                'files' => $files,
                'deps' => $this->parseDeps($source, $files, $name),
            ];
        }

        ksort($manifest);

        file_put_contents(
            $output,
            json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n"
        );

        $this->info('Wrote '.count($manifest).' components to '.$output);

        return self::SUCCESS;
    }

    /**
     * @param  list<string>  $files
     * @return list<string>
     */
    private function parseDeps(string $source, array $files, string $self): array
    {
        $deps = [];

        foreach ($files as $relative) {
            $contents = (string) file_get_contents($source.'/'.$relative);

            if (preg_match_all('/<x-aura::([a-z0-9-]+)/', $contents, $matches)) {
                foreach ($matches[1] as $segment) {
                    if ($segment !== $self) {
                        $deps[$segment] = true;
                    }
                }
            }
        }

        $deps = array_keys($deps);
        sort($deps);

        return $deps;
    }
}
