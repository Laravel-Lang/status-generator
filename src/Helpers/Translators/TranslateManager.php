<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Helpers\Translators;

use Throwable;

class TranslateManager
{
    /** @var array<\LaravelLang\StatusGenerator\Helpers\Translators\Translator> */
    protected static array $priority = [
        // DeeplTranslate::class,
        GoogleTranslate::class,
    ];

    public static function translate(string $text, string $locale): string
    {
        foreach (static::$priority as $translator) {
            if ($translator::allow($locale)) {
                try {
                    return static::lines($translator, static::split($text), $locale);
                }
                catch (Throwable) {
                }
            }
        }

        return $text;
    }

    protected static function lines(Translator|string $translator, array $values, string $locale): string
    {
        return static::compact(static::map($translator, $values, $locale));
    }

    protected static function map(Translator|string $translator, array $values, string $locale): array
    {
        return array_map(fn (string $value) => static::request($translator, $value, $locale), $values);
    }

    protected static function request(Translator|string $translator, string $text, string $locale): string
    {
        return $translator::translate($text, $locale);
    }

    protected static function split(string $text): array
    {
        return explode('|', $text);
    }

    protected static function compact(array $values): string
    {
        return implode('|', $values);
    }
}
