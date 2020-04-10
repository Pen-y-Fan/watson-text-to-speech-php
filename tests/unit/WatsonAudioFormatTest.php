<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\unit;

use Exception;
use PenYFan\WatsonTextToSpeech\WatsonAudioFormat;
use PHPUnit\Framework\TestCase;

class WatsonAudioFormatTest extends TestCase
{
    public function testCanBeSet(): void
    {
        $basicAudioFormat = new WatsonAudioFormat('basic');

        $this->assertSame('basic', $basicAudioFormat->getAudioFormat());
        $this->assertSame('basic', $basicAudioFormat->getFileExtension());

        $webmCodecsVorbiAudioFormat = new WatsonAudioFormat('webm;codecs=vorbi');

        $this->assertSame('webm;codecs=vorbi', $webmCodecsVorbiAudioFormat->getAudioFormat());
        $this->assertSame('webm', $webmCodecsVorbiAudioFormat->getFileExtension());

        $mpegAudioFormat = new WatsonAudioFormat('mpeg');

        $this->assertSame('mpeg', $mpegAudioFormat->getAudioFormat());
    }

    /**
     * @throws Exception
     */
    public function testThrowsExceptionWhenNotSet(): void
    {
        $this->expectExceptionMessage('Audio format string is empty');

        new WatsonAudioFormat('');
    }

    /**
     * @throws Exception
     */
    public function testMustBeValidCombination(): void
    {
        $expected = 'Not a valid audio format. Allowed formats: basic, flac, l16, ogg, ogg;codecs=opus, ';
        $expected .= 'ogg;codecs=vorbis, mp3, mpeg, mulaw, wav, webm, webm;codecs=opus, webm;codecs=vorbi';

        $this->expectExceptionMessage($expected);

        new WatsonAudioFormat('mp4');
    }
}
