<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Sync;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use Tests\TestCase;

abstract class Base extends TestCase
{
    protected ?string $fixtures = __DIR__ . '/../../../Fixtures/Resources/Sync';

    protected ?CommandName $call = CommandName::SYNC;

    protected int $call_tries = 5;
}
