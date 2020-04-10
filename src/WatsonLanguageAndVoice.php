<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech;

use Exception;

class WatsonLanguageAndVoice
{
    /**
     * @var array
     */
    private $validLanguagesAndVoices = [
        'ar-AR_OmarVoice', 'de-DE_BirgitV2Voice', 'de-DE_BirgitV3Voice', 'de-DE_BirgitVoice', 'de-DE_DieterV2Voice',
        'de-DE_DieterV3Voice', 'de-DE_DieterVoice', 'de-DE_ErikaV3Voice', 'en-GB_KateV3Voice', 'en-GB_KateVoice',
        'en-US_AllisonV2Voice', 'en-US_AllisonV3Voice', 'en-US_AllisonVoice', 'en-US_EmilyV3Voice',
        'en-US_HenryV3Voice', 'en-US_KevinV3Voice', 'en-US_LisaV2Voice', 'en-US_LisaV3Voice', 'en-US_LisaVoice',

        'en-US_MichaelV2Voice', 'en-US_MichaelV3Voice', 'en-US_MichaelVoice', 'en-US_OliviaV3Voice',
        'es-ES_EnriqueV3Voice', 'es-ES_EnriqueVoice', 'es-ES_LauraV3Voice', 'es-ES_LauraVoice',
        'es-LA_SofiaV3Voice', 'es-LA_SofiaVoice', 'es-US_SofiaV3Voice', 'es-US_SofiaVoice', 'fr-FR_ReneeV3Voice',
        'fr-FR_ReneeVoice', 'it-IT_FrancescaV2Voice', 'it-IT_FrancescaV3Voice', 'it-IT_FrancescaVoice',
        'ja-JP_EmiV3Voice', 'ja-JP_EmiVoice', 'nl-NL_EmmaVoice', 'nl-NL_LiamVoice', 'pt-BR_IsabelaV3Voice',
        'pt-BR_IsabelaVoice', 'zh-CN_LiNaVoice', 'zh-CN_WangWeiVoice', 'zh-CN_ZhangJingVoice',
    ];

    /**
     * @var string
     */
    private $languageAndVoice;

    /**
     * WatsonLanguageAndVoice constructor.
     */
    public function __construct(string $languageAndVoice)
    {
        $this->mustBeValidLanguageAndVoice($languageAndVoice);
    }

    public function getLanguageAndVoice(): string
    {
        return $this->languageAndVoice;
    }

    private function mustBeValidLanguageAndVoice(string $languageAndVoice): void
    {
        if (! $this->isLanguageAndVoiceSet($languageAndVoice)) {
            throw new Exception(
                'WatsonLanguageAndVoice is not set. Please set Watson WatsonLanguageAndVoice by passing WatsonLanguageAndVoice string to setWatsonLanguageAndVoice()'
            );
        }

        if (! $this->isValidLanguageAndVoice($languageAndVoice)) {
            throw new Exception('Not a valid language and voice combination. Allowed combinations: ' . implode(
                ', ',
                $this->validLanguagesAndVoices
            ));
        }

        $this->languageAndVoice = $languageAndVoice;
    }

    private function isLanguageAndVoiceSet(string $languageAndVoice): bool
    {
        if (empty($languageAndVoice)) {
            return false;
        }
        return true;
    }

    private function isValidLanguageAndVoice(string $languageAndVoice): bool
    {
        if (! in_array($languageAndVoice, $this->validLanguagesAndVoices, true)) {
            return false;
        }

        return true;
    }
}
