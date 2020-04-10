<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Console;

use Illuminate\Console\Command;

class WatsonTextToSpeechCommand extends Command
{
    protected $signature = 'watson-text-to-speech';

    protected $description = 'IBM Watson API to convert text to speech.';

    public function handle(): void
    {
        $this->info(
            'info on text to speech'
        );
    }
}
