<?php

namespace Tests\Unit\Commands\Create;

use LaravelLang\StatusGenerator\Constants\Command;
use LaravelLang\StatusGenerator\Constants\Option;
use LaravelLang\StatusGenerator\Exceptions\IncorrectOptionValueException;

class FailedTest extends Base
{
    public function testUrl(): void
    {
        $this->expectException(IncorrectOptionValueException::class);
        $this->expectExceptionMessage('Option "' . Option::LOCALE() . '" is not defined or has an empty value.');

        $this->command(Command::CREATE);
    }
}
