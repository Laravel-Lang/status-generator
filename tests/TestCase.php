<?php

namespace Tests;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\Config\ServiceProvider as ConfigServiceProvider;
use LaravelLang\StatusGenerator\Services\Filesystem\Manager;
use LaravelLang\Translator\ServiceProvider as TranslatorServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Concerns\Commands;

abstract class TestCase extends BaseTestCase
{
    use Commands;

    protected ?string $fixtures = null;

    protected string $temp = __DIR__ . '/tmp';

    protected ?Manager $filesystem = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setFilesystem();
        $this->cleanUp();
        $this->copyFixtures();
        $this->runCommand();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ConfigServiceProvider::class,
            TranslatorServiceProvider::class,
        ];
    }

    protected function cleanUp(): void
    {
        Directory::ensureDelete($this->temp);
    }

    protected function copyFixtures(): void
    {
        if ($this->fixtures) {
            foreach (File::names($this->fixtures, recursive: true) as $filename) {
                $source = rtrim($this->fixtures, '\\/') . '/' . $filename;
                $target = rtrim($this->temp, '\\/') . '/' . $filename;

                File::copy($source, $target);
            }
        }
    }

    protected function setFilesystem(): void
    {
        $this->filesystem = new Manager();
    }

    protected function tempPath(string $filename): string
    {
        return $this->temp . '/' . $filename;
    }

    protected function assertJsonFileEqualsJson(array $expected, string $actual_file, string $method): void
    {
        $message = static::class . '::' . $method . '()';

        $this->assertSame($expected, $this->filesystem->load($this->tempPath($actual_file)), $message);
    }
}
