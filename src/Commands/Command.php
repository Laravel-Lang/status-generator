<?php

namespace LaravelLang\StatusGenerator\Commands;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Concerns\Commands\ValidateOptions;
use LaravelLang\StatusGenerator\Constants\Option;
use LaravelLang\StatusGenerator\Contracts\Processor;
use LaravelLang\StatusGenerator\Helpers\Output;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Command extends BaseCommand
{
    use ValidateOptions;

    protected InputInterface $input;

    protected Output $output;

    /** @var string|array<string|Processor> */
    protected array|string $processor;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input  = $input;
        $this->output = Output::make($this->input, $output);

        $this->validateOptions();
        $this->handle();

        return 0;
    }

    protected function configure(): Command
    {
        return $this->addOption(Option::PATH(), null, InputOption::VALUE_OPTIONAL, 'Path to project files');
    }

    protected function handle(): void
    {
        foreach ($this->resolveProcessors() as $processor) {
            $this->output->info(get_class($processor));

            $processor->handle();
        }
    }

    /**
     * @return array<Processor>
     */
    protected function resolveProcessors(): array
    {
        return Arr::map((array) $this->processor, fn (string $processor) => new $processor($this->output, $this->basePath(), $this->getParameters()));
    }

    protected function basePath(): string
    {
        if ($this->input->hasOption(Option::PATH()) && $path = $this->input->getOption(Option::PATH())) {
            return realpath($path);
        }

        return realpath('.');
    }

    protected function getParameters(): array
    {
        return array_merge($this->getOptions(), $this->extraOptions());
    }

    protected function getArgument(string $name): mixed
    {
        return $this->input->getArgument($name);
    }

    protected function getOptions(): array
    {
        return $this->input->getOptions();
    }

    protected function getOption(string $name): mixed
    {
        return $this->input->getOption($name);
    }

    protected function extraOptions(): array
    {
        return [];
    }
}
