<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Sync;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Processors\Processor;

class NotTranslatable extends Processor
{
    public function handle(): void
    {
        $source = $this->getSourceValues();

        foreach ($this->directories() as $locale) {
            $this->output->task('Not translatable for ' . $locale, function () use ($locale, $source) {
                $path = $this->getTargetFilename($locale);

                $target = $this->getNotTranslantable($locale);

                $intersect = $this->compare($source, $target);

                ! empty($intersect) ? $this->store($path, $intersect) : $this->delete($path);
            });
        }

        $this->output->emptyLine();
    }

    protected function compare(array $source, array $target): array
    {
        return array_intersect($target, $source);
    }

    protected function delete(string $path): void
    {
        File::ensureDelete($path);
    }

    protected function store(string $path, array $values): void
    {
        $this->filesystem->store($path, $values, true);
    }

    protected function getSourceValues(): array
    {
        $result = [];

        $this->output->task('Load sources', function () use (&$result) {
            foreach ($this->locales()->getSource() as $values) {
                $result = Arr::addUnique($result, $values);
            }
        });

        return $result;
    }

    protected function getNotTranslantable(string $locale): array
    {
        return $this->locales()->getNotTranslatable($locale);
    }

    protected function getTargetFilename(string $locale): string
    {
        return $this->getLocalesPath($locale . '/_not_translatable.json');
    }
}
