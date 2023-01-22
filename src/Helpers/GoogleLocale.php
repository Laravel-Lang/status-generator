<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Helpers;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Constants\Locales;
use LaravelLang\StatusGenerator\Objects\Translatable;
use Stichoza\GoogleTranslate\GoogleTranslate;

class GoogleLocale
{
    protected static Locales $default = Locales::ENGLISH;

    public static function translate(string $value, string $locale): string
    {
        if ($resolved = self::locale($locale)) {
            return self::get($value, $resolved, self::$default->value);
        }

        return $value;
    }

    protected static function get(string $value, string $targetLocale, string $sourceLocale): string
    {
        $object = self::prepare($value);

        $translated = GoogleTranslate::trans($object->value, $targetLocale, $sourceLocale);

        return $object->compile($translated);
    }

    protected static function prepare(string $value): Translatable
    {
        return Translatable::make(compact('value'));
    }

    protected static function locale(string $locale): ?string
    {
        return Arr::get(self::locales(), $locale);
    }

    /**
     * @see https://cloud.google.com/translate/docs/languages
     *
     * @return string[]
     */
    protected static function locales(): array
    {
        return [
            Locales::AFRIKAANS->value          => 'af',
            Locales::ALBANIAN->value           => 'sq',
            Locales::ARABIC->value             => 'ar',
            Locales::ARMENIAN->value           => 'hy',
            Locales::AZERBAIJANI->value        => 'az',
            Locales::BASQUE->value             => 'eu',
            Locales::BELARUSIAN->value         => 'be',
            Locales::BENGALI->value            => 'bn',
            Locales::BOSNIAN->value            => 'bs',
            Locales::BULGARIAN->value          => 'bg',
            Locales::CATALAN->value            => 'ca',
            Locales::CENTRAL_KHMER->value      => 'km',
            Locales::CHINESE->value            => 'zh-CN',
            Locales::CHINESE_HONG_KONG->value  => 'zh',
            Locales::CHINESE_T->value          => 'zh-TW',
            Locales::CROATIAN->value           => 'hr',
            Locales::CZECH->value              => 'cs',
            Locales::DANISH->value             => 'da',
            Locales::DUTCH->value              => 'nl',
            Locales::ESTONIAN->value           => 'et',
            Locales::FINNISH->value            => 'fi',
            Locales::FRENCH->value             => 'fr',
            Locales::GALICIAN->value           => 'gl',
            Locales::GEORGIAN->value           => 'ka',
            Locales::GERMAN->value             => 'de',
            Locales::GERMAN_SWITZERLAND->value => 'de',
            Locales::GREEK->value              => 'el',
            Locales::GUJARATI->value           => 'gu',
            Locales::HEBREW->value             => 'he',
            Locales::HINDI->value              => 'hi',
            Locales::HUNGARIAN->value          => 'hu',
            Locales::ICELANDIC->value          => 'is',
            Locales::INDONESIAN->value         => 'id',
            Locales::ITALIAN->value            => 'it',
            Locales::JAPANESE->value           => 'ja',
            Locales::KANNADA->value            => 'kn',
            Locales::KAZAKH->value             => 'kk',
            Locales::KOREAN->value             => 'ko',
            Locales::LATVIAN->value            => 'lv',
            Locales::LITHUANIAN->value         => 'lt',
            Locales::MACEDONIAN->value         => 'mk',
            Locales::MALAY->value              => 'ms',
            Locales::MARATHI->value            => 'mr',
            Locales::MONGOLIAN->value          => 'mn',
            Locales::NEPALI->value             => 'ne',
            Locales::NORWEGIAN_BOKMAL->value   => 'no',
            Locales::NORWEGIAN_NYNORSK->value  => 'no',
            Locales::PASHTO->value             => 'ps',
            Locales::PERSIAN->value            => 'fa',
            Locales::PILIPINO->value           => 'fil',
            Locales::POLISH->value             => 'pl',
            Locales::PORTUGUESE->value         => 'pt',
            Locales::PORTUGUESE_BRAZIL->value  => 'pt',
            Locales::ROMANIAN->value           => 'ro',
            Locales::RUSSIAN->value            => 'ru',
            Locales::SERBIAN_CYRILLIC->value   => 'sr',
            Locales::SINHALA->value            => 'si',
            Locales::SLOVAK->value             => 'sk',
            Locales::SLOVENIAN->value          => 'sl',
            Locales::SPANISH->value            => 'es',
            Locales::SWAHILI->value            => 'sw',
            Locales::SWEDISH->value            => 'sv',
            Locales::TAGALOG->value            => 'tl',
            Locales::TAJIK->value              => 'tg',
            Locales::THAI->value               => 'th',
            Locales::TURKISH->value            => 'tr',
            Locales::TURKMEN->value            => 'tk',
            Locales::UIGHUR->value             => 'ug',
            Locales::UKRAINIAN->value          => 'uk',
            Locales::URDU->value               => 'ur',
            Locales::UZBEK_CYRILLIC->value     => 'uz',
            Locales::VIETNAMESE->value         => 'vi',
            Locales::WELSH->value              => 'cy',
        ];
    }
}
