<?php

namespace LaravelLang\StatusGenerator\Commands;

use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Constants\Argument;
use LaravelLang\StatusGenerator\Processors\Download\Archive as ZipProcessor;
use LaravelLang\StatusGenerator\Processors\Download\CleanUp as CleanUpProcessor;
use LaravelLang\StatusGenerator\Processors\Download\Copy as CopyProcessor;
use LaravelLang\StatusGenerator\Processors\Download\Download as DownloadProcessor;
use LaravelLang\StatusGenerator\Processors\Download\Search as SearchProcessor;
use Symfony\Component\Console\Input\InputOption;

class Download extends Command
{
    protected array|string $processor = [
        CleanUpProcessor::class,
        DownloadProcessor::class,
        ZipProcessor::class,
        SearchProcessor::class,
        CopyProcessor::class,
    ];

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

    protected function extraParameters(): array
    {
        return [
            Argument::DIRECTORY() => $this->directory(),
            Argument::FILE()      => $this->file(),
        ];
    }

    protected function directory(): string
    {
        return Arr::of([])
            ->push($this->getOption(Argument::PROJECT()))
            ->push($this->getOption(Argument::VERSION()))
            ->map(static fn (string $value) => trim($value, '\\/'))
            ->implode('/')
            ->toString();
    }

    protected function file(): string
    {
        return Path::basename($this->getOption(Argument::URL()));
    }
}
