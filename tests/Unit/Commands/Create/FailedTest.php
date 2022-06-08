<?php

namespace Tests\Unit\Commands\Create;

use LaravelLang\StatusGenerator\Constants\Command;
use LaravelLang\StatusGenerator\Exceptions\UnknownOptionException;

class FailedTest extends Base
{
    public function testFailed(): void
    {
        $this->expectException(UnknownOptionException::class);
        $this->expectExceptionMessage('Option "locale" is not defined or has an empty value.');

        $this->command(Command::CREATE());
    }
}
