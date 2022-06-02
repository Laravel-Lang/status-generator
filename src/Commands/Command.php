<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Contracts\Processor;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Command extends BaseCommand
{
    protected InputInterface $input;

    protected OutputInterface $output;

    protected string|Processor $processor;

    protected array $arguments = [];

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input  = $input;
        $this->output = $output;

        $this->handle();

        return 0;
    }

    protected function handle(): void
    {
        $this->resolveProcessor()->handle();
    }

    protected function resolveProcessor(): Processor
    {
        return new $this->processor($this->output, $this->basePath(), $this->getArguments());
    }

    protected function basePath(): string
    {
        if ($this->input->hasArgument('path')) {
            return $this->input->getArgument('path');
        }

        return realpath('.');
    }

    protected function getArguments(): array
    {
        return $this->input->getArguments();
    }
}
