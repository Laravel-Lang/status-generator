<?php

namespace LaravelLang\StatusGenerator\Facades\Services\Filesystem;

use DragonCode\Support\Facades\Facade;
use LaravelLang\StatusGenerator\Services\Filesystem\Archive as Service;

/**
 * @method static void unpack(string $path, string $directory)
 */
class Archive extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Service::class;
    }
}
