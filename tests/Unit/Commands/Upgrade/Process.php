<?php

namespace Tests\Unit\Commands\Upgrade;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\StatusGenerator\Constants\Option;

class Process extends Base
{
    public function testProcess(): void
    {
        $this->command(CommandName::UPGRADE(), [
            Option::PATH() => $this->temp,
        ]);

        // New structure
        $this->assertFileExists($this->tempPath('locales/ar/_excludes.json'));
        $this->assertFileExists($this->tempPath('locales/ar/json.json'));
        $this->assertFileExists($this->tempPath('locales/ar/php.json'));
        $this->assertFileExists($this->tempPath('locales/ar/php-inline.json'));

        $this->assertFileExists($this->tempPath('locales/en/json.json'));
        $this->assertFileExists($this->tempPath('locales/en/php.json'));
        $this->assertFileExists($this->tempPath('locales/en/php-inline.json'));

        $this->assertFileExists($this->tempPath('locales/ru/_excludes.json'));
        $this->assertFileExists($this->tempPath('locales/ru/json.json'));
        $this->assertFileExists($this->tempPath('locales/ru/php.json'));
        $this->assertFileExists($this->tempPath('locales/ru/php-inline.json'));

        // Old structure
        $this->assertFileDoesNotExist($this->tempPath('app/main/Constants/Referents.php'));

        $this->assertFileDoesNotExist($this->tempPath('excludes/ar.php'));
        $this->assertFileDoesNotExist($this->tempPath('excludes/ru.php'));

        $this->assertFileDoesNotExist($this->tempPath('locales/ar/ar.json'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ar/auth.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ar/pagination.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ar/passwords.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ar/validation.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ar/validation-inline.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ar/validation-nova.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ar/validation-nova-inline.php'));

        $this->assertFileDoesNotExist($this->tempPath('locales/ru/ru.json'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ru/auth.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ru/pagination.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ru/passwords.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ru/validation.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ru/validation-inline.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ru/validation-nova.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/ru/validation-nova-inline.php'));

        $this->assertDirectoryDoesNotExist($this->tempPath('source/packages'));

        $this->assertFileDoesNotExist($this->tempPath('source/auth.php'));
        $this->assertFileDoesNotExist($this->tempPath('source/pagination.php'));
        $this->assertFileDoesNotExist($this->tempPath('source/passwords.php'));
        $this->assertFileDoesNotExist($this->tempPath('source/validation.php'));
        $this->assertFileDoesNotExist($this->tempPath('source/validation-inline.php'));
    }
}
