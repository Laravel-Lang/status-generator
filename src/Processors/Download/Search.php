<?php

namespace LaravelLang\StatusGenerator\Processors\Download;

use LaravelLang\StatusGenerator\Constants\Argument;
use LaravelLang\StatusGenerator\Facades\Services\Packages\Package;
use LaravelLang\StatusGenerator\Processors\Processor;

class Search extends Processor
{
    public function handle(): void
    {
        if ($values = $this->parse()) {
            $this->store($values);
        }
    }

    protected function parse(): array
    {
        return Package::some()->path($this->sourcePath())->content();
    }

    protected function store(array $values): void
    {
        $this->filesystem->store($this->targetPath(), $values, false, true);
    }

    protected function sourcePath(): string
    {
        return $this->getPath(true, 'tmp/' . $this->getDirectory());
    }

    protected function targetPath(): string
    {
        return $this->getSourcePath('packages/' . $this->getDirectory() . '/' . $this->getTargetFilename(), false);
    }

    protected function getDirectory(): string
    {
        return $this->parameter(Argument::DIRECTORY());
    }

    protected function getProject(): string
    {
        return $this->parameter(Argument::PROJECT());
    }

    protected function getTargetFilename(): string
    {
        return $this->getProject() . '.json';
    }
}
