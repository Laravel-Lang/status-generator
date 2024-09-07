<?php

namespace Tests\Concerns;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\StatusGenerator\Constants\Option;
use Tests\Fixtures\Services\Command;

/** @mixin \Tests\TestCase */
trait Commands
{
    protected ?CommandName $call = null;

    protected array $call_options = [];

    protected int $call_tries = 1;

    protected function command(CommandName $name, array $options = []): void
    {
        Command::call($name, array_merge([Option::PATH() => $this->temp], $options));
    }

    protected function runCommand(): void
    {
        if ($name = $this->call) {
            for ($i = 0; $i < $this->call_tries; $i++) {
                $this->command($name, $this->call_options);
            }
        }
    }
}
