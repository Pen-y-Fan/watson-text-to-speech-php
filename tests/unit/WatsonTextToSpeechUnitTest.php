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
    public function testApiKeyIsRequired(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Watson API key not provided');

        $watson->setApiKey('');
    }

    /**
     * @throws Exception
     */
    public function testAudioFormatIsRequired(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Audio format string is empty');

        $watson->setAudioFormat('');
    }

    /**
     * @throws Exception
     */
    public function testAudioFormatIsInvalid(): void
    {
        $watson = new WatsonTextToSpeech();

        $expected = 'Not a valid audio format. Allowed formats: basic, flac, l16, ogg, ogg;codecs=opus, ';
        $expected .= 'ogg;codecs=vorbis, mp3, mpeg, mulaw, wav, webm, webm;codecs=opus, webm;codecs=vorbi';

        $watson->setAudioFormat('wav');

        $this->expectExceptionMessage($expected);

        $watson->setAudioFormat('mp4');
    }

    /**
     * @throws Exception
     */
    public function testLanguageIsRequired(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Language string is empty');

        $watson->setLanguage('');
    }

    /**
     * @throws Exception
     */
    public function testLanguageIsInvalid(): void
    {
        $watson = new WatsonTextToSpeech();
        $expected = 'Not a valid language provided. Allowed languages: ';
        $expected .= 'ar-AR, de-DE, en-GB, en-US, es-ES, es-LA, es-US, ';
        $expected .= 'fr-FR, it-IT, ja-JP, nl-NL, pt-BR, zh-CN';
        $this->expectExceptionMessage($expected);

        $watson->setLanguage('uk-UK');
    }

    // setVoice

    /**
     * @throws Exception
     */
    public function testVoiceIsRequired(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Voice string is empty');

        $watson->setVoice('');
    }

    /**
     * @throws Exception
     */
    public function testVoiceIsInvalid(): void
    {
        $watson = new WatsonTextToSpeech();

        $expected = 'Not a valid voice provided. Allowed voices: AllisonV2Voice, AllisonV3Voice, AllisonVoice, ';
        $expected .= 'BirgitV2Voice, BirgitV3Voice, BirgitVoice, DieterV2Voice, DieterV3Voice, DieterVoice, ';
        $expected .= 'EmiV3Voice, EmiVoice, EmilyV3Voice, EmmaVoice, EnriqueV3Voice, EnriqueVoice, ErikaV3Voice, ';
        $expected .= 'FrancescaV2Voice, FrancescaV3Voice, FrancescaVoice, HenryV3Voice, IsabelaV3Voice, IsabelaVoice, ';
        $expected .= 'KateV3Voice, KateVoice, KevinV3Voice, LauraV3Voice, LauraVoice, LiNaVoice, LiamVoice, ';
        $expected .= 'LisaV2Voice, LisaV3Voice, LisaVoice, MichaelV2Voice, MichaelV3Voice, MichaelVoice, ';
        $expected .= 'OliviaV3Voice, OmarVoice, ReneeV3Voice, ReneeVoice, SofiaV3Voice, SofiaVoice, WangWeiVoice, ';
        $expected .= 'ZhangJingVoice';

        $this->expectExceptionMessage($expected);

        $watson->setVoice('uk-UK');
    }

    /**
     * @throws Exception
     */
    public function testOutputPathIsRequired(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Output path is empty');

        $watson->setOutputPath('');
    }

    /**
     * @requires OSFAMILY Windows
     * @throws Exception
     */
    public function testOutputPathIsInvalid(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Unable to create output directory');

        $watson->setOutputPath(sys_get_temp_dir() . '/>greaterthan');
    }

    /**
     * @throws Exception
     */
    public function testOutputPathCanBeCreated(): void
    {
        $path = sys_get_temp_dir() . '/' . random_int(1000, 9999);

        $watson = new WatsonTextToSpeech();
        $watson->setOutputPath($path);

        $this->assertDirectoryExists($path);

        rmdir($path);
    }

    /**
     * @throws Exception
     */
    public function testTextToSpeechRequiresText(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('No text string provided');

        $watson->runTextToSpeech('');
    }

    /**
     * @throws Exception
     */
    public function testTextToSpeechRequiresAnOutputPathToBeSet(): void
    {
        $watson = new WatsonTextToSpeech();

        $expected = 'Output path is not set. Please set an output path by passing absolute path string to setOutputPath()';

        $this->expectExceptionMessage($expected);

        $watson->runTextToSpeech('No Output');
    }

    /**
     * @throws Exception
     */
    public function testTextToSpeechRequiresAnAPIKeyToBeSet(): void
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
    public function testTextToSpeechRequiresTheURLToBeSet(): void
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
    public function testAudioWithCodecCabBeSetBeforeLanguageIsRequired(): void
    {
        $watson = new WatsonTextToSpeech();

        $watson->setAudioFormat('ogg;codecs=vorbis');

        $this->expectExceptionMessage('Language string is empty');

        $watson->setLanguage('');
    }
}
