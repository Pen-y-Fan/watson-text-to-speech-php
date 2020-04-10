<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech;

use Exception;

class WatsonAudioFormat
{
    /**
     * @var array
     */
    private $validAudioFormats = [
        'basic', 'flac', 'l16', 'ogg', 'ogg;codecs=opus', 'ogg;codecs=vorbis', 'mp3',
        'mpeg', 'mulaw', 'wav', 'webm', 'webm;codecs=opus', 'webm;codecs=vorbi', ];

    /**
     * @var string
     */
    private $audioFormat;

    public function __construct(string $audioFormat)
    {
        $this->mustBeValidAudioFormat($audioFormat);
    }

    public function getAudioFormat(): string
    {
        return $this->audioFormat;
    }

    private function mustBeValidAudioFormat(string $audioFormat): void
    {
        if (! $this->isAudioFormatSet($audioFormat)) {
            throw new Exception('Audio format string is empty');
        }

        if (! $this->isValidAudioFormat($audioFormat)) {
            throw new Exception('Not a valid audio format. Allowed formats: ' . implode(
                ', ',
                $this->validAudioFormats
            ));
        }

        $this->audioFormat = $audioFormat;
    }

    private function isAudioFormatSet(string $audioFormat): bool
    {
        if (empty($audioFormat)) {
            return false;
        }
        return true;
    }

    private function isValidAudioFormat(string $audioFormat): bool
    {
        if (! in_array($audioFormat, $this->validAudioFormats, true)) {
            return false;
        }

        return true;
    }
}
