# Watson Text To Speech using PHP

[![PHPUnit Tests](https://github.com/Pen-y-Fan/watson-text-to-speech-php/workflows/tests/badge.svg)](https://github.com/Pen-y-Fan/watson-text-to-speech-php/)
[![PHP Stan](https://github.com/Pen-y-Fan/watson-text-to-speech-php/workflows/phpstan/badge.svg)](https://github.com/Pen-y-Fan/watson-text-to-speech-php/)
[![PHP Stan](https://img.shields.io/badge/PHPStan-level%207-brightgreen.svg?style=flat)](https://github.com/Pen-y-Fan/watson-text-to-speech-php/)
[![ECS](https://github.com/Pen-y-Fan/watson-text-to-speech-php/workflows/ecs/badge.svg)](https://github.com/Pen-y-Fan/watson-text-to-speech-php/)
[![Easy Coding Standard](https://img.shields.io/badge/ECS-level%208-brightgreen.svg?style=flat)](https://github.com/Pen-y-Fan/watson-text-to-speech-php/)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/pen-y-fan/watson-text-to-speech-php.svg?style=flat-square)](https://packagist.org/packages/pen-y-fan/watson-text-to-speech-php)
[![Total Downloads](https://img.shields.io/packagist/dt/pen-y-fan/watson-text-to-speech-php.svg?style=flat-square)](https://packagist.org/packages/pen-y-fan/watson-text-to-speech-php)
[![License](https://poser.pugx.org/silber/bouncer/license.svg)](https://github.com/Pen-y-Fan/watson-text-to-speech-php/LICENSE.md)

<!-- [![Build Status](https://img.shields.io/travis/pen-y-fan/watson-text-to-speech-php/master.svg?style=flat-square)](https://travis-ci.org/pen-y-fan/watson-text-to-speech-php) -->
<!-- [![Quality Score](https://img.shields.io/scrutinizer/g/pen-y-fan/watson-text-to-speech-php.svg?style=flat-square)](https://scrutinizer-ci.com/g/pen-y-fan/watson-text-to-speech-php) -->

This package allows text to be converted to speech using the IBM Watson API.

## Installation

You can install the package via composer:

```bash
composer require pen-y-fan/watson-text-to-speech-php
```

The package uses **PSR-4** namespaces, meaning it is compatible with all PHP projects which implement PSR-4.

## Usage

### API Key

First obtain an API Key, free from [IBM Watson](https://www.ibm.com/uk-en/cloud/watson-text-to-speech), the lite
 tier allows 10,000 Characters per Month. No credit card is required. For full instructions see 
 [Getting started with Text to Speech](https://cloud.ibm.com/docs/services/text-to-speech?topic=text-to-speech-gettingStarted#getting-started-tutorial)

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

**Note:** this is the example from the tutorial - it will not work!

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

* Dallas: https://api.us-south.text-to-speech.watson.cloud.ibm.com
* Washington DC: https://api.us-east.text-to-speech.watson.cloud.ibm.com
* Frankfurt: https://api.eu-de.text-to-speech.watson.cloud.ibm.com
* Sydney: https://api.au-syd.text-to-speech.watson.cloud.ibm.com
* Tokyo: https://api.jp-tok.text-to-speech.watson.cloud.ibm.com
* London: https://api.eu-gb.text-to-speech.watson.cloud.ibm.com
* Seoul: https://api.kr-seo.text-to-speech.watson.cloud.ibm.com

#### Setting output path

Set absolute path of the directory where to save the output. You don't need to provide a file name as it will be auto
 generated.

```php
$path = '/aboslute/path/to/directory';

$watson->setOutputPath($path);
```

This will return the absolute path of the file created if text to speech conversion is successful, otherwise will throw
 an Exception.

#### Convert Text to Speech

Pass text to convert to speech.

```php
$text = 'This is some text I want converted to speech';

$file = $watson->runTextToSpeech($text);
```

### Exception handling

Every function throws an Exception in case of any error/issue. Bind the code block within `try-catch` block to catch
 any exception occurred.

_Ex:_

```php
try {
    $watson->setAudioFormat('mp4');
} catch (Exception $exception) {
    echo $exception->getMessage();
}
```

Will throw and exception `Not a valid audio format.` as `mp4` audio format is not supported as of now

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

* _allowed languages:_ [See Table](#supported-language-and-voice-list)
  * ar-AR
  * de-DE
  * en-GB
  * en-US
  * es-ES
  * es-LA
  * es-US
  * fr-FR
  * it-IT
  * ja-JP
  * nl-NL
  * pt-BR
  * zh-CN

* _default:_ `en-US`

##### Set Voice

The voice can be set as follows:

```php
$watson->setVoice('KateVoice');
``` 

The language and voice combination must match the name is the list.

* _allowed voices:_  [See Table](#supported-language-and-voice-list)
* _default:_ `MichaelVoice`
---

##### Set Name 

Alternatively the language and voice can be set as follows:

```php
$watson->setLanguageAndVoice('de-DE_BirgitV2Voice');
``` 

* _default:_ `en-US_MichaelVoice`

This is the equivalent of:

```php
$watson->setLanguage('de-DE');
$watson->setVoice('BirgitV2Voice');
```

### Supported language and voice list

list of supported language and voice strings

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

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email michael.pen.y.fan@gmail.com instead of using the issue
 tracker.

## Credits

* [Michael Pritchard](https://github.com/pen-y-fan)
* Based on code by [Anuj Sharma](https://github.com/TBETool/ibm-watson-tts-php)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
