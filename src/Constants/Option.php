<?php

namespace LaravelLang\StatusGenerator\Constants;

use ArchTech\Enums\InvokableCases;

/**
 * @method static string COLUMNS()
 * @method static string COPY()
 * @method static string DIRECTORY()
 * @method static string FILE()
 * @method static string LOCALE()
 * @method static string ONLY_COPY()
 * @method static string PATH()
 * @method static string PROJECT()
 * @method static string URL()
 * @method static string VERSION()
 */
enum Option: string
{
    use InvokableCases;

    case COLUMNS   = 'columns';
    case COPY      = 'copy';
    case DIRECTORY = 'directory';
    case FILE      = 'file';
    case LOCALE    = 'locale';
    case ONLY_COPY = 'only-copy';
    case PATH      = 'path';
    case PROJECT   = 'project';
    case URL       = 'url';
    case VERSION   = 'ver';
}
