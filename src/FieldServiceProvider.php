<?php

namespace Emilianotisato\NovaTinyMCE;

use Emilianotisato\NovaTinyMCE\Console\SupportFileManagerCommand;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            realpath(__DIR__ . '/../dist/tinymce') => public_path('vendor/tinymce'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../config/nova-tinymce.php' => config_path('nova-tinymce.php'),
        ], 'config');

        $this->publishes([__DIR__.'/../dist/tinymce' => public_path('vendor/tinymce')], ['nova-assets', 'laravel-assets']);

        Nova::serving(function (ServingNova $event) {
            Nova::script('Nova-TinyMCE-tinymce', __DIR__.'/../dist/js/tinymce.js');
            Nova::script('Nova-TinyMCE', __DIR__.'/../dist/js/field.js');
            Nova::style('Nova-TinyMCE', __DIR__.'/../dist/css/field.css');
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                SupportFileManagerCommand::class
            ]);
        }
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/nova-tinymce.php', 'nova-tinymce');
    }
}
