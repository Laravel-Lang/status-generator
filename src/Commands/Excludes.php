<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Processors\Excludes as ExcludesProcessor;

class Excludes extends Command
{
    protected array|string $processor = ExcludesProcessor::class;

    protected function configure()
    {
        $this
            ->setName('excludes')
            ->setDescription('Updates the exclusion list');
    }
}
