<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Processors\Download as DownloadProcessor;

class Download extends Command
{
    protected array|string $processor = DownloadProcessor::class;

    protected function configure()
    {
        $this
            ->setName('download')
            ->setDescription('Download and unpack the project');
    }
}
