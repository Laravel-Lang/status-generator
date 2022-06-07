<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Concerns\HttpClient;
use LaravelLang\StatusGenerator\Constants\Argument;
use LaravelLang\StatusGenerator\Facades\Services\Filesystem\Archive;
use LaravelLang\StatusGenerator\Facades\Services\Packages\Package;

class Download extends Processor
{
    use HttpClient;

    protected ?string $temp_directory = null;

    public function handle(): void
    {
        $path = $this->tempPath();

        $directory = dirname($path);

        $this->cleanUp($directory);

        $this->get($path);
        $this->unpack($path, $directory);
        $this->search($directory);
        $this->copy();

        $this->cleanUp($directory);
    }

    protected function cleanUp(string $path): void
    {
        Directory::ensureDelete($path);
    }

    protected function get(string $path): void
    {
        $this->client()->download($this->getUrl(), $path);
    }

    protected function unpack(string $path, string $directory): void
    {
        Archive::unpack($path, $directory);
    }

    protected function search(string $path): void
    {
        $content = Package::some()->path($path)->content();

        $this->filesystem->store($this->getTargetPath(true), $content, false, true);
    }

    protected function copy(): void
    {
        if ($directories = $this->parameter(Argument::COPY())) {
            foreach ($directories as $directory) {
                $path = $this->tempDirectory() . '/' . $this->getProject() . '-' . $this->getVersion() . '/' . $directory;

                if (Directory::exists($path)) {
                    foreach (File::names($path, recursive: true) as $name) {
                        $source = $path . '/' . $name;

                        $target = $this->getTargetPath() . Path::basename($name);

                        File::copy($source, $target);
                    }
                }
            }
        }
    }

    protected function tempPath(): string
    {
        return $this->getPath(false, $this->tempDirectory() . '/' . $this->tempFilename());
    }

    protected function tempDirectory(): string
    {
        if (! empty($this->temp_directory)) {
            return $this->temp_directory;
        }

        return $this->temp_directory = Arr::of([])
            ->push('tmp')
            ->push($this->getProject())
            ->push($this->getVersion())
            ->map(static fn (string $value) => trim($value, '\\/'))
            ->implode('/')
            ->toString();
    }

    protected function tempFilename(): string
    {
        return Path::basename($this->getUrl());
    }

    protected function getTargetPath(bool $with_filename = false): string
    {
        $filename = $with_filename ? '/' . $this->getTargetFilename() : null;

        return $this->getSourcePath('packages/' . $this->getProject() . '/' . $this->getVersion() . '/' . $filename, false);
    }

    protected function getTargetFilename(): string
    {
        return $this->getProject() . '.json';
    }

    protected function getProject(): string
    {
        return $this->parameter(Argument::PROJECT());
    }

    protected function getVersion(): string
    {
        return $this->parameter(Argument::VERSION());
    }

    protected function getUrl(): string
    {
        return $this->parameter(Argument::URL());
    }
}
