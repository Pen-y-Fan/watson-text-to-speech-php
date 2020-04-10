<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Client;

use Exception;
use PenYFan\WatsonTextToSpeech\LanguageAndVoice;
use PenYFan\WatsonTextToSpeech\WatsonApiKey;
use PenYFan\WatsonTextToSpeech\WatsonAudioFormat;
use PenYFan\WatsonTextToSpeech\WatsonUrl;

class WatsonClient
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $audioFormat;

    /**
     * @var string
     */
    private $languageAndVoice;

    /**
     * @var string
     */
    private $watsonUrl;

    /**
     * @var string
     */
    private $outputFilePath;

    public function __construct(
        WatsonApiKey $watsonApiKey,
        WatsonAudioFormat $watsonAudioFormat,
        LanguageAndVoice $languageAndVoice,
        WatsonUrl $watsonUrl,
        string $fullFilePath
    ) {
        $this->apiKey = $watsonApiKey->getApiKey();
        $this->audioFormat = $watsonAudioFormat->getAudioFormat();
        $this->languageAndVoice = $languageAndVoice->getLanguageAndVoice();
        $this->watsonUrl = $watsonUrl->getUrl();
        $this->outputFilePath = $fullFilePath;
    }

    /**
     * @throws Exception
     */
    public function getWatsonSpeech(string $text): string
    {
        $outputFile = fopen($this->outputFilePath, 'w');

        if ($outputFile === false) {
            throw new Exception('There was a problem creating the file : ' . $this->outputFilePath);
        }

        $textJson = json_encode(['text' => $text]);
        # url with voice
        $url = $this->watsonUrl . '/v1/synthesize?voice=' . $this->languageAndVoice;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERPWD, 'apikey:' . $this->apiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: audio/' . $this->audioFormat,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $textJson);
        curl_setopt($ch, CURLOPT_FILE, $outputFile);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('Error with curl response: ' . curl_error($ch) . ' ' . $result);
        }

        curl_close($ch);
        fclose($outputFile);

        if (filesize($this->outputFilePath) < 1000) {
            // probably there is an error and error string is saved to file,
            // open file and read the string
            // if error key exists in the string, delete generated file and throw exception
            $content = file_get_contents($this->outputFilePath);

            if ($content === false) {
                throw new Exception('Error:' . $this->outputFilePath . ' could not be opened');
            }
            $debugContent = json_decode($content, true);

            if (array_key_exists('error', $debugContent)) {
                // deleted file created, because it is corrupt
                unlink($this->outputFilePath);

                // throw exception of the returned error
                throw new Exception('Error:' . $debugContent['error'] . ' code: ' . $debugContent['code']);
            }
        }

        if (! $result || ! is_file($this->outputFilePath)) {
            throw new Exception('Error creating file');
        }

        return $this->outputFilePath;
    }
}
