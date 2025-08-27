<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Create;

use LaravelLang\LocaleList\Locale;
use LaravelLang\StatusGenerator\Constants\Command;
use LaravelLang\StatusGenerator\Constants\Option;
use LaravelLang\StatusGenerator\Exceptions\LocaleAlreadyExistException;

class FailedTest extends Base
{
    public function testAlreadyExists()
    {
        $locale = Locale::German->value;

        $this->command(Command::CREATE, [Option::LOCALE() => $locale]);

        $this->expectException(LocaleAlreadyExistException::class);
        $this->expectExceptionMessage("The \"$locale\" locale already exist.");

        $this->command(Command::CREATE, [Option::LOCALE() => $locale]);
    }
}
