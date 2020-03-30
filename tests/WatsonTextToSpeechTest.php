<?php

namespace PenYFan\WatsonTextToSpeech\Tests;

use Exception;
use Orchestra\Testbench\TestCase;
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeech;
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeechServiceProvider;

class WatsonTextToSpeechTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [WatsonTextToSpeechServiceProvider::class];
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonCanSpeak()
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(Secret::API_KEY);
        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/v1/synthesize/');

        $path = '/public';
        $watson->setOutputPath($path);
        $file = $watson->runTextToSpeech('Watson is working');

        $this->assertStringStartsWith('/public', $file);
    }
}
