<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Processors\Sync\Actualize as ActualizeProcessor;
use LaravelLang\StatusGenerator\Processors\Sync\Excludes as ExcludesProcessor;

class Sync extends Command
{
    protected array|string $processor = [
        ExcludesProcessor::class,
        ActualizeProcessor::class,
    ];

    protected function configure()
    {
        $this
            ->setName('sync')
            ->setDescription('Updates translation keys');
    }
}
