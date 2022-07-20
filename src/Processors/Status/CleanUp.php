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
        $this->output->task('Clean Up', function () {
            $this->delete('status.md');
            $this->delete('statuses');
        });

        $this->output->emptyLine();
    }

    protected function delete(string $path): void
    {
        if ($path = $this->getDocsPath($path, true)) {
            is_dir($path)
                ? Directory::ensureDelete($path)
                : File::ensureDelete($path);
        }
    }
}
