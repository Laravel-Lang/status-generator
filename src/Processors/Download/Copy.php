<?php

namespace LaravelLang\StatusGenerator\Processors\Download;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Filesystem\Path;
use LaravelLang\StatusGenerator\Constants\Argument;
use LaravelLang\StatusGenerator\Processors\Processor;

class Copy extends Processor
{
    public function handle(): void
    {
        foreach ($this->directories() as $directory) {
            $path = $this->tempDirectory() . '/' . $this->getProject() . '-' . $this->getVersion() . '/' . $directory;

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

    protected function directories(): array
    {
        return $this->parameter(Argument::COPY());
    }

    protected function tempDirectory(): string
    {
        return $this->getPath(true, 'tmp/' . $this->getDirectory());
    }

    protected function targetPath(string $filename): string
    {
        return $this->getSourcePath('packages/' . $this->getProject() . '/' . $this->getVersion() . '/' . $filename, false);
    }

    protected function getDirectory(): string
    {
        return $this->parameter(Argument::DIRECTORY());
    }

    protected function getProject(): string
    {
        return $this->parameter(Argument::PROJECT());
    }

    protected function getVersion(): string
    {
        return $this->parameter(Argument::VERSION());
    }
}
