<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\StatusGenerator\Processors\Status\CleanUp as CleanUpProcessor;
use LaravelLang\StatusGenerator\Processors\Status\MainPage as MainPageProcessor;

class Status extends Command
{
    protected array|string $processor = [
        CleanUpProcessor::class,
        MainPageProcessor::class,
    ];

    protected function configure(): Command
    {
        return parent::configure()
            ->setName(CommandName::STATUS())
            ->setDescription('Updates documentation with the status of translations');
    }
}
