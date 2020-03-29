<?php

namespace PenYFan\WatsonTextToSpeech;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PenYFan\WatsonTextToSpeech\Skeleton\SkeletonClass
 */
class WatsonTextToSpeechFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'watson-text-to-speech-php';
    }
}
