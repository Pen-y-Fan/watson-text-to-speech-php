<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\feature;

use Exception;
use Orchestra\Testbench\TestCase;
use PenYFan\WatsonTextToSpeech\Tests\AbstractSecret;
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeech;

class WatsonTextToSpeechFeatureTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testWatsonCanSpeak(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(AbstractSecret::API_KEY);
        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/v1/synthesize/');

        $path = '/public';
        $watson->setOutputPath($path);
        $file = $watson->runTextToSpeech('Working');

        $this->assertStringStartsWith('/public', $file);
    }

    /**
     * @throws Exception
     */
    public function testWatsonCanSpeakWav(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(AbstractSecret::API_KEY);
        $watson->setAudioFormat('wav');
        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/v1/synthesize/');
        $watson->setOutputPath('/public');

        $file = $watson->runTextToSpeech('W.A.V.');

        $this->assertStringStartsWith('/public', $file);
    }

    /**
     * @throws Exception
     */
    public function testWatsonCanSpeakKateGB(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(AbstractSecret::API_KEY);
        $watson->setLanguage('en-GB');
        $watson->setVoice('KateVoice');

        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com');
        $watson->setOutputPath('/public');

        $file = $watson->runTextToSpeech('British');

        $this->assertStringStartsWith('/public', $file);
    }

    /**
     * @throws Exception
     */
    public function testWatsonTextToSpeechCanSetAudioLanguageAndVoice(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(AbstractSecret::API_KEY);
        $watson->setOutputPath('/public');
        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com');

        $file = $watson->runTextToSpeech('français', 'wav', 'fr-FR', 'ReneeV3Voice');

        $this->assertStringStartsWith('/public/', $file);
    }

    /**
     * @throws Exception
     */
    public function testWatsonApiKeyMustBeValid(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(AbstractSecret::API_KEY . 'invalid');
        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com');

        $path = '/public';
        $watson->setOutputPath($path);
        $this->expectExceptionMessage('Error:Unauthorized code: 401');

        $watson->runTextToSpeech('Broken APIi');
    }
}
