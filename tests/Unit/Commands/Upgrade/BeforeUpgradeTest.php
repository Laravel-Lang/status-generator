<?php

namespace Tests\Unit\Commands\Upgrade;

class BeforeUpgradeTest extends Base
{
    public function testBefore(): void
    {
        $this->assertFileExists($this->tempPath('app/main/Constants/Referents.php'));

        $this->assertFileExists($this->tempPath('excludes/ar.php'));
        $this->assertFileExists($this->tempPath('excludes/ru.php'));

        $this->assertFileExists($this->tempPath('locales/ar/ar.json'));
        $this->assertFileExists($this->tempPath('locales/ar/auth.php'));
        $this->assertFileExists($this->tempPath('locales/ar/pagination.php'));
        $this->assertFileExists($this->tempPath('locales/ar/passwords.php'));
        $this->assertFileExists($this->tempPath('locales/ar/validation.php'));
        $this->assertFileExists($this->tempPath('locales/ar/validation-inline.php'));
        $this->assertFileExists($this->tempPath('locales/ar/validation-nova.php'));
        $this->assertFileExists($this->tempPath('locales/ar/validation-nova-inline.php'));

        $this->assertFileExists($this->tempPath('locales/ru/ru.json'));
        $this->assertFileExists($this->tempPath('locales/ru/auth.php'));
        $this->assertFileExists($this->tempPath('locales/ru/pagination.php'));
        $this->assertFileExists($this->tempPath('locales/ru/passwords.php'));
        $this->assertFileExists($this->tempPath('locales/ru/validation.php'));
        $this->assertFileExists($this->tempPath('locales/ru/validation-inline.php'));
        $this->assertFileExists($this->tempPath('locales/ru/validation-nova.php'));
        $this->assertFileExists($this->tempPath('locales/ru/validation-nova-inline.php'));

        $this->assertDirectoryExists($this->tempPath('source/packages'));

        $this->assertFileExists($this->tempPath('source/auth.php'));
        $this->assertFileExists($this->tempPath('source/pagination.php'));
        $this->assertFileExists($this->tempPath('source/passwords.php'));
        $this->assertFileExists($this->tempPath('source/validation.php'));
        $this->assertFileExists($this->tempPath('source/validation-inline.php'));
    }
}
