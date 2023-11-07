<?php

namespace Tests\Unit\Commands\Create;

use LaravelLang\Locales\Enums\Locale;
use LaravelLang\StatusGenerator\Constants\Command;
use LaravelLang\StatusGenerator\Constants\Option;

class SuccessTest extends Base
{
    public function testOne(): void
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

    public function testMissing(): void
    {
        $installed = [Locale::German->value, Locale::French->value, Locale::Finnish->value];

        foreach ($installed as $locale) {
            $this->command(Command::CREATE, [Option::LOCALE() => $locale]);

            $this->assertDirectoryExists($this->tempPath('locales/' . $locale));

            $this->assertFileExists($this->tempPath("locales/$locale/json.json"));
            $this->assertFileExists($this->tempPath("locales/$locale/php.json"));
        }

        foreach (Locale::values() as $locale) {
            if ($locale === 'en' || in_array($locale, $installed, true)) {
                $this->assertDirectoryExists($this->tempPath('locales/' . $locale));

                $this->assertFileExists($this->tempPath("locales/$locale/json.json"));
                $this->assertFileExists($this->tempPath("locales/$locale/php.json"));

                continue;
            }

            $this->assertDirectoryDoesNotExist($this->tempPath('locales/' . $locale));

            $this->assertFileDoesNotExist($this->tempPath("locales/$locale/json.json"));
            $this->assertFileDoesNotExist($this->tempPath("locales/$locale/php.json"));
        }

        $this->command(Command::CREATE);

        foreach (Locale::values() as $locale) {
            $this->assertDirectoryExists($this->tempPath('locales/' . $locale));

            $this->assertFileExists($this->tempPath("locales/$locale/json.json"));
            $this->assertFileExists($this->tempPath("locales/$locale/php.json"));
        }
    }

    public function testWithoutMissing(): void
    {
        $installed = [Locale::German->value, Locale::French->value, Locale::Finnish->value];

        foreach ($installed as $locale) {
            $this->command(Command::CREATE, [Option::LOCALE() => $locale]);

            $this->assertDirectoryExists($this->tempPath('locales/' . $locale));

            $this->assertFileExists($this->tempPath("locales/$locale/json.json"));
            $this->assertFileExists($this->tempPath("locales/$locale/php.json"));
        }

        foreach (Locale::values() as $locale) {
            if ($locale === 'en' || in_array($locale, $installed, true)) {
                $this->assertDirectoryExists($this->tempPath('locales/' . $locale));

                $this->assertFileExists($this->tempPath("locales/$locale/json.json"));
                $this->assertFileExists($this->tempPath("locales/$locale/php.json"));

                continue;
            }

            $this->assertDirectoryDoesNotExist($this->tempPath('locales/' . $locale));

            $this->assertFileDoesNotExist($this->tempPath("locales/$locale/json.json"));
            $this->assertFileDoesNotExist($this->tempPath("locales/$locale/php.json"));
        }

        $this->command(Command::CREATE);

        foreach (Locale::values() as $locale) {
            $this->assertDirectoryExists($this->tempPath('locales/' . $locale));

            $this->assertFileExists($this->tempPath("locales/$locale/json.json"));
            $this->assertFileExists($this->tempPath("locales/$locale/php.json"));
        }

        $this->command(Command::CREATE);

        foreach (Locale::values() as $locale) {
            $this->assertDirectoryExists($this->tempPath('locales/' . $locale));

            $this->assertFileExists($this->tempPath("locales/$locale/json.json"));
            $this->assertFileExists($this->tempPath("locales/$locale/php.json"));
        }
    }
}
