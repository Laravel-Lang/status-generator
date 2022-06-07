<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Processors\Upgrade\CleanUp as CleanUpProcessor;
use LaravelLang\StatusGenerator\Processors\Upgrade\Excludes as ExcludesProcessor;
use LaravelLang\StatusGenerator\Processors\Upgrade\Locales as LocalesProcessor;
use LaravelLang\StatusGenerator\Processors\Upgrade\Referents as ReferentsProcessor;

class Upgrade extends Command
{
    protected array|string $processor = [
        //LocalesProcessor::class,
        //ReferentsProcessor::class,
        //ExcludesProcessor::class,
        CleanUpProcessor::class,
    ];

    protected function configure()
    {
        $this
            ->setName('upgrade')
            ->setDescription('Upgrade files to the latest version of the localization pack');
    }
}
