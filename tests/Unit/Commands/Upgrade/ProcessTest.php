<?php

namespace Tests\Unit\Commands\Upgrade;

use LaravelLang\StatusGenerator\Constants\Command;

class ProcessTest extends Base
{
    public function testProcess(): void
    {
        $this->command(Command::UPGRADE());

        // New structure
        $this->assertFileExists($this->tempPath('locales/af/_excludes.json'));
        $this->assertFileExists($this->tempPath('locales/af/json.json'));
        $this->assertFileExists($this->tempPath('locales/af/php.json'));
        $this->assertFileExists($this->tempPath('locales/af/php-inline.json'));

        $this->assertFileExists($this->tempPath('locales/en/json.json'));
        $this->assertFileExists($this->tempPath('locales/en/php.json'));
        $this->assertFileExists($this->tempPath('locales/en/php-inline.json'));

        $this->assertFileExists($this->tempPath('locales/de/_excludes.json'));
        $this->assertFileExists($this->tempPath('locales/de/json.json'));
        $this->assertFileExists($this->tempPath('locales/de/php.json'));
        $this->assertFileExists($this->tempPath('locales/de/php-inline.json'));

        // Old structure
        $this->assertFileDoesNotExist($this->tempPath('app/main/Constants/Referents.php'));

        $this->assertFileDoesNotExist($this->tempPath('excludes/af.php'));
        $this->assertFileDoesNotExist($this->tempPath('excludes/de.php'));

        $this->assertFileDoesNotExist($this->tempPath('locales/af/af.json'));
        $this->assertFileDoesNotExist($this->tempPath('locales/af/auth.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/af/pagination.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/af/passwords.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/af/validation.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/af/validation-inline.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/af/validation-nova.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/af/validation-nova-inline.php'));

        $this->assertFileDoesNotExist($this->tempPath('locales/de/de.json'));
        $this->assertFileDoesNotExist($this->tempPath('locales/de/auth.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/de/pagination.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/de/passwords.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/de/validation.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/de/validation-inline.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/de/validation-nova.php'));
        $this->assertFileDoesNotExist($this->tempPath('locales/de/validation-nova-inline.php'));

        $this->assertFileDoesNotExist($this->tempPath('source/packages/framework/laravel-9.json'));
        $this->assertFileDoesNotExist($this->tempPath('source/packages/ui.json'));

        $this->assertFileDoesNotExist($this->tempPath('source/auth.php'));
        $this->assertFileDoesNotExist($this->tempPath('source/pagination.php'));
        $this->assertFileDoesNotExist($this->tempPath('source/passwords.php'));
        $this->assertFileDoesNotExist($this->tempPath('source/validation.php'));
        $this->assertFileDoesNotExist($this->tempPath('source/validation-inline.php'));
    }
}
