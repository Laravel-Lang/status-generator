<?php

namespace LaravelLang\StatusGenerator\Processors\Download;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Filesystem\Path;
use LaravelLang\StatusGenerator\Processors\Processor;

class Copy extends Processor
{
    public function handle(): void
    {
        foreach ($this->getCopyParameter() as $directory) {
            $path = $this->tempDirectory() . '/' . $this->getProjectParameter() . '-' . $this->getVersionParameter() . '/' . $directory;

            if (Directory::exists($path)) {
                $files = $this->files($path);

                $this->process($path, $files);
            }
        }
    }

    protected function process(string $path, array $files): void
    {
        foreach ($files as $file) {
            $basename = Path::basename($file);

            $source = $path . '/' . $file;

            $target = $this->targetPath($basename);

            File::copy($source, $target);
        }
    }

    protected function files(string $path): array
    {
        return File::names($path, recursive: true);
    }

    protected function tempDirectory(): string
    {
        return $this->getPath(true, 'tmp/' . $this->getDirectoryParameter());
    }

    protected function targetPath(string $filename): string
    {
        return $this->getSourcePath('packages/' . $this->getProjectParameter() . '/' . $this->getVersionParameter() . '/' . $filename, false);
    }
}
