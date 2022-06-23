<?php

declare(strict_types=1);

namespace LaravelLang\StatusGeneratorTests\Concerns;

use DragonCode\Support\Facades\Filesystem\Directory;
use LaravelLang\StatusGenerator\Services\Locales as LocalesService;

trait Locales
{
    protected ?LocalesService $locales;

    protected function locales(): array
    {
        return Directory::names($this->getPath('locales'));
    }

    protected function source(): array
    {
        return $this->localesService()->getSource();
    }

    protected function locale(string $locale): array
    {
        return $this->localesService()->getLocale($locale);
    }

    protected function excludes(string $locale): array
    {
        return $this->localesService()->getExcludes($locale);
    }

    protected function localesService(): LocalesService
    {
        if (! empty($this->locales)) {
            return $this->locales;
        }

        return $this->locales = (new LocalesService())->load(
            $this->getPath('source'),
            $this->getPath('locales')
        );
    }
}
