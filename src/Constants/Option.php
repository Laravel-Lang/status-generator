<?php

namespace LaravelLang\StatusGenerator\Constants;

use ArchTech\Enums\InvokableCases;

/**
 * @method static string COPY()
 * @method static string DIRECTORY()
 * @method static string FILE()
 * @method static string LOCALE()
 * @method static string PATH()
 * @method static string PROJECT()
 * @method static string URL()
 * @method static string VERSION()
 */
enum Option: string
{
    use InvokableCases;

    case COPY = 'copy';

    case DIRECTORY = 'directory';

    case FILE = 'file';

    case LOCALE = 'locale';

    case PATH = 'path';

    case PROJECT = 'project';

    case URL = 'url';

    case VERSION = 'ver';
}
