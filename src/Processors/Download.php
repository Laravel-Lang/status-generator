<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors;

use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\StatusGenerator\Concerns\HttpClient;
use LaravelLang\StatusGenerator\Constants\Argument;

class Download extends Processor
{
    use HttpClient;

    protected ?string $temp_directory = null;

    public function handle(): void
    {
        $path      = $this->tempPath();
        $directory = $this->tempDirectory();

        $this->get($path);
        $this->unpack($path);
        $this->search($directory);
        $this->copy();
    }

    protected function get(string $path): void
    {
        $this->client()->download($this->getUrl(), $path);
    }

    protected function unpack(string $path): void
    {
        // unpack files
    }

    protected function copy(): void
    {
        if ($directory = $this->parameter(Argument::COPY())) {
            // copy directory
        }
    }

    protected function search(string $path): void
    {
        // search translations
    }

    protected function tempPath(): string
    {
        return $this->tempDirectory() . '/' . $this->tempFilename();
    }

    protected function tempDirectory(): string
    {
        if (! empty($this->temp_directory)) {
            return $this->temp_directory;
        }

        return $this->temp_directory = Str::of(microtime())->slug()->prepend('tmp/')->toString();
    }

    protected function tempFilename(): string
    {
        return Path::basename($this->getUrl());
    }

    protected function getUrl(): string
    {
        return $this->parameter(Argument::URL());
    }
}
