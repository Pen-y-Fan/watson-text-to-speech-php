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
        $file = $watson->runTextToSpeech('Working');

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

        $file = $watson->runTextToSpeech('W.A.V.');

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

        $file = $watson->runTextToSpeech('British');

        $this->assertStringStartsWith('/public', $file);
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonTextToSpeechCanSetAudioLanguageAndVoice()
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(Secret::API_KEY);
        $watson->setOutputPath('/public');
        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com');

        $file = $watson->runTextToSpeech('français', 'wav', 'fr-FR', 'ReneeV3Voice');

        $this->assertStringStartsWith('/public/', $file);
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonUrlIsRequired()
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Watson URL not provided');

        $watson->setWatsonUrl('');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonUrlIsInvalid()
    {
        $watson = new WatsonTextToSpeech();

        $expected = 'Not a valid Watson URL. Allowed URLs: ';
        $expected .= 'https://api.au-syd.text-to-speech.watson.cloud.ibm.com ';
        $expected .= 'https://api.eu-gb.text-to-speech.watson.cloud.ibm.com ';
        $expected .= 'https://api.eu-de.text-to-speech.watson.cloud.ibm.com ';
        $expected .= 'https://api.jp-tok.text-to-speech.watson.cloud.ibm.com ';
        $expected .= 'https://api.kr-seo.text-to-speech.watson.cloud.ibm.com ';
        $expected .= 'https://api.us-east.text-to-speech.watson.cloud.ibm.com ';
        $expected .= 'https://api.us-south.text-to-speech.watson.cloud.ibm.com';

        $this->expectExceptionMessage($expected);

        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonApiKeyIsRequired()
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Watson API key not provided');

        $watson->setApiKey('');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonAudioFormatIsRequired()
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Audio format string is empty');

        $watson->setAudioFormat('');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonAudioFormatIsInvalid()
    {
        $watson = new WatsonTextToSpeech();
        $expected = 'Not a valid audio format. Allowed formats: basic flac l16 ogg ogg;codecs=opus ogg;codecs=vorbis ';
        $expected .= 'mp3 mpeg mulaw wav webm webm;codecs=opus webm;codecs=vorbi';

        $this->expectExceptionMessage($expected);

        $watson->setAudioFormat('mp4');
    }

    // setLanguage

    /**
     * @test
     * @throws Exception
     */
    public function watsonLanguageIsRequired()
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Language string is empty');

        $watson->setLanguage('');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonLanguageIsInvalid()
    {
        $watson = new WatsonTextToSpeech();
        $expected = 'Not a valid language provided. Allowed languages: ';
        $expected .= 'ar-AR de-DE en-GB en-US es-ES es-LA es-US ';
        $expected .= 'fr-FR it-IT ja-JP nl-NL pt-BR zh-CN';
        $this->expectExceptionMessage($expected);

        $watson->setLanguage('uk-UK');
    }

    // setVoice

    /**
     * @test
     * @throws Exception
     */
    public function watsonVoiceIsRequired()
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Voice string is empty');

        $watson->setVoice('');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonVoiceIsInvalid()
    {
        $watson = new WatsonTextToSpeech();
        $expected = 'Not a valid voice provided. Allowed voices: AllisonV2Voice AllisonV3Voice AllisonVoice ';
        $expected .= 'BirgitV2Voice BirgitV3Voice BirgitVoice DieterV2Voice DieterV3Voice DieterVoice EmiV3Voice ';
        $expected .= 'EmiVoice EmilyV3Voice EmmaVoice EnriqueV3Voice EnriqueVoice ErikaV3Voice FrancescaV2Voice ';
        $expected .= 'FrancescaV3Voice FrancescaVoice HenryV3Voice IsabelaV3Voice IsabelaVoice KateV3Voice KateVoice ';
        $expected .= 'KevinV3Voice LauraV3Voice LauraVoice LiNaVoice LiamVoice LisaV2Voice LisaV3Voice LisaVoice ';
        $expected .= 'MichaelV2Voice MichaelV3Voice MichaelVoice OliviaV3Voice OmarVoice ReneeV3Voice ReneeVoice ';
        $expected .= 'SofiaV3Voice SofiaVoice WangWeiVoice ZhangJingVoice';

        $this->expectExceptionMessage($expected);

        $watson->setVoice('uk-UK');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonOutputPathIsRequired()
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Output path is empty');

        $watson->setOutputPath('');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonOutputPathIsInvalid()
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('Unable to create output directory');

        $watson->setOutputPath(sys_get_temp_dir() . '/>greaterthan');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonOutputPathCanBeCreated()
    {
        $path = sys_get_temp_dir() . '/' . random_int(1000, 9999);

        $watson = new WatsonTextToSpeech();
        $watson->setOutputPath($path);

        $this->assertDirectoryExists($path);

        rmdir($path);
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonTextToSpeechRequiresText()
    {
        $watson = new WatsonTextToSpeech();
        $this->expectExceptionMessage('No text string provided');

        $watson->runTextToSpeech('');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonTextToSpeechRequiresAnOutputPathToBeSet()
    {
        $watson = new WatsonTextToSpeech();
        $expected = 'Output path is not set. Please set output path by passing absolute path string to setOutputPath()';

        $this->expectExceptionMessage($expected);

        $watson->runTextToSpeech('No Output');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonTextToSpeechRequiresAnAPIKeyToBeSet()
    {
        $watson = new WatsonTextToSpeech();
        $watson->setOutputPath('/public');

        $this->expectExceptionMessage('API key is not set. Please set API key by passing API Key string to setApiKey()');
        $watson->runTextToSpeech('No API Key');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonTextToSpeechRequiresTheURLToBeSet()
    {
        $watson = new WatsonTextToSpeech();
        $watson->setOutputPath('/public');
        $watson->setApiKey(Secret::API_KEY);

        $this->expectExceptionMessage('Url is not set. Please set Watson URL by passing Url string to setWatsonUrl()');
        $watson->runTextToSpeech('No Url');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonApiKeyMustBeValid()
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(Secret::API_KEY . 'invalid');
        $watson->setWatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com');

        $path = '/public';
        $watson->setOutputPath($path);
        $this->expectExceptionMessage('Error:Unauthorized code: 401');

        $watson->runTextToSpeech('Broken APIi');
    }

    /**
     * @test
     * @throws Exception
     */
    public function watsonVoiceAndLanguageCombinationMustBeValid()
    {
        $watson = new WatsonTextToSpeech();
        $watson->setApiKey(Secret::API_KEY . 'invalid');
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

}
