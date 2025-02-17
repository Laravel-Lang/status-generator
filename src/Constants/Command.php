<?php

namespace LaravelLang\StatusGenerator\Constants;

use ArchTech\Enums\InvokableCases;

/**
 * @method static string CREATE()
 * @method static string DOWNLOAD()
 * @method static string STATUS()
 * @method static string SYNC()
 * @method static string TRANSLATE()
 * @method static string UPGRADE()
 */
enum Command: string
{
    use InvokableCases;

    case CREATE    = 'create';
    case DOWNLOAD  = 'download';
    case STATUS    = 'status';
    case SYNC      = 'sync';
    case TRANSLATE = 'translate';
    case UPGRADE   = 'upgrade';
}
