<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech;

use Exception;
use PenYFan\WatsonTextToSpeech\Client\WatsonClient;
use Throwable;

class WatsonTextToSpeech
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var WatsonUrl
     */
    private $watsonUrl;

    /**
     * @var WatsonApiKey
     */
    private $watsonApiKey;

    /**
     * @var WatsonLanguage
     */
    private $watsonLanguage;

    /**
     * @var WatsonVoice
     */
    private $watsonVoice;

    /**
     * @var WatsonOutputPath
     */
    private $watsonOutputPath;

    /**
     * @var WatsonLanguageAndVoice
     */
    private $watsonLanguageAndVoice;

    /**
     * @var WatsonAudioFormat
     */
    private $watsonAudioFormat;

    public function __construct()
    {
        $this->watsonLanguage = new WatsonLanguage('en-US');
        $this->watsonAudioFormat = new WatsonAudioFormat('mp3');
        $this->watsonVoice = new WatsonVoice('MichaelVoice');

        // config is a Laravel function containing the config from the .env file. Call setup from Laravel app.
        if (is_callable('config')) {
            $this->setupWatsonFromEnv();
        }
    }

    /**
     * set watson url
     * The url can be in the format:
     * https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/v1/synthesize/
     * https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/v1/synthesize
     * https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/
     * https://api.eu-gb.text-to-speech.watson.cloud.ibm.com
     *
     * @throws Exception
     */
    public function setUrl(string $url): self
    {
        $this->watsonUrl = new WatsonUrl($url);
        return $this;
    }

    /**
     * Set watson API key
     *
     * @throws Exception
     */
    public function setApiKey(string $apiKey): self
    {
        $this->watsonApiKey = new WatsonApiKey($apiKey);
        return $this;
    }

    /**
     * Set audio format,
     * default: mp3
     *
     * @throws Exception
     */
    public function setAudioFormat(string $format): self
    {
        $this->watsonAudioFormat = new WatsonAudioFormat($format);
        return $this;
    }

    /**
     * Set language of audio,
     * default: 'en-US'
     *
     * @throws Exception
     */
    public function setLanguage(string $language): self
    {
        $this->watsonLanguage = new WatsonLanguage($language);
        return $this;
    }

    /**
     * set voice,
     * default:'MichaelVoice'
     *
     * @throws Exception
     */
    public function setVoice(string $voice): self
    {
        $this->watsonVoice = new WatsonVoice($voice);
        return $this;
    }

    /**
     * set output path
     *
     * @throws Exception
     */
    public function setOutputPath(string $outputPath): self
    {
        $this->watsonOutputPath = new WatsonOutputPath($outputPath);
        return $this;
    }

    /**
     * Language and Voice and be set all three properties $languageAndVoice, $language and $voice
     * If no parameter is received it is assumed languageAndVoice needs to be set based on the properties
     * $language and $voice
     *
     * @throws Exception
     */
    public function setLanguageAndVoice(?string $languageAndVoice = ''): self
    {
        if (empty($languageAndVoice)) {
            $this->watsonLanguageAndVoice = new WatsonLanguageAndVoice(
                $this->watsonLanguage->getLanguage() . '_' . $this->watsonVoice->getVoice()
            );
            return $this;
        }

        $this->watsonLanguageAndVoice = new WatsonLanguageAndVoice($languageAndVoice);

        $this->setLanguage(substr($this->watsonLanguageAndVoice->getLanguageAndVoice(), 0, 5));
        $this->setVoice(substr($this->watsonLanguageAndVoice->getLanguageAndVoice(), 6));
        return $this;
    }

    /**
     * text to speech serializer
     *
     * @throws Exception
     */
    public function runTextToSpeech(
        string $text,
        ?string $format = '',
        ?string $language = '',
        ?string $voice = ''
    ): string {
        if (empty($text)) {
            throw new Exception('No text string provided');
        }

        $this->text = $text;

        try {
            $this->checkMinimumParametersSet();
            $this->setOptionalParamaters($format, $language, $voice);
            return $this->processWatsonTextToSpeech();
        } catch (Throwable $throwable) {
            throw new Exception($throwable->getMessage());
        }
    }

    /**
     * Setup Watsson based on .env file
     */
    private function setupWatsonFromEnv(): void
    {
        $watsonKeysToMethods = [
            'key' => 'setApiKey',
            'url' => 'setUrl',
            'name' => 'setLanguageAndVoice',
            'path' => 'setOutputPath',
        ];

        foreach ($watsonKeysToMethods as $key => $method) {
            if (config('config.watsonApi.' . $key)) {
                $this->{$method}((string) config('config.watsonApi.' . $key));
            }
        }
    }

    /**
     * Check the minimum set of required parameters have been set before Watson is run.
     *
     * @throws Exception
     */
    private function checkMinimumParametersSet(): void
    {
        if (empty($this->watsonOutputPath)) {
            throw new Exception(
                'Output path is not set. Please set an output path by passing absolute path string to setOutputPath()'
            );
        }

        if (empty($this->watsonApiKey)) {
            throw new Exception('API key is not set. Please set API key by passing API Key string to setApiKey()');
        }

        if (empty($this->watsonUrl)) {
            throw new Exception('Url is not set. Please set Watson URL by passing Url string to setWatsonUrl()');
        }

        $this->setLanguageAndVoice();
    }

    /**
     * Set the optional parameters before Watson is run.
     *
     * @throws Exception
     */
    private function setOptionalParamaters(?string $format = '', ?string $language = '', ?string $voice = ''): void
    {
        if (! empty($format)) {
            $this->setAudioFormat($format);
        }

        if (! empty($language)) {
            $this->setLanguage($language);
        }

        if (! empty($voice)) {
            $this->setVoice($voice);
        }
    }

    /**
     * process watson curl script
     *
     * @throws Exception
     */
    private function processWatsonTextToSpeech(): string
    {
        $client = new WatsonClient(
            $this->watsonApiKey,
            $this->watsonAudioFormat,
            $this->watsonLanguageAndVoice,
            $this->watsonUrl,
            $this->watsonOutputPath
        );
        return $client->getWatsonSpeech($this->text);
    }
}
