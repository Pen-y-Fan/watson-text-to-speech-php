<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\unit;

use Exception;
use Orchestra\Testbench\TestCase;
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeech;

class WatsonTextToSpeechUnitTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testRequiresText(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('No text string provided');

        $watson->runTextToSpeech('');
    }

    /**
     * @throws Exception
     */
    public function testRequiresAnOutputPathToBeSet(): void
    {
        $watson = new WatsonTextToSpeech();

        $expected = 'Output path is not set. Please set an output path by passing absolute path string to setOutputPath()';

        $this->expectExceptionMessage($expected);

        $watson->runTextToSpeech('No Output');
    }

    /**
     * @throws Exception
     */
    public function testRequiresAnAPIKeyToBeSet(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setOutputPath(sys_get_temp_dir());

        $this->expectExceptionMessage(
            'API key is not set. Please set API key by passing API Key string to setApiKey()'
        );
        $watson->runTextToSpeech('No API Key');
    }

    /**
     * @throws Exception
     */
    public function testRequiresTheURLToBeSet(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setOutputPath(sys_get_temp_dir());
        $watson->setApiKey('invalid');

        $this->expectExceptionMessage(
            'Url is not set. Please set Watson URL by passing Url string to setWatsonUrl()'
        );
        $watson->runTextToSpeech('No Url');
    }

    /**
     * @throws Exception
     */
    public function testMinimumSetCoverage(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setOutputPath(sys_get_temp_dir());
        $watson->setApiKey('yourAPIkeyFromIBM');
        $watson->setUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com');
        $watson->setAudioFormat('wav');
        $watson->setLanguage('en-US');
        $watson->setVoice('MichaelVoice');
        $watson->setLanguageAndVoice('de-DE_BirgitV2Voice');

        $this->expectExceptionMessage('No text string provided');
        $watson->runTextToSpeech('');
    }

    /**
     * @throws Exception
     */
    public function testChainingOfMethods(): void
    {
        $watson = new WatsonTextToSpeech();

        $this->expectExceptionMessage('No text string provided');

        $watson->setOutputPath(sys_get_temp_dir())
            ->setApiKey('yourAPIkeyFromIBM')
            ->setUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com')
            ->setAudioFormat('wav')
            ->setLanguage('en-US')
            ->setVoice('MichaelVoice')
            ->setLanguageAndVoice('de-DE_BirgitV2Voice')
            ->runTextToSpeech('');
    }
}
