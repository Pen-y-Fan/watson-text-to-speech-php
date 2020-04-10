<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\unit;

use Exception;
use PenYFan\WatsonTextToSpeech\WatsonUrl;
use PHPUnit\Framework\TestCase;

class WatsonUrlTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCanBeSet(): void
    {
        $auSydUrl = new WatsonUrl('https://api.au-syd.text-to-speech.watson.cloud.ibm.com');

        $this->assertSame('https://api.au-syd.text-to-speech.watson.cloud.ibm.com', $auSydUrl->getUrl());

        $usSouthUrl = new WatsonUrl('https://api.us-south.text-to-speech.watson.cloud.ibm.com/');

        $this->assertSame('https://api.us-south.text-to-speech.watson.cloud.ibm.com', $usSouthUrl->getUrl());

        $euGbUrl = new WatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/v1/synthesize/');

        $this->assertSame('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com', $euGbUrl->getUrl());
    }

    /**
     * @throws Exception
     */
    public function testThrowsExceptionWhenNotSet(): void
    {
        $this->expectExceptionMessage(
            'Url is not set. Please set Watson URL by passing Url string to setWatsonUrl()'
        );

        new WatsonUrl('');
    }

    /**
     * @throws Exception
     */
    public function testMustBeValidCombination(): void
    {
        $expected = 'Not a valid Watson URL. Allowed URLs: ';
        $expected .= 'https://api.au-syd.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.eu-gb.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.eu-de.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.jp-tok.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.kr-seo.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.us-east.text-to-speech.watson.cloud.ibm.com, ';
        $expected .= 'https://api.us-south.text-to-speech.watson.cloud.ibm.com';

        $this->expectExceptionMessage($expected);

        new WatsonUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm');
    }
}
