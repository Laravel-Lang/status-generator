<?php

namespace LaravelLang\StatusGenerator\Services\Filesystem;

use RuntimeException;
use ZipArchive;

class Archive
{
    public function __construct(
        protected ZipArchive $zip = new ZipArchive()
    ) {}

    public function unpack(string $path, string $directory): void
    {
        if ($this->zip->open($path)) {
            $this->zip->extractTo($directory);
            $this->zip->close();
        }
        else {
            throw new RuntimeException('Cannot unpack file: ' . realpath($path));
        }
    }
}
