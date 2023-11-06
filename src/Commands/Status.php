<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\StatusGenerator\Constants\Option;
use LaravelLang\StatusGenerator\Processors\Status\CleanUp as CleanUpProcessor;
use LaravelLang\StatusGenerator\Processors\Status\Localization as LocalizationProcessor;
use LaravelLang\StatusGenerator\Processors\Status\MainPage as MainPageProcessor;
use Symfony\Component\Console\Input\InputOption;

class Status extends Command
{
    protected array|string $processor = [
        CleanUpProcessor::class,
        MainPageProcessor::class,
        LocalizationProcessor::class,
    ];

    protected function configure(): Command
    {
        return parent::configure()
            ->setName(CommandName::STATUS())
            ->setDescription('Updates documentation with the status of translations')
            ->addOption(
                Option::COLUMNS(),
                null,
                InputOption::VALUE_OPTIONAL,
                'Defines the number of columns generated for the locales table on the general status page',
                8
            );
    }
}
