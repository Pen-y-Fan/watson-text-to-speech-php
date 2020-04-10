<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech;

class WatsonFileExtension
{
    /**
     * @var string
     */
    private $fileExtension;

    public function __construct(WatsonAudioFormat $watsonAudioFormat)
    {
        $this->setValidFileExtension($watsonAudioFormat->getAudioFormat());
    }

    public function getFileExtension(): string
    {
        return $this->fileExtension;
    }

    private function setValidFileExtension(string $audioFormat): void
    {
        $pos = strpos($audioFormat, ';');
        if ($pos !== false) {
            $this->fileExtension = substr($audioFormat, 0, $pos);
            return;
        }

        $this->fileExtension = $audioFormat;
    }
}
