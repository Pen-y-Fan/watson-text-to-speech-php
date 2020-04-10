<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech;

use Exception;

class WatsonVoice
{
    /**
     * @var array
     */
    private $validVoices = [
        'AllisonV2Voice', 'AllisonV3Voice', 'AllisonVoice', 'BirgitV2Voice', 'BirgitV3Voice', 'BirgitVoice',
        'DieterV2Voice', 'DieterV3Voice', 'DieterVoice', 'EmiV3Voice', 'EmiVoice', 'EmilyV3Voice', 'EmmaVoice',
        'EnriqueV3Voice', 'EnriqueVoice', 'ErikaV3Voice', 'FrancescaV2Voice', 'FrancescaV3Voice', 'FrancescaVoice',
        'HenryV3Voice', 'IsabelaV3Voice', 'IsabelaVoice', 'KateV3Voice', 'KateVoice', 'KevinV3Voice', 'LauraV3Voice',
        'LauraVoice', 'LiNaVoice', 'LiamVoice', 'LisaV2Voice', 'LisaV3Voice', 'LisaVoice', 'MichaelV2Voice',
        'MichaelV3Voice', 'MichaelVoice', 'OliviaV3Voice', 'OmarVoice', 'ReneeV3Voice', 'ReneeVoice', 'SofiaV3Voice',
        'SofiaVoice', 'WangWeiVoice', 'ZhangJingVoice',
    ];

    /**
     * @var string
     */
    private $voice;

    public function __construct(string $voice)
    {
        $this->mustBeValidVoice($voice);
    }

    public function getVoice(): string
    {
        return $this->voice;
    }

    private function mustBeValidVoice(string $voice): void
    {
        if (! $this->isVoiceSet($voice)) {
            throw new Exception('Voice string is empty');
        }

        if (! $this->isValidVoice($voice)) {
            throw new Exception('Not a valid voice provided. Allowed voices: ' . implode(', ', $this->validVoices));
        }

        $this->voice = $voice;
    }

    private function isVoiceSet(string $voice): bool
    {
        if (empty($voice)) {
            return false;
        }
        return true;
    }

    private function isValidVoice(string $voice): bool
    {
        if (! in_array($voice, $this->validVoices, true)) {
            return false;
        }

        return true;
    }
}
