<?php

namespace Tests\Unit\Commands\Upgrade;

class BeforeTest extends Base
{
    public function testBefore(): void
    {
        $this->assertFileExists($this->tempPath('app/main/Constants/Referents.php'));

        $this->assertFileExists($this->tempPath('excludes/af.php'));
        $this->assertFileExists($this->tempPath('excludes/de.php'));

        $this->assertFileExists($this->tempPath('locales/af/af.json'));
        $this->assertFileExists($this->tempPath('locales/af/auth.php'));
        $this->assertFileExists($this->tempPath('locales/af/pagination.php'));
        $this->assertFileExists($this->tempPath('locales/af/passwords.php'));
        $this->assertFileExists($this->tempPath('locales/af/validation.php'));
        $this->assertFileExists($this->tempPath('locales/af/validation-inline.php'));
        $this->assertFileExists($this->tempPath('locales/af/validation-nova.php'));
        $this->assertFileExists($this->tempPath('locales/af/validation-nova-inline.php'));

        $this->assertFileExists($this->tempPath('locales/de/de.json'));
        $this->assertFileExists($this->tempPath('locales/de/auth.php'));
        $this->assertFileExists($this->tempPath('locales/de/pagination.php'));
        $this->assertFileExists($this->tempPath('locales/de/passwords.php'));
        $this->assertFileExists($this->tempPath('locales/de/validation.php'));
        $this->assertFileExists($this->tempPath('locales/de/validation-inline.php'));
        $this->assertFileExists($this->tempPath('locales/de/validation-nova.php'));
        $this->assertFileExists($this->tempPath('locales/de/validation-nova-inline.php'));

        $this->assertFileExists($this->tempPath('source/packages/framework/laravel-9.json'));
        $this->assertFileExists($this->tempPath('source/packages/ui.json'));

        $this->assertFileExists($this->tempPath('source/auth.php'));
        $this->assertFileExists($this->tempPath('source/pagination.php'));
        $this->assertFileExists($this->tempPath('source/passwords.php'));
        $this->assertFileExists($this->tempPath('source/validation.php'));
        $this->assertFileExists($this->tempPath('source/validation-inline.php'));
    }
}
