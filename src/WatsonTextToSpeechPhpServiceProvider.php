<?php

namespace PenYFan\WatsonTextToSpeechPhp;

use Illuminate\Support\ServiceProvider;

class WatsonTextToSpeechPhpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'watson-text-to-speech-php');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'watson-text-to-speech-php');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('watson-text-to-speech-php.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/watson-text-to-speech-php'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/watson-text-to-speech-php'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/watson-text-to-speech-php'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'watson-text-to-speech-php');

        // Register the main class to use with the facade
        $this->app->singleton('watson-text-to-speech-php', function () {
            return new WatsonTextToSpeechPhp;
        });
    }
}
