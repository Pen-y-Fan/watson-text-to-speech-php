<?php

namespace PenYFan\WatsonTextToSpeechPhp;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PenYFan\WatsonTextToSpeechPhp\Skeleton\SkeletonClass
 */
class WatsonTextToSpeechPhpFacade extends Facade
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
