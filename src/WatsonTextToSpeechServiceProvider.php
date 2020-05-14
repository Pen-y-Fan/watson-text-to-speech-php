<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech;

use Illuminate\Support\ServiceProvider;
use PenYFan\WatsonTextToSpeech\Console\WatsonTextToSpeechCommand;

class WatsonTextToSpeechServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => 'watson-text-to-speech.php',
            ], 'config');

            $this->commands([WatsonTextToSpeechCommand::class]);
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'config');

        $this->app->singleton('watson-text-to-speech', function () {
            return new WatsonTextToSpeech();
        });
    }
}
