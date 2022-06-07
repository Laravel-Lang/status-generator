<?php

namespace LaravelLang\StatusGenerator\Processors\Download;

use LaravelLang\StatusGenerator\Concerns\HttpClient;
use LaravelLang\StatusGenerator\Constants\Argument;
use LaravelLang\StatusGenerator\Processors\Processor;

class Download extends Processor
{
    use HttpClient;

    public function handle(): void
    {
        $this->client()->download($this->getUrl(), $this->getFile());
    }

    protected function getUrl(): string
    {
        return $this->parameter(Argument::URL());
    }

    protected function getFile(): string
    {
        return $this->getPath(false, 'tmp/' . $this->getDirectory() . '/' . $this->getFilename());
    }

    protected function getDirectory(): string
    {
        return $this->parameter(Argument::DIRECTORY());
    }

    protected function getFilename(): string
    {
        return $this->parameter(Argument::FILE());
    }
}
