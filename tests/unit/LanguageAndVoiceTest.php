<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\unit;

use Exception;
use Orchestra\Testbench\TestCase;
use PenYFan\WatsonTextToSpeech\LanguageAndVoice;

class LanguageAndVoiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCanBeSet(): void
    {
        $language = new LanguageAndVoice('en-US_AllisonV3Voice');

        $this->assertSame('en-US_AllisonV3Voice', $language->getLanguageAndVoice());
    }

    /**
     * @throws Exception
     */
    public function testThrowsExceptionWhenNotSet(): void
    {
        $this->expectExceptionMessage(
            'LanguageAndVoice is not set. Please set Watson LanguageAndVoice by passing LanguageAndVoice string to setWatsonLanguageAndVoice()'
        );

        new LanguageAndVoice('');
    }

    /**
     * @throws Exception
     */
    public function testMustBeValidCombination(): void
    {
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

        new LanguageAndVoice('de-DE_BirgitV2Voice!!');
    }
}
