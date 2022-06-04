<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Processors\Upgrade\Locales as UpgradeProcessor;
use LaravelLang\StatusGenerator\Processors\Upgrade\Referents as ReferentsProcessor;

class Upgrade extends Command
{
    protected array|string $processor = [
        UpgradeProcessor::class,
        ReferentsProcessor::class,
    ];

    protected function configure()
    {
        $this
            ->setName('upgrade')
            ->setDescription('Upgrade files to the latest version of the localization pack');
    }
}
