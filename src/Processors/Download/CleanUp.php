<?php

namespace LaravelLang\StatusGenerator\Processors\Download;

use DragonCode\Support\Facades\Filesystem\Directory;
use LaravelLang\StatusGenerator\Constants\Argument;
use LaravelLang\StatusGenerator\Processors\Processor;

class CleanUp extends Processor
{
    public function handle(): void
    {
        Directory::ensureDelete($this->directories());
    }

    protected function directories(): array
    {
        return [
            $this->getPath(false, 'source/packages/' . $this->getDirectory(), false),
            $this->getPath(false, 'tmp/' . $this->getDirectory()),
        ];
    }

    protected function getDirectory(): string
    {
        return $this->parameter(Argument::DIRECTORY());
    }
}
