<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Status;

use LaravelLang\StatusGenerator\Constants\Command;
use Tests\TestCase;

abstract class Base extends TestCase
{
    protected ?string $fixtures = __DIR__ . '/../../../Fixtures/Resources/Status';

    protected ?Command $call = Command::STATUS;
}
