<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Processors\Excludes as ExcludesProcessor;

class Sync extends Command
{
    protected array|string $processor = [
        ExcludesProcessor::class,
    ];

    protected function configure()
    {
        $this
            ->setName('sync')
            ->setDescription('Updates translation keys');
    }
}
