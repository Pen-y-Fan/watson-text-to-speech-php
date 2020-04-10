<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech;

use Exception;

class WatsonApiKey
{
    /**
     * @var string
     */
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->mustBeValidApiKey($apiKey);
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    private function mustBeValidApiKey(string $apiKey): void
    {
        if (! $this->isApiKeySet($apiKey)) {
            throw new Exception('Watson API key not provided');
        }

        $this->apiKey = $apiKey;
    }

    private function isApiKeySet(string $apiKey): bool
    {
        if (empty($apiKey)) {
            return false;
        }
        return true;
    }
}
