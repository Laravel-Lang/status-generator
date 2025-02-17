<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Helpers;

use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Instances\Call;
use Illuminate\Console\OutputStyle;
use Illuminate\Console\View\Components\Factory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method static Output make(InputInterface $input, OutputInterface $output)
 */
class Output
{
    use Makeable;

    /** @var Factory */
    protected mixed $components = null;

    public function __construct(
        protected InputInterface $input,
        protected OutputInterface $output
    ) {}

    public function info(string $message): void
    {
        $this->when(
            $this->hasComponent(),
            fn () => $this->component()->info($message),
            fn () => $this->output->writeln($message)
        );
    }

    public function task(string $message, callable $callback): void
    {
        $this->when(
            $this->hasComponent(),
            fn () => $this->component()->task($message, $callback),
            fn () => $this->simpleTask($message, $callback)
        );
    }

    public function emptyLine(): void
    {
        $this->output->writeln('');
    }

    protected function when(bool $when, callable $callback, ?callable $fallback = null): void
    {
        if ($when) {
            Call::callback($callback);

            return;
        }

        if (! empty($fallback)) {
            Call::callback($fallback);
        }
    }

    protected function simpleTask(string $message, callable $callback): void
    {
        $this->output->writeln($message);

        Call::callback($callback);
    }

    protected function hasComponent(): bool
    {
        return class_exists(Factory::class);
    }

    protected function component(): Factory
    {
        if (! empty($this->components)) {
            return $this->components;
        }

        return $this->components = new Factory($this->illuminateOutput());
    }

    protected function illuminateOutput(): OutputStyle
    {
        return new OutputStyle($this->input, $this->output);
    }
}
