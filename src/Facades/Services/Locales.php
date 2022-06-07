<?php

namespace LaravelLang\StatusGenerator\Facades\Services;

use DragonCode\Support\Facades\Facade;
use LaravelLang\StatusGenerator\Services\Locales as Service;

/**
 * @method static Service load(string $source, string $locales)
 */
class Locales extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Service::class;
    }
}
