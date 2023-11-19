<?php

namespace LaravelLang\StatusGenerator\Commands;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Facades\Instances\Instance;
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

    protected bool $output_by_processor = false;

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
        $this->output_by_processor
            ? $this->handleByProcessor()
            : $this->handleMain();
    }

    protected function handleMain(): void
    {
        foreach ($this->resolveProcessors() as $processor) {
            $name = $this->getClassBasename($processor);

            $this->output->info(
                Str::of($name)->snake()->replace('_', ' ')->title()->toString()
            );

            $processor->handle();
        }
    }

    protected function handleByProcessor(): void
    {
        $this->output->info(static::class);

        foreach ($this->resolveProcessors() as $processor) {
            $name = $this->getClassBasename($processor);

            $this->output->task($name, fn () => $processor->handle());
        }
    }

    /**
     * @return array<Processor>
     */
    protected function resolveProcessors(): array
    {
        return Arr::map(
            $this->getProcessors(),
            fn (string $processor) => new $processor($this->output, $this->basePath(), $this->getParameters())
        );
    }

    protected function getProcessors(): array
    {
        return Arr::of((array) $this->processor)
            ->filter(fn (Option|string $option) => is_string($option) || ! $this->getOption($option))
            ->map(fn (Option|string $item, int|string $key) => is_string($item) ? $item : $key)
            ->toArray();
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

    protected function getOption(Option|string $name): mixed
    {
        return $this->input->getOption($name->value ?? $name);
    }

    protected function extraOptions(): array
    {
        return [];
    }

    protected function getClassBasename(object|string $class): string
    {
        return Instance::basename($class);
    }
}
