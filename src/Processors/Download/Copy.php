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
        foreach ($this->getAllDirectories() as $project) {
            foreach ($this->getCopyParameter() as $directory) {
                $path = $this->targetDirectory($project, $directory);

                if (Directory::exists($path)) {
                    $files = $this->files($path);

                    $this->process($path, $files);
                }
            }
        }
    }

    protected function process(string $path, array $files): void
    {
        foreach ($files as $file) {
            $basename = Path::basename($file);

            $source = $path . '/' . $file;

            $target = $this->targetPath($basename);

            $source_content = $this->filesystem->loadIfExists($source);
            $target_content = $this->filesystem->loadIfExists($target);

            $this->filesystem->store($target, array_merge($target_content, $source_content), false);
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
        return $this->getSourcePath(
            $this->getProjectParameter() . '/' . $this->getVersionParameter() . '/' . $filename,
            false
        );
    }

    protected function targetDirectory(string $project, string $version): string
    {
        return implode('/', [$this->tempDirectory(), $project, $version]);
    }

    protected function getAllDirectories(): array
    {
        return Directory::names($this->tempDirectory());
    }
}
