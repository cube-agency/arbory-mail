<?php

namespace CubeAgency\ArboryMail\Providers;

use CubeAgency\ArboryMail\Console\Commands\ArboryMailGenerateCommand;
use CubeAgency\ArboryMail\Console\Commands\ArboryMailMakeCommand;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/arbory-mail.php' => config_path('arbory-mail.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../resources/lang/' => base_path('resources/lang/vendor/arbory-mail')
        ], 'lang');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views/', 'arbory-mail');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang/', 'arbory-mail');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ArboryMailMakeCommand::class,
                ArboryMailGenerateCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
