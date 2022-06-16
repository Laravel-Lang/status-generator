<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\StatusGenerator\Processors\Upgrade\CleanUp as CleanUpProcessor;
use LaravelLang\StatusGenerator\Processors\Upgrade\Excludes as ExcludesProcessor;
use LaravelLang\StatusGenerator\Processors\Upgrade\Locales as LocalesProcessor;
use LaravelLang\StatusGenerator\Processors\Upgrade\Referents as ReferentsProcessor;
use LaravelLang\StatusGenerator\Processors\Upgrade\Source as SourceProcessor;

class Upgrade extends Command
{
    protected array|string $processor = [
        SourceProcessor::class,
        LocalesProcessor::class,
        ReferentsProcessor::class,
        ExcludesProcessor::class,
        CleanUpProcessor::class,
    ];

    protected function configure(): Command
    {
        return parent::configure()
            ->setName(CommandName::UPGRADE())
            ->setDescription('Upgrade files to the latest version of the localization pack');
    }
}
