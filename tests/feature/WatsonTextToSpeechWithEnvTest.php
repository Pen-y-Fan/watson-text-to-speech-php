<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\feature;

use Exception;
use Orchestra\Testbench\TestCase;
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeech;

class WatsonTextToSpeechWithEnvTest extends TestCase
{
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
            $this->markTestSkipped(
                'Skipped: There was a problem parsing file: ' . $file . PHP_EOL
                . 'The file can be opened, but has an error: ' . realpath(
                    __DIR__ . '/../../'
                ) . DIRECTORY_SEPARATOR . $file
            );
        }

        if (! isset($env['WATSON_API_KEY'])) {
            $this->markTestSkipped(
                'Skipped: The .env file does not contain WATSON_API_KEY' . PHP_EOL
                . 'The file can be opened, but does not contain a set WATSON_API_KEY key: ' . realpath(
                    __DIR__ . '/../../'
                ) . DIRECTORY_SEPARATOR . $file
            );
        }

        $this->setConfig($env);

        if (! defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }
    }

    /**
     * @throws Exception
     */
    public function testWatsonCanSpeakWithValuesFromEnv(): void
    {
        $watson = new WatsonTextToSpeech();
        $file = $watson->setApiKey((string) config('config.watsonApi.key'))
            ->setUrl((string) config('config.watsonApi.url'))
            ->setLanguageAndVoice((string) config('config.watsonApi.name'))
            ->setOutputPath((string) config('config.watsonApi.path'))
            ->runTextToSpeech('Env working');

        $this->assertStringStartsWith((string) config('config.watsonApi.path'), $file);
    }

    /**
     * @throws Exception
     */
    public function testWatsonCanSpeakWithDefaultValuesFromEnv(): void
    {
        $watson = new WatsonTextToSpeech();

        $file = $watson->runTextToSpeech('Defaults working');

        $this->assertStringStartsWith((string) config('config.watsonApi.path'), $file);
    }

    protected function setConfig(array $env): void
    {
        $keys = ['KEY', 'URL', 'PATH', 'NAME'];

        foreach ($keys as $key) {
            if (isset($env['WATSON_API_' . $key])) {
                $this->app['config']->set('config.watsonApi.' . strtolower($key), $env['WATSON_API_' . $key]);
            }
        }
    }
}
