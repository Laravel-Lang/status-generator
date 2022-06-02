<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Contracts\Processor;
use LaravelLang\StatusGenerator\Processors\Upgrade as UpgradeProcessor;

class Upgrade extends Command
{
    protected string|Processor $processor = UpgradeProcessor::class;

    protected function configure()
    {
        $this
            ->setName('upgrade')
            ->setDescription('Upgrade files to the latest version of the localization pack');
    }
}
