<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech;

use Exception;

class WatsonUrl
{
    /**
     * @var array
     */
    private $validUrls = [
        'https://api.au-syd.text-to-speech.watson.cloud.ibm.com',
        'https://api.eu-gb.text-to-speech.watson.cloud.ibm.com',
        'https://api.eu-de.text-to-speech.watson.cloud.ibm.com',
        'https://api.jp-tok.text-to-speech.watson.cloud.ibm.com',
        'https://api.kr-seo.text-to-speech.watson.cloud.ibm.com',
        'https://api.us-east.text-to-speech.watson.cloud.ibm.com',
        'https://api.us-south.text-to-speech.watson.cloud.ibm.com',
    ];

    /**
     * @var string
     */
    private $url;

    public function __construct(string $url)
    {
        $this->mustBeValidUrl($url);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    private function mustBeValidUrl(string $url): void
    {
        if (! $this->isUrlSet($url)) {
            throw new Exception('Url is not set. Please set Watson URL by passing Url string to setWatsonUrl()');
        }

        $trimUrl = rtrim($url, '/');
        $trimUrl = rtrim($trimUrl, '/v1/synthesize');

        if (! $this->isValidUrl($trimUrl)) {
            throw new Exception('Not a valid Watson URL. Allowed URLs: ' . implode(', ', $this->validUrls));
        }

        $this->url = $trimUrl;
    }

    private function isUrlSet(string $url): bool
    {
        if (empty($url)) {
            return false;
        }
        return true;
    }

    private function isValidUrl(string $url): bool
    {
        if (! in_array($url, $this->validUrls, true)) {
            return false;
        }

        return true;
    }
}
