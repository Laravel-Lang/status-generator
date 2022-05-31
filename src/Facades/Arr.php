<?php

namespace LaravelLang\StatusGenerator\Facades;

use Helldar\Support\Facades\Facade;
use LaravelLang\StatusGenerator\Helpers\Arr as Helper;

/**
 * @method static array flatten(array $array)
 */
class Arr extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
