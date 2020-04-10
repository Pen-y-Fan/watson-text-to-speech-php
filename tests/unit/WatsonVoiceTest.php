<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\unit;

use Exception;
use PenYFan\WatsonTextToSpeech\WatsonVoice;
use PHPUnit\Framework\TestCase;

class WatsonVoiceTest extends TestCase
{
    public function testCanBeSet(): void
    {
        $firstVoice = new WatsonVoice('BirgitV2Voice');

        $this->assertSame('BirgitV2Voice', $firstVoice->getVoice());

        $lastVoice = new WatsonVoice('ZhangJingVoice');

        $this->assertSame('ZhangJingVoice', $lastVoice->getVoice());

        $midVoice = new WatsonVoice('FrancescaVoice');

        $this->assertSame('FrancescaVoice', $midVoice->getVoice());
    }

    /**
     * @throws Exception
     */
    public function testThrowsExceptionWhenNotSet(): void
    {
        $this->expectExceptionMessage('Voice string is empty');

        new WatsonVoice('');
    }

    /**
     * @throws Exception
     */
    public function testMustBeValidCombination(): void
    {
        $expected = 'Not a valid voice provided. Allowed voices: AllisonV2Voice, AllisonV3Voice, AllisonVoice, ';
        $expected .= 'BirgitV2Voice, BirgitV3Voice, BirgitVoice, DieterV2Voice, DieterV3Voice, DieterVoice, ';
        $expected .= 'EmiV3Voice, EmiVoice, EmilyV3Voice, EmmaVoice, EnriqueV3Voice, EnriqueVoice, ErikaV3Voice, ';
        $expected .= 'FrancescaV2Voice, FrancescaV3Voice, FrancescaVoice, HenryV3Voice, IsabelaV3Voice, IsabelaVoice, ';
        $expected .= 'KateV3Voice, KateVoice, KevinV3Voice, LauraV3Voice, LauraVoice, LiNaVoice, LiamVoice, ';
        $expected .= 'LisaV2Voice, LisaV3Voice, LisaVoice, MichaelV2Voice, MichaelV3Voice, MichaelVoice, ';
        $expected .= 'OliviaV3Voice, OmarVoice, ReneeV3Voice, ReneeVoice, SofiaV3Voice, SofiaVoice, WangWeiVoice, ';
        $expected .= 'ZhangJingVoice';

        $this->expectExceptionMessage($expected);

        new WatsonVoice('uk-UK');
    }
}
