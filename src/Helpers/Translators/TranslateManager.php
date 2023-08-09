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
                    return $translator::translate($text, $locale);
                }
                catch (Throwable) {
                }
            }
        }

        return $text;
    }
}
