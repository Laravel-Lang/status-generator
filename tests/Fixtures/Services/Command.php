<?php

namespace Tests\Fixtures\Services;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\StatusGenerator\Commands\Create;
use LaravelLang\StatusGenerator\Commands\Download;
use LaravelLang\StatusGenerator\Commands\Status;
use LaravelLang\StatusGenerator\Commands\Sync;
use LaravelLang\StatusGenerator\Commands\Translate;
use LaravelLang\StatusGenerator\Commands\Upgrade;
use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class Command
{
    public const NAME = 'Laravel Lang: Status Generator';

    public static function call(CommandName $command, array $options = []): void
    {
        $app = self::application()->find($command->value);

        $app->run(self::input($options), self::output());
    }

    protected static function application(): Application
    {
        $app = new Application(self::NAME);

        $app->add(new Create());
        $app->add(new Download());
        $app->add(new Status());
        $app->add(new Sync());
        $app->add(new Translate());
        $app->add(new Upgrade());

        return $app;
    }

    protected static function input(array $options): InputInterface
    {
        return new ArrayInput(self::resolveOptions($options));
    }

    protected static function output(): OutputInterface
    {
        return new ConsoleOutput(OutputInterface::VERBOSITY_QUIET);
    }

    protected static function resolveOptions(array $options): array
    {
        return Arr::renameKeys($options, static fn (string $key) => Str::start($key, '--'));
    }
}
