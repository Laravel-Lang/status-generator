<?php

namespace LaravelLang\StatusGenerator\Processors\Download;

use LaravelLang\StatusGenerator\Facades\Services\Filesystem\Archive as Zip;
use LaravelLang\StatusGenerator\Processors\Processor;

class Archive extends Processor
{
    public function handle(): void
    {
        $this->output->task('Unpack', fn () => $this->unpack($this->sourceFile(), $this->targetDirectory()));
    }

    protected function unpack(string $path, string $directory): void
    {
        Zip::unpack($path, $directory);
    }

    protected function sourceFile(): string
    {
        return $this->getPath(true, 'tmp/' . $this->getDirectoryParameter() . '/' . $this->getFileParameter());
    }

    protected function targetDirectory(): string
    {
        return $this->getPath(true, 'tmp/' . $this->getDirectoryParameter());
    }
}
