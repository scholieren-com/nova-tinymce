<?php

namespace Emilianotisato\NovaTinyMCE\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class SupportFileManagerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova-tinymce:support-lfm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix lfm index.php file among others files.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Fixing Filemanager files...');

        if (File::isFile(resource_path('views/vendor/laravel-filemanager/index.blade.php'))) {
            // Delete files that need to be override
            File::delete(
                [
                    resource_path('views/vendor/laravel-filemanager/index.blade.php'),
                ]
            );
        }

        if (! File::isDirectory(resource_path('views/vendor/laravel-filemanager'))) {
            File::makeDirectory(resource_path('views/vendor/laravel-filemanager'));
        }

        // Copy stubs
        File::copy(
            __DIR__ . '/stubs/laravel-filemanager/index.blade.php',
            resource_path('views/vendor/laravel-filemanager/index.blade.php')
        );

        $this->info("Installation was successful!" . PHP_EOL);

        return self::SUCCESS;
    }
}
