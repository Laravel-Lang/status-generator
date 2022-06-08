<?php

namespace Tests\Concerns;

use Tests\Fixtures\Models\CommandResult;
use Tests\Fixtures\Services\Command;

/** @mixin \Tests\TestCase */
trait Commands
{
    protected function command(string $name, array $options = []): CommandResult
    {
        return Command::call($name, $options);
    }
}
