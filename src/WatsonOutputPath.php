<?php

declare(strict_types=1);

namespace PenYFan\WatsonTextToSpeech;

use Exception;

class WatsonOutputPath
{
    /**
     * @var string
     */
    private $outputPath;

    public function __construct(string $outputPath)
    {
        $this->mustBeValidOutputPath($outputPath);
    }

    public function getOutputPath(): string
    {
        return $this->outputPath;
    }

    /**
     * prepare output file and name
     * @throws Exception
     */
    public function getPathWithFileName(): string
    {
        return $this->outputPath . '/' . date('Ymd-GisT', time()) . random_int(100, 999);
    }

    private function mustBeValidOutputPath(string $outputPath): void
    {
        if (! $this->isOutputPathSet($outputPath)) {
            throw new Exception('Output path is empty');
        }

        if (! $this->isOutputPathDirectory($outputPath)) {
            throw new Exception('Unable to create output directory');
        }

        $this->outputPath = $outputPath;
    }

    private function isOutputPathSet(string $outputPath): bool
    {
        if (empty($outputPath)) {
            return false;
        }
        return true;
    }

    private function isOutputPathDirectory(string $outputPath): bool
    {
        if (is_dir($outputPath)) {
            return true;
        }

        try {
            if (mkdir($outputPath, 0777, true)) {
                return true;
            }
        } catch (Exception $exception) {
        }
        return false;
    }
}
