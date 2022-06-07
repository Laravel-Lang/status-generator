<?php

namespace LaravelLang\StatusGenerator\Constants;

use ArchTech\Enums\InvokableCases;

/**
 * @method static string LOCALE()
 */
enum Argument: string
{
    use InvokableCases;

    case LOCALE = 'locale';
}
