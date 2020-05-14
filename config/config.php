<?php

declare(strict_types=1);

/*
 * Configuration for Watson API. Any values in .env file will overwrite the defaults.
 */
return [
    'watsonApi' => [
        'key' => env('WATSON_API_KEY'),
        'path' => env('WATSON_API_PATH', 'storage/watson-api'),
        'url' => env('WATSON_API_URL', 'https://api.us-south.text-to-speech.watson.cloud.ibm.com'),
        'name' => env('WATSON_API_NAME', 'en-US_MichaelVoice'),
    ],
    'debug_blacklist' => [
        '_ENV' => ['WATSON_API_KEY'],

        '_SERVER' => ['WATSON_API_KEY'],

        '_POST' => ['watson-api-key', 'watson-apikey'],
    ],
];
