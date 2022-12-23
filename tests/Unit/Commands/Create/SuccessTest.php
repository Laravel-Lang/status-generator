<?php

namespace Tests\Unit\Commands\Create;

use LaravelLang\StatusGenerator\Constants\Command;
use LaravelLang\StatusGenerator\Constants\Option;

class SuccessTest extends Base
{
    public function testCreate(): void
    {
        $this->assertDirectoryExists($this->tempPath('locales/en'));
        $this->assertDirectoryDoesNotExist($this->tempPath('locales/de'));

        $this->command(Command::CREATE, [
            Option::LOCALE() => 'de',
        ]);

        $this->assertDirectoryExists($this->tempPath('locales/en'));
        $this->assertDirectoryExists($this->tempPath('locales/de'));

        $this->assertFileExists($this->tempPath('locales/de/json.json'));
        $this->assertFileExists($this->tempPath('locales/de/php.json'));
    }
}
