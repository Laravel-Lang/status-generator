<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\StatusGenerator\Processors\Sync\Actualize as ActualizeProcessor;
use LaravelLang\StatusGenerator\Processors\Sync\Excludes as ExcludesProcessor;
use LaravelLang\StatusGenerator\Processors\Sync\NotTranslatable as NotTranslatableProcessor;

class Sync extends Command
{
    protected array|string $processor = [
        ExcludesProcessor::class,
        NotTranslatableProcessor::class,
        ActualizeProcessor::class,
    ];

    protected function configure(): Command
    {
        return parent::configure()
            ->setName(CommandName::SYNC())
            ->setDescription('Updates translation keys');
    }
}
