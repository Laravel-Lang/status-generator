<?php

namespace LaravelLang\StatusGenerator\Processors\Download;

use LaravelLang\StatusGenerator\Concerns\HttpClient;
use LaravelLang\StatusGenerator\Processors\Processor;

class Download extends Processor
{
    use HttpClient;

    public function handle(): void
    {
        $this->client()->download($this->getUrlParameter(), $this->getFile());
    }

    protected function getFile(): string
    {
        return $this->getPath(false, 'tmp/' . $this->getDirectoryParameter() . '/' . $this->getFileParameter());
    }
}
