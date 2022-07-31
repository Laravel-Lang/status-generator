<?php

namespace LaravelLang\StatusGenerator\Processors\Download;

use DragonCode\Support\Facades\Helpers\Str;
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
        return $this->getPath(true, 'tmp/' . $this->getDirectoryParameter());
    }

    protected function targetPath(): string
    {
        return $this->getSourcePath($this->getDirectoryParameter() . '/' . $this->getTargetFilename(), false);
    }

    protected function getTargetFilename(): string
    {
        return Str::of($this->getProjectParameter())->after('/')->end('.json')->toString();
    }
}
