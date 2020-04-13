<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\unit;

use Exception;
use Orchestra\Testbench\TestCase;
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeech;
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeechServiceProvider;

class AppTest extends TestCase
{
    /**
     * @var string
     */
    private $apiKey = '';

    protected function setUp(): void
    {
        parent::setUp();

        $env = [];
        $file = '.env';

        try {
            $env = parse_ini_file(__DIR__ . '/../../' . $file);
        } catch (Exception $exception) {
            $this->markTestSkipped(
                'Skipped: The ' . $file . ' file is not available: ' . realpath(
                    __DIR__ . '/../../'
                ) . DIRECTORY_SEPARATOR . $file
            );
        }

        if ($env === false) {
            $env = ['WATSON_API_KEY' => ''];
        }

        $this->setConfig($env);

        if (! defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }
    }

    public function testEnvToConfigIsSet(): void
    {
        $this->assertSame($this->apiKey, config('config.watsonApi.key'), 'WATSON_API_KEY is not set');
        $this->assertSame(
            'https://api.eu-gb.text-to-speech.watson.cloud.ibm.com',
            config('config.watsonApi.url'),
            'WATSON_API_PATH is not set'
        );
        $this->assertSame('./storage/watson-api', config('config.watsonApi.path'), 'WATSON_API_URL is not set');
        $this->assertSame('en-US_MichaelVoice', config('config.watsonApi.name'), 'WATSON_API_NAME is not set');
    }

    /**
     * @throws Exception
     */
    public function testEnvIsLoadedByWatson(): void
    {
        $watson = new WatsonTextToSpeech();

        $this->expectExceptionMessage('No text string provided');
        $watson->runTextToSpeech('');
    }

    public function testEnvUrlMustBeValid(): void
    {
        $key = 'url';
        $this->app['config']->set('config.watsonApi.' . $key, config('config.watsonApi.' . $key) . ' invalid');

        $expected = 'Not a valid Watson URL. Allowed URLs: ';
        $expected .= 'https://api.au-syd.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.eu-gb.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.eu-de.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.jp-tok.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.kr-seo.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.us-east.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.us-south.text-to-speech.watson.cloud.ibm.com';

        $this->expectExceptionMessage($expected);
        new WatsonTextToSpeech();
    }

    /**
     * @requires OSFAMILY Windows
     */
    public function testOutputPathIsInvalid(): void
    {
        $key = 'path';
        $this->app['config']->set('config.watsonApi.' . $key, '/>greaterthan');

        $this->expectExceptionMessage('Unable to create output directory');

        new WatsonTextToSpeech();
    }

    public function testEnvNameMustBeValid(): void
    {
        $key = 'name';
        $this->app['config']->set('config.watsonApi.' . $key, 'invalid');

        $expected = 'Not a valid language and voice combination. Allowed combinations: ar-AR_OmarVoice, ';
        $expected .= 'de-DE_BirgitV2Voice, de-DE_BirgitV3Voice, de-DE_BirgitVoice, de-DE_DieterV2Voice, ';
        $expected .= 'de-DE_DieterV3Voice, de-DE_DieterVoice, de-DE_ErikaV3Voice, en-GB_KateV3Voice, ';
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

        new WatsonTextToSpeech();
    }

    protected function getPackageProviders($app)
    {
        return [WatsonTextToSpeechServiceProvider::class];
    }

    protected function setConfig(array $env): void
    {
        $keys = ['KEY', 'URL', 'PATH', 'NAME'];

        foreach ($keys as $key) {
            if (isset($env['WATSON_API_' . $key])) {
                if ($key === 'KEY') {
                    $this->apiKey = $env['WATSON_API_KEY'];
                }
                $this->app['config']->set('config.watsonApi.' . strtolower($key), $env['WATSON_API_' . $key]);
            }
        }
    }
}
