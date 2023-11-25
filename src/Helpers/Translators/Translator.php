<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Helpers\Translators;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\LocaleList\Locale;
use LaravelLang\StatusGenerator\Objects\Translatable;

abstract class Translator
{
    protected static Locale $default = Locale::English;

    abstract protected static function locales(): array;

    abstract protected static function request(string $value, string $targetLocale, string $sourceLocale): string;

    public static function translate(string $value, string $locale): string
    {
        if ($resolved = static::locale($locale)) {
            return static::get(static::prepare($value), $resolved, static::$default->value);
        }

        return $value;
    }

    public static function allow(string $locale): bool
    {
        return array_key_exists($locale, static::locales());
    }

    protected static function get(Translatable $trans, string $targetLocale, string $sourceLocale): string
    {
        return $trans->compile(static::request($trans->value, $targetLocale, $sourceLocale));
    }

    protected static function prepare(string $value): Translatable
    {
        return Translatable::make(compact('value'));
    }

    protected static function locale(string $locale): ?string
    {
        return Arr::get(static::locales(), $locale);
    }
}
