<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Constants\Argument;
use LaravelLang\StatusGenerator\Processors\Create as CreateProcessor;
use Symfony\Component\Console\Input\InputArgument;

class Create extends Command
{
    protected array|string $processor = CreateProcessor::class;

    protected function configure()
    {
        $this
            ->setName('create')
            ->setDescription('Creates a directory for the new localization')
            ->addArgument(Argument::LOCALE(), InputArgument::REQUIRED, 'Code of the created localization');
    }
}
