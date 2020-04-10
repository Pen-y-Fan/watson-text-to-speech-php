<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\unit;

use Exception;
use PenYFan\WatsonTextToSpeech\WatsonLanguage;
use PHPUnit\Framework\TestCase;

class WatsonLanguageTest extends TestCase
{
    public function testCanBeSet(): void
    {
        $firstLanguage = new WatsonLanguage('ar-AR');

        $this->assertSame('ar-AR', $firstLanguage->getLanguage());

        $lastLanguage = new WatsonLanguage('zh-CN');

        $this->assertSame('zh-CN', $lastLanguage->getLanguage());

        $midLanguage = new WatsonLanguage('es-US');

        $this->assertSame('es-US', $midLanguage->getLanguage());
    }

    /**
     * @throws Exception
     */
    public function testThrowsExceptionWhenNotSet(): void
    {
        $this->expectExceptionMessage('Language string is empty');

        new WatsonLanguage('');
    }

    /**
     * @throws Exception
     */
    public function testMustBeValidCombination(): void
    {
        $expected = 'Not a valid language provided. Allowed languages: ';
        $expected .= 'ar-AR, de-DE, en-GB, en-US, es-ES, es-LA, es-US, ';
        $expected .= 'fr-FR, it-IT, ja-JP, nl-NL, pt-BR, zh-CN';

        $this->expectExceptionMessage($expected);

        new WatsonLanguage('uk-UK');
    }
}
