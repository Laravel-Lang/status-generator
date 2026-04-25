<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\StatusGenerator\Constants\Option;
use LaravelLang\StatusGenerator\Processors\Sync\Actualize as ActualizeProcessor;
use LaravelLang\StatusGenerator\Processors\Sync\Excludes as ExcludesProcessor;
use LaravelLang\StatusGenerator\Processors\Sync\NotTranslatable as NotTranslatableProcessor;
use Symfony\Component\Console\Input\InputOption;

class Sync extends Command
{
    protected array|string $processor = [
        ExcludesProcessor::class,
        NotTranslatableProcessor::class,
        ActualizeProcessor::class,
    ];

    protected function configure(): void
    {
        $this
            ->setName(CommandName::SYNC())
            ->setDescription('Updates translation keys')
            ->addOption(Option::PATH(), null, InputOption::VALUE_OPTIONAL, 'Path to project files');
    }
}
