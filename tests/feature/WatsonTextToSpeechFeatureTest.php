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
        $watson->setUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/v1/synthesize/');

        $path = sys_get_temp_dir();
        $watson->setOutputPath($path);
        $file = $watson->runTextToSpeech('Working');

        $this->assertStringStartsWith($path, $file);
    }

    /**
     * @throws Exception
     */
    public function testWatsonCanSpeakWav(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(AbstractSecret::API_KEY);
        $watson->setAudioFormat('wav');
        $watson->setUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/v1/synthesize/');
        $path = sys_get_temp_dir();
        $watson->setOutputPath($path);

        $file = $watson->runTextToSpeech('W.A.V.');

        $this->assertStringStartsWith($path, $file);
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

        $watson->setUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com');
        $path = sys_get_temp_dir();
        $watson->setOutputPath($path);

        $file = $watson->runTextToSpeech('British');

        $this->assertStringStartsWith($path, $file);
    }

    /**
     * @throws Exception
     */
    public function testWatsonTextToSpeechCanSetAudioLanguageAndVoice(): void
    {
        $path = sys_get_temp_dir();
        $watson = new WatsonTextToSpeech();

        $file = $watson->setApiKey(AbstractSecret::API_KEY)
            ->setOutputPath(sys_get_temp_dir())
            ->setUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com')
            ->runTextToSpeech('français', 'wav', 'fr-FR', 'ReneeV3Voice');

        $this->assertStringStartsWith($path, $file);
    }

    /**
     * @throws Exception
     */
    public function testWatsonApiKeyMustBeValid(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(AbstractSecret::API_KEY . 'invalid');
        $watson->setUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com');

        $path = sys_get_temp_dir();
        $watson->setOutputPath($path);
        $this->expectExceptionMessage('Error:Unauthorized code: 401');

        $watson->runTextToSpeech('Broken APIi');
    }
}
