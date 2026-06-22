<?php

namespace BlueStarSystem\AuraUI\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InitCommand extends Command
{
    protected $signature = 'aura:init {--path= : Destination components directory} {--force}';

    protected $description = 'Set up Aura for own-the-code usage (publish CSS, prepare component dir)';

    public function handle(): int
    {
        $this->callSilently('vendor:publish', array_filter([
            '--tag' => 'aura-ui-css',
            '--force' => (bool) $this->option('force') ?: null,
        ]));
        $this->components->info('Aura CSS published to resources/css/vendor/aura-ui/.');

        $dest = $this->option('path') ?: resource_path('views/components/aura');
        File::ensureDirectoryExists($dest);
        File::put($dest.'/.gitkeep', '');
        $this->components->info('Component directory ready: '.$dest);

        $this->newLine();
        $this->line('  Add to your app CSS (after Tailwind):');
        $this->line('  <comment>@import "vendor/aura-ui/aura.css";</comment>');
        $this->newLine();
        $this->line('  Then copy components, e.g.: <comment>php artisan aura:add button</comment>');
        $this->newLine();

        return self::SUCCESS;
    }
}
