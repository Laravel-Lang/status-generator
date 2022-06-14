<?php

namespace Tests;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\Concerns\Commands;

abstract class TestCase extends BaseTestCase
{
    use Commands;

    protected ?string $fixtures = null;

    protected string $temp = __DIR__ . '/tmp';

    protected function setUp(): void
    {
        parent::setUp();

        $this->cleanUp();
        $this->copyFixtures();
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

    protected function tempPath(string $filename): string
    {
        return $this->temp . '/' . $filename;
    }
}
