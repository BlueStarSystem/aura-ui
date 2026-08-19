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

        /*
         * The config is a file the application owns and edits, so it is never
         * overwritten: publishing it a second time leaves an existing one alone.
         */
        $this->callSilently('vendor:publish', [
            '--tag' => 'aura-ui-config',
        ]);
        $this->components->info('Config file published.');

        /*
         * The stylesheet and the JS assets are copies of the package, not files
         * to edit — they land under a directory called vendor for that reason.
         * They are forced, because `vendor:publish` otherwise refuses to touch a
         * file that already exists, and the copy then keeps whatever it had at
         * install time. Upgrading the package would leave the old stylesheet in
         * place with no error and no warning: new rules simply never reach the
         * build, which is the kind of failure nobody thinks to look for.
         */
        $this->callSilently('vendor:publish', [
            '--tag' => 'aura-ui-css',
            '--force' => true,
        ]);
        $this->components->info('CSS files published.');

        $this->callSilently('vendor:publish', [
            '--tag' => 'aura-ui-assets',
            '--force' => true,
        ]);
        $this->components->info('JS vendor assets published.');

        $this->newLine();
        $this->components->info('Aura UI installed successfully!');
        $this->newLine();

        $this->line('  Add these to <comment>resources/css/app.css</comment>:');
        $this->newLine();
        $this->line("      @import 'tailwindcss';");
        $this->line("      @source '../../vendor/bluestarsystem/aura-ui/resources/views/**/*.blade.php';");
        $this->line("      @import '../../vendor/bluestarsystem/aura-ui/resources/css/aura.css';");
        $this->newLine();
        $this->line('  Importing the stylesheet straight from <comment>vendor</comment> keeps it in step with the');
        $this->line('  package on every <comment>composer update</comment>, with nothing to re-publish. The copy');
        $this->line('  under <comment>resources/css/vendor/aura-ui</comment> still works if you already import it.');
        $this->newLine();
        $this->line('  Then visit <comment>/aura/playground</comment> to preview components.');
        $this->newLine();

        return self::SUCCESS;
    }
}
