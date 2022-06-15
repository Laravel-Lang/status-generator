<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Status;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\StatusGenerator\Processors\Processor;

class CleanUp extends Processor
{
    public function handle(): void
    {
        $this->delete('docs/status.md');
        $this->delete('docs/statuses');
    }

    protected function delete(string $path): void
    {
        if ($path = $this->getPath(true, $path)) {
            is_dir($path)
                ? Directory::ensureDelete($path)
                : File::ensureDelete($path);
        }
    }
}
