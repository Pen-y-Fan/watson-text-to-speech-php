<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech\Tests\unit;

use Exception;
use PenYFan\WatsonTextToSpeech\WatsonOutputPath;
use PHPUnit\Framework\TestCase;

class WatsonOutputPathTest extends TestCase
{
    public function testCanBeSet(): void
    {
        $path = sys_get_temp_dir() . '/' . random_int(1000, 9999);

        $outputPath = new WatsonOutputPath($path);

        $this->assertDirectoryExists($outputPath->getOutputPath());

        rmdir($path);

        $this->assertSame($path, $outputPath->getOutputPath());

        $this->assertStringStartsWith($path, $outputPath->getPathWithFileName());
    }

    /**
     * @throws Exception
     */
    public function testThrowsExceptionWhenNotSet(): void
    {
        $this->expectExceptionMessage('Output path is empty');

        new WatsonOutputPath('');
    }

    /**
     * @requires OSFAMILY Windows
     * @throws Exception
     */
    public function testOutputPathIsInvalid(): void
    {
        $this->expectExceptionMessage('Unable to create output directory');

        new WatsonOutputPath('/>greaterthan');
    }
}
