<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\StatusGenerator\Constants\Option;
use LaravelLang\StatusGenerator\Processors\Upgrade\CleanUp as CleanUpProcessor;
use LaravelLang\StatusGenerator\Processors\Upgrade\Excludes as ExcludesProcessor;
use LaravelLang\StatusGenerator\Processors\Upgrade\Locales as LocalesProcessor;
use LaravelLang\StatusGenerator\Processors\Upgrade\Referents as ReferentsProcessor;
use LaravelLang\StatusGenerator\Processors\Upgrade\Source as SourceProcessor;
use Symfony\Component\Console\Input\InputOption;

class Upgrade extends Command
{
    protected array|string $processor = [
        SourceProcessor::class,
        LocalesProcessor::class,
        ReferentsProcessor::class,
        ExcludesProcessor::class,
        CleanUpProcessor::class,
    ];

    protected function configure(): void
    {
        $this
            ->setName(CommandName::UPGRADE())
            ->setDescription('Upgrade files to the latest version of the localization pack')
            ->addOption(Option::PATH(), null, InputOption::VALUE_OPTIONAL, 'Path to project files');
    }
}
