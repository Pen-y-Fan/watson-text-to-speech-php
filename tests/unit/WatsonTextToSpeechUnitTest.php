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
    public function testWatsonUrlIsRequired(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Watson URL not provided');

        $watson->setWatsonUrl('');
    }

    /**
     * @throws Exception
     */
    public function testWatsonUrlIsInvalid(): void
    {
        $watson = new WatsonTextToSpeech();

        $expected = 'Not a valid Watson URL. Allowed URLs: ';
        $expected .= 'https://api.au-syd.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.eu-gb.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.eu-de.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.jp-tok.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.kr-seo.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.us-east.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.us-south.text-to-speech.watson.cloud.ibm.com';

        $this->expectExceptionMessage($expected);

        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm');
    }

    /**
     * @throws Exception
     */
    public function testWatsonApiKeyIsRequired(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Watson API key not provided');

        $watson->setApiKey('');
    }

    /**
     * @throws Exception
     */
    public function testWatsonAudioFormatIsRequired(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Audio format string is empty');

        $watson->setAudioFormat('');
    }

    /**
     * @throws Exception
     */
    public function testWatsonAudioFormatIsInvalid(): void
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
    public function testWatsonLanguageIsRequired(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Language string is empty');

        $watson->setLanguage('');
    }

    /**
     * @throws Exception
     */
    public function testWatsonLanguageIsInvalid(): void
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
    public function testWatsonVoiceIsRequired(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Voice string is empty');

        $watson->setVoice('');
    }

    /**
     * @throws Exception
     */
    public function testWatsonVoiceIsInvalid(): void
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
    public function testWatsonOutputPathIsRequired(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Output path is empty');

        $watson->setOutputPath('');
    }

    /**
     * @throws Exception
     */
    public function testWatsonOutputPathIsInvalid(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Unable to create output directory');

        $watson->setOutputPath(sys_get_temp_dir() . '/>greaterthan');
    }

    /**
     * @throws Exception
     */
    public function testWatsonOutputPathCanBeCreated(): void
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
    public function testWatsonTextToSpeechRequiresText(): void
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('No text string provided');

        $watson->runTextToSpeech('');
    }

    /**
     * @throws Exception
     */
    public function testWatsonTextToSpeechRequiresAnOutputPathToBeSet(): void
    {
        $watson = new WatsonTextToSpeech();
        $expected = 'Output path is not set. Please set output path by passing absolute path string to setOutputPath()';

        $this->expectExceptionMessage($expected);

        $watson->runTextToSpeech('No Output');
    }

    /**
     * @throws Exception
     */
    public function testWatsonTextToSpeechRequiresAnAPIKeyToBeSet(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setOutputPath('/public');

        $this->expectExceptionMessage(
            'API key is not set. Please set API key by passing API Key string to setApiKey()'
        );
        $watson->runTextToSpeech('No API Key');
    }

    /**
     * @throws Exception
     */
    public function testWatsonVoiceAndLanguageCombinationMustBeValid(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey('invalid');
        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com');
        $watson->setOutputPath('/public');
        $watson->setLanguage('en-US');
        $watson->setVoice('KateVoice');

        $expected = 'Not a valid language and voice combination. Allowed combinations: ar-AR_OmarVoice, ';
        $expected .= 'de-DE_BirgitV2Voice, de-DE_BirgitV3Voice, de-DE_BirgitVoice, de-DE_DieterV2Voice,';
        $expected .= ' de-DE_DieterV3Voice, de-DE_DieterVoice, de-DE_ErikaV3Voice, en-GB_KateV3Voice, ';
        $expected .= 'en-GB_KateVoice, en-US_AllisonV2Voice, en-US_AllisonV3Voice, en-US_AllisonVoice, ';
        $expected .= 'en-US_EmilyV3Voice, en-US_HenryV3Voice, en-US_KevinV3Voice, en-US_LisaV2Voice, ';
        $expected .= 'en-US_LisaV3Voice, en-US_LisaVoice, en-US_MichaelV2Voice, en-US_MichaelV3Voice, ';
        $expected .= 'en-US_MichaelVoice, en-US_OliviaV3Voice, es-ES_EnriqueV3Voice, es-ES_EnriqueVoice, ';
        $expected .= 'es-ES_LauraV3Voice, es-ES_LauraVoice, es-LA_SofiaV3Voice, es-LA_SofiaVoice, es-US_SofiaV3Voice, ';
        $expected .= 'es-US_SofiaVoice, fr-FR_ReneeV3Voice, fr-FR_ReneeVoice, it-IT_FrancescaV2Voice, ';
        $expected .= 'it-IT_FrancescaV3Voice, it-IT_FrancescaVoice, ja-JP_EmiV3Voice, ja-JP_EmiVoice, ';
        $expected .= 'nl-NL_EmmaVoice, nl-NL_LiamVoice, pt-BR_IsabelaV3Voice, pt-BR_IsabelaVoice, zh-CN_LiNaVoice, ';
        $expected .= 'zh-CN_WangWeiVoice, zh-CN_ZhangJingVoice';

        $this->expectExceptionMessage($expected);

        $watson->runTextToSpeech('Broken Voice and Language combination');
    }

    /**
     * @throws Exception
     */
    public function testWatsonTextToSpeechRequiresTheURLToBeSet(): void
    {
        $watson = new WatsonTextToSpeech();
        $watson->setOutputPath('/public');
        $watson->setApiKey('invalid');

        $this->expectExceptionMessage(
            'Url is not set. Please set Watson URL by passing Url string to setWatsonUrl()'
        );
        $watson->runTextToSpeech('No Url');
    }
}
