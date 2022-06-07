<?php

namespace LaravelLang\StatusGenerator\Facades\Services\Packages;

use DragonCode\Support\Facades\Facade;
use LaravelLang\StatusGenerator\Services\Packages\Package as Service;

/**
 * @method static Service some()
 */
class Package extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Service::class;
    }
}
