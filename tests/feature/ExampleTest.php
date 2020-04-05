<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\feature;

use Orchestra\Testbench\TestCase;
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeechServiceProvider;

class ExampleTest extends TestCase
{
    public function testTrueIsTrue(): void
    {
        $this->assertTrue(true);
    }

    protected function getPackageProviders($app)
    {
        return [WatsonTextToSpeechServiceProvider::class];
    }
}