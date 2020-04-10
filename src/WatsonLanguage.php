<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech;

use Exception;

class WatsonLanguage
{
    /**
     * @var array
     */
    private $validLanguages = [
        'ar-AR', 'de-DE', 'en-GB', 'en-US', 'es-ES', 'es-LA', 'es-US',
        'fr-FR', 'it-IT', 'ja-JP', 'nl-NL', 'pt-BR', 'zh-CN',
    ];

    /**
     * @var string
     */
    private $language = 'en-US';

    public function __construct(string $language)
    {
        $this->mustBeValidLanguage($language);
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    private function mustBeValidLanguage(string $language): void
    {
        if (! $this->isLanguageSet($language)) {
            throw new Exception('Language string is empty');
        }

        if (! $this->isValidLanguage($language)) {
            throw new Exception('Not a valid language provided. Allowed languages: ' . implode(
                ', ',
                $this->validLanguages
            ));
        }

        $this->language = $language;
    }

    private function isLanguageSet(string $language): bool
    {
        if (empty($language)) {
            return false;
        }
        return true;
    }

    private function isValidLanguage(string $language): bool
    {
        if (! in_array($language, $this->validLanguages, true)) {
            return false;
        }

        return true;
    }
}
