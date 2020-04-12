<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\unit;

use Exception;
use Orchestra\Testbench\TestCase;
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeechServiceProvider;

class ConfigTest extends TestCase
{
    /**
     * @var string
     */
    private $apiKey = '';

    protected function setUp(): void
    {
        parent::setUp();

        $env = [];

        try {
            $env = parse_ini_file(__DIR__ . '/../../.env.example');
        } catch (Exception $exception) {
            $this->markTestSkipped(
                'The .env.example file is not available: ' . realpath(
                    __DIR__ . '/../../'
                ) . DIRECTORY_SEPARATOR . '.env.example' . ' Exception: '
            );
        }

        if ($env === false) {
            $env = [
                'WATSON_API_KEY' => '',
                'WATSON_API_PATH' => '',
                'WATSON_API_URL' => '',
                'WATSON_API_NAME' => '',
            ];
        }

        if (isset($env['WATSON_API_KEY'])) {
            $this->apiKey = $env['WATSON_API_KEY'];
            $this->app['config']->set('config.watsonApi.key', $env['WATSON_API_KEY']);
        }

        if (isset($env['WATSON_API_PATH'])) {
            $this->app['config']->set('config.watsonApi.path', $env['WATSON_API_PATH']);
        }

        if (isset($env['WATSON_API_URL'])) {
            $this->app['config']->set('config.watsonApi.url', $env['WATSON_API_URL']);
        }

        if (isset($env['WATSON_API_NAME'])) {
            $this->app['config']->set('config.watsonApi.name', $env['WATSON_API_NAME']);
        }

        if (! defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }
    }

    public function testConfigFileCanBeRead(): void
    {
        // WATSON_API_KEY should not normally be set in the .env.example file
        if ($this->apiKey) {
            $this->assertSame($this->apiKey, config('config.watsonApi.key'), 'WATSON_API_KEY is not set');
        }
        $this->assertSame(
            'https://api.eu-gb.text-to-speech.watson.cloud.ibm.com',
            config('config.watsonApi.url'),
            'WATSON_API_PATH is not set'
        );
        $this->assertSame('./storage/watson-api', config('config.watsonApi.path'), 'WATSON_API_URL is not set');
        $this->assertSame('en-US_MichaelVoice', config('config.watsonApi.name'), 'WATSON_API_NAME is not set');
    }

    public function testConfigFileCanBeUpdated(): void
    {
        $testName = 'en-US_LisaVoice';

        $this->app['config']->set('config.watsonApi.name', $testName);

        $this->assertNotSame('en-US_MichaelVoice', $testName, 'WATSON_API_NAME should be different to ' . $testName);
        $this->assertSame($testName, config('config.watsonApi.name'), 'WATSON_API_NAME can not be set');
    }

    protected function getPackageProviders($app)
    {
        return [WatsonTextToSpeechServiceProvider::class];
    }
}
