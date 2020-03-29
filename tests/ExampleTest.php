<?php

namespace PenYFan\WatsonTextToSpeechPhp\Tests;

use Orchestra\Testbench\TestCase;
use PenYFan\WatsonTextToSpeechPhp\WatsonTextToSpeechPhpServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [WatsonTextToSpeechPhpServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
