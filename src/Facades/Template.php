<?php

namespace LaravelLang\StatusGenerator\Facades;

use DragonCode\Support\Facades\Facade;
use LaravelLang\StatusGenerator\Constants\Stub;
use LaravelLang\StatusGenerator\Services\Template as Service;

/**
 * @method static string read(Stub $stub)
 */
class Template extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Service::class;
    }
}
