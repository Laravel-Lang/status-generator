<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Download;

use LaravelLang\StatusGenerator\Constants\Command;
use LaravelLang\StatusGenerator\Constants\Option;
use LaravelLang\StatusGenerator\Exceptions\IncorrectOptionValueException;

class FailedTest extends Base
{
    public function testUrl(): void
    {
        $this->expectException(IncorrectOptionValueException::class);
        $this->expectExceptionMessage('Option "' . Option::URL() . '" is not defined or has an empty value.');

        $this->command(Command::DOWNLOAD());
    }

    public function testProject(): void
    {
        $this->expectException(IncorrectOptionValueException::class);
        $this->expectExceptionMessage('Option "' . Option::PROJECT() . '" is not defined or has an empty value.');

        $this->command(Command::DOWNLOAD(), [
            Option::URL() => 'https://github.com/laravel/framework/archive/refs/heads/9.x.zip',
        ]);
    }

    public function testVersion(): void
    {
        $this->expectException(IncorrectOptionValueException::class);
        $this->expectExceptionMessage('Option "' . Option::VERSION() . '" is not defined or has an empty value.');

        $this->command(Command::DOWNLOAD(), [
            Option::URL()     => 'https://github.com/laravel/framework/archive/refs/heads/9.x.zip',
            Option::PROJECT() => 'laravel',
        ]);
    }
}
