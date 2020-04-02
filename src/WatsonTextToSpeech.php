<?php
/**
 * Created by PhpStorm.
 * User: anuj
 * Date: 21/5/18
 * Time: 11:14 AM
 */

namespace PenYFan\WatsonTextToSpeech;

use Exception;

class WatsonTextToSpeech
{
    private $apiKey;
    private $watsonUrls = [
        'https://api.au-syd.text-to-speech.watson.cloud.ibm.com',
        'https://api.eu-gb.text-to-speech.watson.cloud.ibm.com',
        'https://api.eu-de.text-to-speech.watson.cloud.ibm.com',
        'https://api.jp-tok.text-to-speech.watson.cloud.ibm.com',
        'https://api.kr-seo.text-to-speech.watson.cloud.ibm.com',
        'https://api.us-east.text-to-speech.watson.cloud.ibm.com',
        'https://api.us-south.text-to-speech.watson.cloud.ibm.com',
    ];
    private $watsonUrl;
    private $valid_audio_formats = [
        'basic', 'flac', 'l16', 'ogg', 'ogg;codecs=opus', 'ogg;codecs=vorbis', 'mp3',
        'mpeg', 'mulaw', 'wav', 'webm', 'webm;codecs=opus', 'webm;codecs=vorbi'];
    private $audioFormat = 'mp3';
    private $valid_language = [
        'ar-AR', 'de-DE', 'en-GB', 'en-US', 'es-ES', 'es-LA', 'es-US',
        'fr-FR', 'it-IT', 'ja-JP', 'nl-NL', 'pt-BR', 'zh-CN'
    ];
    private $language = 'en-US';
    private $valid_voices = [
        'AllisonV2Voice', 'AllisonV3Voice', 'AllisonVoice', 'BirgitV2Voice', 'BirgitV3Voice', 'BirgitVoice',
        'DieterV2Voice', 'DieterV3Voice', 'DieterVoice', 'EmiV3Voice', 'EmiVoice', 'EmilyV3Voice', 'EmmaVoice',
        'EnriqueV3Voice', 'EnriqueVoice', 'ErikaV3Voice', 'FrancescaV2Voice', 'FrancescaV3Voice', 'FrancescaVoice',
        'HenryV3Voice', 'IsabelaV3Voice', 'IsabelaVoice', 'KateV3Voice', 'KateVoice', 'KevinV3Voice', 'LauraV3Voice',
        'LauraVoice', 'LiNaVoice', 'LiamVoice', 'LisaV2Voice', 'LisaV3Voice', 'LisaVoice', 'MichaelV2Voice',
        'MichaelV3Voice', 'MichaelVoice', 'OliviaV3Voice', 'OmarVoice', 'ReneeV3Voice', 'ReneeVoice', 'SofiaV3Voice',
        'SofiaVoice', 'WangWeiVoice', 'ZhangJingVoice',
    ];
    private $voice = 'MichaelVoice';
    private $outputPath;
    private $outputFilePath;
    private $text;

    /**
     * set watson url
     * The url can be in the format:
     * https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/v1/synthesize/
     * https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/v1/synthesize
     * https://api.eu-gb.text-to-speech.watson.cloud.ibm.com/
     * https://api.eu-gb.text-to-speech.watson.cloud.ibm.com
     *
     * @param $watsonUrl
     * @throws Exception
     */
    public function setWatsonUrl(string $watsonUrl): void
    {
        if (empty($watsonUrl)) {
            throw new Exception('Watson URL not provided');
        }

        $trimUrl = rtrim($watsonUrl, '/');
        $trimUrl = rtrim($trimUrl, '/v1/synthesize');

        if (!in_array($trimUrl, $this->watsonUrls)) {
            throw new Exception(
                'Not a valid Watson URL. Allowed URLs: ' . implode(' ', $this->watsonUrls)
            );
        }

        $this->watsonUrl = $trimUrl;

    }

    /**
     * set watson API key
     *
     * @param $apiKey
     * @throws Exception
     */
    public function setApiKey(string $apiKey): void
    {
        if (empty($apiKey)) {
            throw new Exception('Watson API key not provided');
        }

        $this->apiKey = $apiKey;
    }

    /**
     * set audio format,
     * default: mp3
     *
     * @param $format
     * @throws Exception
     */
    public function setAudioFormat(string $format): void
    {
        if (empty($format)) {
            throw new Exception('Audio format string is empty');
        }

        if (!in_array($format, $this->valid_audio_formats)) {
            throw new Exception(
                'Not a valid audio format. Allowed formats: ' . implode(' ', $this->valid_audio_formats)
            );
        }

        $this->audioFormat = $format;
    }

    /**
     * set language of audio,
     * default: 'en-US'
     *
     * @param $language
     * @throws Exception
     */
    public function setLanguage(string $language): void
    {
        if (empty($language))
            throw new Exception('Language string is empty');

        if (!in_array($language, $this->valid_language))
            throw new Exception(
                'Not a valid language provided. Allowed languages: ' . implode(' ', $this->valid_language)
            );

        $this->language = $language;
    }

    /**
     * set voice,
     * default:'MichaelVoice'
     *
     * @param $voice
     * @throws Exception
     */
    public function setVoice(string $voice): void
    {
        if (empty($voice))
            throw new Exception('Voice string is empty');

        if (!in_array($voice, $this->valid_voices))
            throw new Exception(
                'Not a valid voice provided. Allowed voices: ' . implode(' ', $this->valid_voices)
            );

        $this->voice = $voice;
    }

    /**
     * set output path
     *
     * @param $outputPath
     * @throws Exception
     */
    public function setOutputPath(string $outputPath): void
    {
        if (empty($outputPath)) {
            throw new Exception('Output path is empty');
        }

        if (!$this->checkAndCreateDirectory($outputPath)) {
            throw new Exception('Unable to create output directory');
        }

        $this->outputPath = $outputPath;
    }

    /**
     * check for if output_path is directory,
     * else create path,
     *
     * @param $outputPath
     * @return bool
     */
    private function checkAndCreateDirectory(string $outputPath): bool
    {
        if (is_dir($outputPath)) {
            return true;
        }

        if (mkdir($outputPath, 0777, true)) {
            return true;
        }

        return false;
    }

    /**
     * text to speech serializer
     *
     * @param $text
     * @param null $format
     * @param null $language
     * @param null $voice
     * @return string
     * @throws Exception
     */
    public function runTextToSpeech(string $text, string $format = null, string $language = null, string $voice = null): string
    {
        if (empty($text)) {
            throw new Exception('No text string provided');
        }

        $this->text = $text;

        if (empty($this->outputPath)) {
            throw new Exception(
                'Output path is not set. Please set output path by passing absolute path string to setOutputPath()'
            );
        }

        if (!empty($format)) {
            $this->setAudioFormat($format);
        }

        if (!empty($language)) {
            $this->setLanguage($language);
        }

        if (!empty($voice)) {
            $this->setVoice($voice);
        }

        $this->prepareOutputFile();

        try {
            return $this->processWatsonTextToSpeechCurl();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * prepare output file and name
     * @throws Exception
     */
    private function prepareOutputFile(): void
    {
        $fileName = date("Ymd-GisT", time()) . random_int(100, 999) . '.' . $this->audioFormat;

        $this->outputFilePath = rtrim($this->outputPath, '/') . '/' . $fileName;
    }

    /**
     * process watson curl script
     *
     * @throws Exception
     */
    private function processWatsonTextToSpeechCurl(): string
    {
        $textJson = json_encode(['text' => $this->text]);

        $outputFile = fopen($this->outputFilePath, 'w');

        # url with voice
        $url = $this->watsonUrl . '/v1/synthesize?voice=' . $this->language . '_' . $this->voice;

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
            throw new Exception('Error with curl response: ' . curl_error($ch));
        }

        curl_close($ch);
        fclose($outputFile);

        if (filesize($this->outputFilePath) < 1000) {
            //
            // probably there is an error and error string is saved to file,
            // open file and read the string
            // if error key exists in the string, delete generated file and throw exception
            //
            $content = file_get_contents($this->outputFilePath);

            $debugContent = json_decode($content);

            if (key_exists('error', $debugContent)) {
                // deleted file created, because it is corrupt
                unlink($this->outputFilePath);

                // throw exception of the returned error
                throw new Exception("Error:" . $debugContent->error . " code: " . $debugContent->code);
            }
        }

        if ($result && is_file($this->outputFilePath)) {
            return $this->outputFilePath;
        }

        throw new Exception('Error creating file');
    }

}
