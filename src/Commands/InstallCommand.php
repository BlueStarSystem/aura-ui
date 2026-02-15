<?php

namespace BlueStarSystem\AuraUI\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'aura:install';

    protected $description = 'Install Aura UI components and publish assets';

    public function handle(): int
    {
        $this->info('Installing Aura UI...');

        // Publish config
        $this->callSilently('vendor:publish', [
            '--tag' => 'aura-ui-config',
        ]);
        $this->components->info('Config file published.');

        // Publish CSS
        $this->callSilently('vendor:publish', [
            '--tag' => 'aura-ui-css',
        ]);
        $this->components->info('CSS files published.');

        $this->newLine();
        $this->components->info('Aura UI installed successfully!');
        $this->newLine();

        $this->line('  Next steps:');
        $this->line('  1. Add to your CSS: <comment>@import "vendor/aura-ui/aura.css";</comment>');
        $this->line('  2. Visit <comment>/aura/playground</comment> to preview components');
        $this->newLine();

        return self::SUCCESS;
    }
}
