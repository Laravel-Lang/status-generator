<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Constants;

enum Translator: string
{
    case GOOGLE = 'google';
    case DEEPL  = 'deepl';
}
