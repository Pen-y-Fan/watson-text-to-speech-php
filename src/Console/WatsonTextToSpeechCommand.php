<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Console;

use Illuminate\Console\Command;
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeech;
use Throwable;

class WatsonTextToSpeechCommand extends Command
{
    protected $description = 'IBM Watson API can be called to convert text to speech.';

    /**
     * watson-text-to-speech console command.
     *
     * @var string
     */
    protected $signature = 'watson-text-to-speech {text?}';

    /**
     * @var WatsonTextToSpeech
     */
    protected $watsonTextToSpeech;

    /**
     * Create a new command instance.
     */
    public function __construct(WatsonTextToSpeech $watsonTextToSpeech)
    {
        parent::__construct();
        $this->watsonTextToSpeech = $watsonTextToSpeech;
    }

    /**
     * Execute the watson-text-to-speech console command.
     *
     * @throws Throwable
     */
    public function handle(): void
    {
        $text = $this->argument('text');

        if ($text === null) {
            $text = $this->ask('Enter the text you wish to convert to speech (quit to exit)');
        }

        if (strtolower($text) === 'quit' || strtolower($text) === 'exit') {
            exit;
        }
        $this->info('The following text is being converted to speech: ' . PHP_EOL . $text . PHP_EOL);

        try {
            $file = $this->watsonTextToSpeech->runTextToSpeech($text);
        } catch (Throwable $throwable) {
            $this->error('There was a problem converting the text. Error: ' . $throwable->getMessage());
            exit;
        }
        $this->info('Text has been converted to speech, see: ' . $file);
    }
}
