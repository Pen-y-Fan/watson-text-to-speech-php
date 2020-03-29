<?php

namespace PenYFan\WatsonTextToSpeech\Tests;

use Orchestra\Testbench\TestCase;
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeechServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [WatsonTextToSpeechServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
