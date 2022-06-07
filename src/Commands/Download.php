<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Constants\Argument;
use LaravelLang\StatusGenerator\Processors\Download as DownloadProcessor;
use Symfony\Component\Console\Input\InputOption;

class Download extends Command
{
    protected array|string $processor = DownloadProcessor::class;

    protected function configure()
    {
        $this
            ->setName('download')
            ->setDescription('Download and unpack the project')
            ->addOption(Argument::URL(), null, InputOption::VALUE_REQUIRED, 'Link to the repository')
            ->addOption(Argument::PROJECT(), null, InputOption::VALUE_REQUIRED, 'Project name')
            ->addOption(Argument::VERSION(), null, InputOption::VALUE_REQUIRED, 'Project version')
            ->addOption(Argument::COPY(), null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Directory within the project from which files will be copied');
    }
}
