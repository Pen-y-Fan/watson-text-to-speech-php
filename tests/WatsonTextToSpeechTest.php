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

    /**
     * @test
     * @throws Exception
     */
    public function watsonCanSpeakWav()
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(Secret::API_KEY);
        $watson->setAudioFormat('wav');
        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/v1/synthesize/');
        $watson->setOutputPath('/public');

        $file = $watson->runTextToSpeech('Watson speaks W.A.V.');

        $this->assertStringStartsWith('/public', $file);
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonCanSpeakKateGB()
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(Secret::API_KEY);
        $watson->setLanguage('en-GB');
        $watson->setVoice('KateVoice');

        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com');
        $watson->setOutputPath('/public');

        $file = $watson->runTextToSpeech('Watson is British');

        $this->assertStringStartsWith('/public', $file);
    }
}
