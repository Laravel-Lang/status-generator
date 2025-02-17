<?php

namespace LaravelLang\StatusGenerator\Constants;

enum Stub: string
{
    case REFERENTS                   = 'referents.stub';
    case STATUS                      = 'status.stub';
    case STATUS_LOCALE               = 'locale.stub';
    case STATUS_COMPONENT_LOCALE     = 'components/locale.stub';
    case STATUS_COMPONENT_TRANSLATED = 'components/translated.stub';
}
