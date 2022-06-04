<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Upgrade;

use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\StatusGenerator\Processors\Processor;

class Referents extends Processor
{
    public function handle(): void
    {
        if ($this->exists()) {

        }
    }

    protected function exists(): bool
    {
        return File::exists($this->getSourceReferents());
    }

    protected function getSourceReferents(): string
    {
        return $this->getPath(false, 'app/main/Constants/Referents.php');
    }

    protected function getTargetReferents(): string
    {
        return $this->getPath(false, 'docs/referents.md');
    }
}
