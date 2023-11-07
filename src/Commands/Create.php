<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\StatusGenerator\Constants\Option;
use LaravelLang\StatusGenerator\Processors\Create\CreateLocale as CreateProcessor;
use Symfony\Component\Console\Input\InputOption;

class Create extends Command
{
    protected array|string $processor = CreateProcessor::class;

    protected function configure(): Command
    {
        return parent::configure()
            ->setName(CommandName::CREATE())
            ->setDescription('Creates a directory for the new localization')
            ->addOption(Option::LOCALE(), null, InputOption::VALUE_OPTIONAL, 'Code of the creating locale');
    }
}
