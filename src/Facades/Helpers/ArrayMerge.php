<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Facades\Helpers;

use DragonCode\Support\Facades\Facade;
use LaravelLang\StatusGenerator\Helpers\ArrayMerge as Helper;

/**
 * @method static array merge(array $source, array $target)
 */
class ArrayMerge extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
