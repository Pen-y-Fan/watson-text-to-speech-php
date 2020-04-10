<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\unit;

use Exception;
use PenYFan\WatsonTextToSpeech\WatsonApiKey;
use PHPUnit\Framework\TestCase;

class WatsonApiKeyTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCanBeSet(): void
    {
        $apiKey = new WatsonApiKey('yourAPIkeyFromIBM');

        $this->assertSame('yourAPIkeyFromIBM', $apiKey->getApiKey());
    }

    /**
     * @throws Exception
     */
    public function testThrowsExceptionWhenNotSet(): void
    {
        $this->expectExceptionMessage('Watson API key not provided');

        new WatsonApiKey('');
    }
}
