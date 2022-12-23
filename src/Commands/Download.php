<?php

namespace LaravelLang\StatusGenerator\Commands;

use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\StatusGenerator\Constants\Option;
use LaravelLang\StatusGenerator\Processors\Download\CleanUp as CleanUpProcessor;
use LaravelLang\StatusGenerator\Processors\Download\Copy as CopyProcessor;
use LaravelLang\StatusGenerator\Processors\Download\Download as DownloadProcessor;
use LaravelLang\StatusGenerator\Processors\Download\Search as SearchProcessor;
use LaravelLang\StatusGenerator\Processors\Download\Unpack as ZipProcessor;
use Symfony\Component\Console\Input\InputOption;

class Download extends Command
{
    protected bool $output_by_processor = true;

    protected array|string $processor = [
        CleanUpProcessor::class,
        DownloadProcessor::class,
        ZipProcessor::class,
        SearchProcessor::class => Option::ONLY_COPY,
        CopyProcessor::class,
        CleanUpProcessor::class,
    ];

    protected function configure(): Command
    {
        return parent::configure()
            ->setName(CommandName::DOWNLOAD())
            ->setDescription('Download and unpack the project')
            ->addOption(Option::URL(), null, InputOption::VALUE_REQUIRED, 'Link to the repository')
            ->addOption(Option::PROJECT(), null, InputOption::VALUE_REQUIRED, 'Project name')
            ->addOption(Option::VERSION(), null, InputOption::VALUE_REQUIRED, 'Project version')
            ->addOption(Option::COPY(), null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Directory within the project from which files will be copied')
            ->addOption(Option::ONLY_COPY(), null, InputOption::VALUE_NONE, 'Specifies when to only copy files without searching for keys');
    }

    protected function extraOptions(): array
    {
        return [
            Option::DIRECTORY() => $this->directory(),
            Option::FILE()      => $this->file(),
        ];
    }

    protected function directory(): string
    {
        return Arr::of()
            ->push($this->getOption(Option::PROJECT))
            ->push($this->getOption(Option::VERSION))
            ->map(static fn (string $value) => trim($value, '\\/'))
            ->implode('/')
            ->toString();
    }

    protected function file(): string
    {
        return Path::basename($this->getOption(Option::URL));
    }
}
