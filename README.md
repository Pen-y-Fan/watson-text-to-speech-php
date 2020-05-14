# Watson Text To Speech using PHP

[![PHPUnit Tests](https://github.com/Pen-y-Fan/watson-text-to-speech-php/workflows/tests/badge.svg)](https://github.com/Pen-y-Fan/watson-text-to-speech-php/)
[![PHP Stan](https://github.com/Pen-y-Fan/watson-text-to-speech-php/workflows/phpstan/badge.svg)](https://github.com/Pen-y-Fan/watson-text-to-speech-php/)
[![PHP Stan](https://img.shields.io/badge/PHPStan-level%207-brightgreen.svg?style=flat)](https://github.com/Pen-y-Fan/watson-text-to-speech-php/)
[![ECS](https://github.com/Pen-y-Fan/watson-text-to-speech-php/workflows/ecs/badge.svg)](https://github.com/Pen-y-Fan/watson-text-to-speech-php/)
[![Easy Coding Standard](https://img.shields.io/badge/ECS-level%208-brightgreen.svg?style=flat)](https://github.com/Pen-y-Fan/watson-text-to-speech-php/)
[![License](https://poser.pugx.org/silber/bouncer/license.svg)](https://github.com/Pen-y-Fan/watson-text-to-speech-php/LICENSE.md)

<!-- [![Latest Version on Packagist](https://img.shields.io/packagist/v/pen-y-fan/watson-text-to-speech-php.svg?style=flat-square)](https://packagist.org/packages/pen-y-fan/watson-text-to-speech-php) -->
<!-- [![Total Downloads](https://img.shields.io/packagist/dt/pen-y-fan/watson-text-to-speech-php.svg?style=flat-square)](https://packagist.org/packages/pen-y-fan/watson-text-to-speech-php) -->
<!-- [![Build Status](https://img.shields.io/travis/pen-y-fan/watson-text-to-speech-php/master.svg?style=flat-square)](https://travis-ci.org/pen-y-fan/watson-text-to-speech-php) -->
<!-- [![Quality Score](https://img.shields.io/scrutinizer/g/pen-y-fan/watson-text-to-speech-php.svg?style=flat-square)](https://scrutinizer-ci.com/g/pen-y-fan/watson-text-to-speech-php) -->

This package allows text to be converted to speech using the IBM Watson API. 

## Installation

This project has not been published as a package. To use it in your package add the following to your project. 

***composer.json***

```json
{
"require": {
        // other dependances
        "pen-y-fan/watson-text-to-speech-php": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/Pen-y-Fan/watson-text-to-speech-php"
        }
    ]
}
```

Then run:

```shell script
composer install
```

The package uses **PSR-4** namespaces, meaning it is compatible with all PHP projects which implement PSR-4. The package
 is framework agnostics some additional Laravel specific features have been added, such as loading the required keys
  via the **.env** file.

## Usage

### API Key

First obtain an API key and Url, free from [IBM Watson](https://www.ibm.com/uk-en/cloud/watson-text-to-speech), the lite
 tier allows 10,000 characters per month. No credit card is required. For full instructions see 
 [Getting started with Text to Speech](https.://cloud.ibm.com/docs/services/text-to-speech?topic=text-to-speech-gettingStarted#getting-started-tutorial)

### TL&DR;

Minimum required information to run the package.

```php
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeech;

$watson = new WatsonTextToSpeech();
$watson->setApiKey('yourAPIkeyFromIBM')
    ->setUrl('https://api.eu-gb.text-to-speech.watson.cloud.ibm.com')
    ->setOutputPath('/public');
$file = $watson->runTextToSpeech('This is the text you want to convert to speech');
```

This will save a **mp3** (default) in the **/public** folder (or the folder you specified). The $file variable will
 confirm the path and filename.

### Detailed explanation

#### Instantiate the project

After installing the package, instantiate `WatsonTextToSpeech` object

```php
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeech;

$watson = new WatsonTextToSpeech();
```

#### Setting API Key

Change to the API key in your Manage Credentials for Text to Speech.
 
- e.g. f5sAznhrKQyvBFFaZbtF60m5tzLbqWhyALQawBg5TjRI

**Note:** This is the example from the IBM tutorial - it will not work!

```php
$apiKey = 'f5sAznhrKQyvBFFaZbtF60m5tzLbqWhyALQawBg5TjRI';

$watson->setApiKey($apiKey);
```

#### Setting Watson Url

Set the Url to the region you selected when you signed up to the Watson API. This example is for London.

```php
$watsonUrl = 'https://api.eu-gb.text-to-speech.watson.cloud.ibm.com';

$watson->setWatsonUrl($watsonUrl);
```

Available regions:

Region | Url 
--- | --- 
Dallas | <https://api.us-south.text-to-speech.watson.cloud.ibm.com>
Washington DC| <https://api.us-east.text-to-speech.watson.cloud.ibm.com>
Frankfurt | <https://api.eu-de.text-to-speech.watson.cloud.ibm.com>
Sydney | <https://api.au-syd.text-to-speech.watson.cloud.ibm.com>
Tokyo | <https://api.jp-tok.text-to-speech.watson.cloud.ibm.com>
London | <https://api.eu-gb.text-to-speech.watson.cloud.ibm.com>
Seoul | <https://api.kr-seo.text-to-speech.watson.cloud.ibm.com>

#### Setting output path

Set absolute or relative path of the directory where the output file is saved. You don't need to provide a file name as
 it will be auto generated. Care should be taken with relative paths, as it is relative to the originating file, e.g. 
 this is could be **index.php** in the **public** directory.

```php
$path = '/aboslute/path/to/directory';

$watson->setOutputPath($path);
```

This will set the path of the directory the file will be created in, if text to speech conversion is successful.

An empty string or invalid file directory will throw an exception.

#### Convert Text to Speech

Finally, call `runTextToSpeech` passing in the text to be convert to speech.

```php
$text = 'This is some text I want converted to speech';

$file = $watson->runTextToSpeech($text);
```

`$file` will contain the file path, with the file name, in a date time UTC format + three digits random number, in the
 choose audio format. E.G. An **mp3** audio format would be saved as: **yyyymmdd-hhmmssUTCnnn.mp3**
  
### Exception handling

Every function throws an Exception in case of any error/issue. Bind the code block within a `try-catch` block to catch
 any exception that occurred.

_Ex:_

```php
try {
    $watson->setAudioFormat('mp4');
} catch (Exception $exception) {
    echo $exception->getMessage();
}
```

Will throw an exception `Not a valid audio format.` as `mp4` audio format is not supported as of now

### Other callable methods

##### Set Audio Format

```php
$watson->setAudioFormat('wav');
```

* _allowed formats:_ `basic`, `flac`, `l16`, `ogg`, `ogg;codecs=opus`, `ogg;codecs=vorbis`, `mp3`, `mpeg`, `mulaw`,
 `wav`, `webm`, `webm;codecs=opus` and `webm;codecs=vorbi` 
* _default_: `mp3`

For full details see the
 [IBM Watson Text to Speech documentation](https://cloud.ibm.com/apidocs/text-to-speech/text-to-speech)

##### Set Language

The language can be set as follows:

```php
$watson->setLanguage('en-GB');
```

The language and voice combination must match the name is the list.

* _allowed languages:_  `ar-AR`, `de-DE`, `en-GB`, `en-US`, `es-ES`, `es-LA`, `es-US`, `fr-FR`, `it-IT`, `ja-JP`, 
`nl-NL`, `pt-BR`, `zh-CN`. [See Table](#supported-language-and-voice-list) for suppoted combinations.
* _default:_ `en-US`

##### Set Voice

The voice can be set as follows:

```php
$watson->setVoice('KateVoice');
``` 

The language and voice combination must match the name is the list.

* _allowed voices:_  [See Table](#supported-language-and-voice-list)
* _default:_ `MichaelVoice`

##### Set Name 

Alternatively the language and voice can be set as follows:

```php
$watson->setLanguageAndVoice('de-DE_BirgitV2Voice');
``` 

This is the equivalent of:

```php
$watson->setLanguage('de-DE');
$watson->setVoice('BirgitV2Voice');
```

* _default:_ `en-US_MichaelVoice`

### Supported language and voice list

List of supported language and voice

Name | language | voice | gender | description
--- | --- | --- | --- | ---
ar-AR_OmarVoice | **ar-AR** | **OmarVoice** | male | Omar: Arabic male voice.
de-DE_BirgitV2Voice | **de-DE** | **BirgitV2Voice** | female | Birgit: Standard German (Standard deutsch) female voice. Dnn technology.
de-DE_BirgitV3Voice | **de-DE** | **BirgitV3Voice** | female | Birgit: Standard German (Standard deutsch) female voice. Dnn technology.
de-DE_BirgitVoice | **de-DE** | **BirgitVoice** | female | Birgit: Standard German (Standard deutsch) female voice.
de-DE_DieterV2Voice | **de-DE** | **DieterV2Voice** | male | Dieter: Standard German (Standard deutsch) male voice. Dnn technology.
de-DE_DieterV3Voice | **de-DE** | **DieterV3Voice** | male | Dieter: Standard German (Standard deutsch) male voice. Dnn technology.
de-DE_DieterVoice | **de-DE** | **DieterVoice** | male | Dieter: Standard German (Standard deutsch) male voice.
de-DE_ErikaV3Voice | **de-DE** | **ErikaV3Voice** | female | Erika: Standard German (Standard deutsch) female voice. Dnn technology.
en-GB_KateV3Voice | **en-GB** | **KateV3Voice** | female | Kate: British English female voice. Dnn technology.
en-GB_KateVoice | **en-GB** | **KateVoice** | female | Kate: British English female voice.
en-US_AllisonV2Voice | **en-US** | **AllisonV2Voice** | female | Allison: American English female voice. Dnn technology.
en-US_AllisonV3Voice | **en-US** | **AllisonV3Voice** | female | Allison: American English female voice. Dnn technology.
en-US_AllisonVoice | **en-US** | **AllisonVoice** | female | Allison: American English female voice.
en-US_EmilyV3Voice | **en-US** | **EmilyV3Voice** | female | Emily: American English female voice. Dnn technology.
en-US_HenryV3Voice | **en-US** | **HenryV3Voice** | male | Henry: American English male voice. Dnn technology.
en-US_KevinV3Voice | **en-US** | **KevinV3Voice** | male | Kevin: American English male voice. Dnn technology.
en-US_LisaV2Voice | **en-US** | **LisaV2Voice** | female | Lisa: American English female voice. Dnn technology.
en-US_LisaV3Voice | **en-US** | **LisaV3Voice** | female | Lisa: American English female voice. Dnn technology.
en-US_LisaVoice | **en-US** | **LisaVoice** | female | Lisa: American English female voice.
en-US_MichaelV2Voice | **en-US** | **MichaelV2Voice** | male | Michael: American English male voice. Dnn technology.
en-US_MichaelV3Voice | **en-US** | **MichaelV3Voice** | male | Michael: American English male voice. Dnn technology.
en-US_MichaelVoice | **en-US** | **MichaelVoice** | male | Michael: American English male voice.
en-US_OliviaV3Voice | **en-US** | **OliviaV3Voice** | female | Olivia: American English female voice. Dnn technology.
es-ES_EnriqueV3Voice | **es-ES** | **EnriqueV3Voice** | male | Enrique: Castilian Spanish (español castellano) male voice. Dnn technology.
es-ES_EnriqueVoice | **es-ES** | **EnriqueVoice** | male | Enrique: Castilian Spanish (español castellano) male voice.
es-ES_LauraV3Voice | **es-ES** | **LauraV3Voice** | female | Laura: Castilian Spanish (español castellano) female voice. Dnn technology.
es-ES_LauraVoice | **es-ES** | **LauraVoice** | female | Laura: Castilian Spanish (español castellano) female voice.
es-LA_SofiaV3Voice | **es-LA** | **SofiaV3Voice** | female | Sofia: Latin American Spanish (español latino americano) female voice. Dnn technology.
es-LA_SofiaVoice | **es-LA** | **SofiaVoice** | female | Sofia: Latin American Spanish (español latino americano) female voice.
es-US_SofiaV3Voice | **es-US** | **SofiaV3Voice** | female | Sofia: North American Spanish (español norteamericano) female voice. Dnn technology.
es-US_SofiaVoice | **es-US** | **SofiaVoice** | female | Sofia: North American Spanish (español norteamericano) female voice.
fr-FR_ReneeV3Voice | **fr-FR** | **ReneeV3Voice** | female | Renee: French (français) female voice. Dnn technology.
fr-FR_ReneeVoice | **fr-FR** | **ReneeVoice** | female | Renee: French (français) female voice.
it-IT_FrancescaV2Voice | **it-IT** | **FrancescaV2Voice** | female | Francesca: Italian (italiano) female voice. Dnn technology.
it-IT_FrancescaV3Voice | **it-IT** | **FrancescaV3Voice** | female | Francesca: Italian (italiano) female voice. Dnn technology.
it-IT_FrancescaVoice | **it-IT** | **FrancescaVoice** | female | Francesca: Italian (italiano) female voice.
ja-JP_EmiV3Voice | **ja-JP** | **EmiV3Voice** | female | Emi: Japanese (日本語) female voice. Dnn technology.
ja-JP_EmiVoice | **ja-JP** | **EmiVoice** | female | Emi: Japanese (日本語) female voice.
nl-NL_EmmaVoice | **nl-NL** | **EmmaVoice** | female | Emma: Dutch female voice.
nl-NL_LiamVoice | **nl-NL** | **LiamVoice** | male | Liam: Dutch male voice.
pt-BR_IsabelaV3Voice | **pt-BR** | **IsabelaV3Voice** | female | Isabela: Brazilian Portuguese (português brasileiro) female voice. Dnn technology.
pt-BR_IsabelaVoice | **pt-BR** | **IsabelaVoice** | female | Isabela: Brazilian Portuguese (português brasileiro) female voice.
zh-CN_LiNaVoice | **zh-CN** | **LiNaVoice** | female | Li Na: Chinese (Mandarin) female voice.
zh-CN_WangWeiVoice | **zh-CN** | **WangWeiVoice** | male | Wang Wei: Chinese (Mandarin) male voice.
zh-CN_ZhangJingVoice | **zh-CN** | **ZhangJingVoice** | female | Zhang Jing: Chinese (Mandarin) female voice.

### Laravel

This package will auto register with a laravel project, some additional helpers have been provided:

#### **.env** keys

The following keys can be added to the **.env** file and will be automatically used:

```ini
WATSON_API_KEYS=f5sAznhrKQyvBFFaZbtF60m5tzLbqWhyALQawBg5TjRI
WATSON_API_PATH=storage/watson-api
WATSON_API_URL=https://api.eu-gb.text-to-speech.watson.cloud.ibm.com
WATSON_API_NAME=en-US_MichaelVoice
``` 

If using git version control it is recommended to add the Api key to the **.env** file and double check **.env** is
 included in **.gitignore**, by default it is. 

##### WATSON_API_KEYS

**Note:** This is the example from the tutorial - it will not work!

Same as [Setting API Key](#setting-api-key)

##### WATSON_API_PATH

Same as [Setting output path](#setting-output-path)

`storage/watson-api` is the relative link from the public folder. I.E. Relative to public/**index.php**.

##### WATSON_API_URL

Same as [Setting Watson Url](#setting-watson-url)

##### WATSON_API_NAME

Same as [Set Name](#set-name)

#### Usage

This is a basic example inside **web.php**:

```php
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeech;

// other routes

Route::get('/watson/{text}', function ($text) {
    try {
        $watson = resolve(WatsonTextToSpeech::class);
        return $watson->runTextToSpeech($text);
    } catch (Exception $exception) {
        return $exception->getMessage();
    }
});
```

The above will run when the  `/watson/some text to convert` route is hit and return the relative file path with file
 name, in a date time format in UTC + three digit random number in the default **mp3** format. The file is saved as:
 **storage/watson-api/yyyymmdd-hhmmssUTCnnn.mp3**

If there are any problems with the key/values provided or with the IBM Watson API, an error will be returned.

On inside a controller:

```php
<?php

namespace App\Http\Controllers;

use Exception;use Illuminate\Http\Request;
use PenYFan\WatsonTextToSpeech\WatsonTextToSpeech;

class WatsonController extends Controller
{
    /**
     * @var WatsonTextToSpeech
     */
    protected $watson;

    public function __construct(WatsonTextToSpeech $watson)
    {
        $this->watson = $watson;
    }

    public function store($text)
    {
        // validate the request
        try {
            $file = $this->watson->runTextToSpeech($text);
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }

        $link = "http://127.0.0.1:8000/" . $file;
        return "<a href={$link}>Play sound file</a>";
    }
}
```

#### Console Command

To use the console command the **.env** file needs to be configured as stated above. From the command line run:

```shell script
php artisan watson-text-to-speech
```

When prompted type in the text to be converted. Wait for the API call to complete, the location of the speech file
 will display. e.g.: 

```text
php artisan watson-text-to-speech

 Enter the text you wish to convert to speech::
 > Test console command

Text has been converted to speech, see: storage/watson-api/20200510-183722UTC306.mp3
```

## Example

Example of Watson API text to speech output:

<video controls="" autoplay="" name="media">
    <source src="./20200510-193413UTC748.mp3" type="audio/mpeg">
</video>

[20200510-193413UTC748.mp3](20200510-193413UTC748.mp3)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

This is a **personal project**. Contributions are **not** required. Anyone interested in developing this project are welcome to 
 fork or clone for your own use.

## Credits

* [Michael Pritchard](https://github.com/pen-y-fan).
* Based on code by [Anuj Sharma](https://github.com/TBETool/ibm-watson-tts-php).

## License

MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

The Laravel package Boilerplate was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
