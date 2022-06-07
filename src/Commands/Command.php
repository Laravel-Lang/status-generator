<?php

namespace LaravelLang\StatusGenerator\Commands;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Contracts\Processor;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Command extends BaseCommand
{
    protected InputInterface $input;

    protected OutputInterface $output;

    /** @var string|array<string|Processor> */
    protected array|string $processor;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input  = $input;
        $this->output = $output;

        $this->handle();

        return 0;
    }

    protected function handle(): void
    {
        foreach ($this->resolveProcessors() as $processor) {
            $this->output->writeln(sprintf('Processing: %s...', get_class($processor)));

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
        if ($this->input->hasArgument('path')) {
            return $this->input->getArgument('path');
        }

        return realpath('.');
    }

    protected function getParameters(): array
    {
        return array_merge($this->getArguments(), $this->getOptions(), $this->extraParameters());
    }

    protected function getArguments(): array
    {
        return $this->input->getArguments();
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

    protected function extraParameters(): array
    {
        return [];
    }
}
