<?php

namespace Tests\Fixtures\Services;

use LaravelLang\StatusGenerator\Commands\Create;
use LaravelLang\StatusGenerator\Commands\Download;
use LaravelLang\StatusGenerator\Commands\Status;
use LaravelLang\StatusGenerator\Commands\Sync;
use LaravelLang\StatusGenerator\Commands\Upgrade;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class Command
{
    public static function call(string $name, array $options = []): void
    {
        $app = self::application()->find($name);

        $app->run(self::input($options), self::output());
    }

    protected static function application(): Application
    {
        $app = new Application('Laravel Lang: Status Generator');

        $app->add(new Create());
        $app->add(new Download());
        $app->add(new Status());
        $app->add(new Sync());
        $app->add(new Upgrade());

        return $app;
    }

    protected static function input(array $options): InputInterface
    {
        $input = new ArrayInput([]);

        foreach ($options as $key => $value) {
            $input->setOption($key, $value);
        }

        return $input;
    }

    protected static function output(): OutputInterface
    {
        return new ConsoleOutput();
    }
}
