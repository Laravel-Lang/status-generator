<?php

namespace LaravelLang\StatusGenerator\Processors\Download;

use LaravelLang\StatusGenerator\Constants\Argument;
use LaravelLang\StatusGenerator\Facades\Services\Filesystem\Archive as Zip;
use LaravelLang\StatusGenerator\Processors\Processor;

class Archive extends Processor
{
    public function handle(): void
    {
        $this->unpack($this->sourceFile(), $this->targetDirectory());
    }

    protected function unpack(string $path, string $directory): void
    {
        Zip::unpack($path, $directory);
    }

    protected function sourceFile(): string
    {
        return $this->getPath(true, 'tmp/' . $this->getDirectory() . '/' . $this->getFilename());
    }

    protected function targetDirectory(): string
    {
        return $this->getPath(true, 'tmp/' . $this->getDirectory());
    }

    protected function getFilename(): string
    {
        return $this->parameter(Argument::FILE());
    }

    protected function getDirectory(): string
    {
        return $this->parameter(Argument::DIRECTORY());
    }
}
