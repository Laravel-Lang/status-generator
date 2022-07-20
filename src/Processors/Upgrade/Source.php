<?php

namespace LaravelLang\StatusGenerator\Processors\Upgrade;

use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\StatusGenerator\Processors\Processor;

class Source extends Processor
{
    public function handle(): void
    {
        foreach ($this->files() as $file) {
            $this->output->task('Processing source file: ' . $file, function () use ($file) {
                $path = $this->getSourcePath($file);

                $this->filesystem->store($path, $this->load($path), false, true);
            });
        }
    }

    protected function files(): array
    {
        return File::names($this->getSourcePath(), fn (string $file) => $this->isJson($file), true);
    }
}
