<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Helpers\Translators;

use LaravelLang\Locales\Enums\Locale;
use Stichoza\GoogleTranslate\GoogleTranslate as GT;

class GoogleTranslate extends Translator
{
    /**
     * @see https://cloud.google.com/translate/docs/languages
     *
     * @return array<string>
     */
    protected static function locales(): array
    {
        return [
            Locale::Afrikaans->value         => 'af',
            Locale::Albanian->value          => 'sq',
            Locale::Arabic->value            => 'ar',
            Locale::Armenian->value          => 'hy',
            Locale::Azerbaijani->value       => 'az',
            Locale::Basque->value            => 'eu',
            Locale::Belarusian->value        => 'be',
            Locale::Bengali->value           => 'bn',
            Locale::Bosnian->value           => 'bs',
            Locale::Bulgarian->value         => 'bg',
            Locale::Catalan->value           => 'ca',
            Locale::CentralKhmer->value      => 'km',
            Locale::Chinese->value           => 'zh-CN',
            Locale::ChineseHongKong->value   => 'zh',
            Locale::ChineseT->value          => 'zh-TW',
            Locale::Croatian->value          => 'hr',
            Locale::Czech->value             => 'cs',
            Locale::Danish->value            => 'da',
            Locale::Dutch->value             => 'nl',
            Locale::Estonian->value          => 'et',
            Locale::Finnish->value           => 'fi',
            Locale::French->value            => 'fr',
            Locale::Galician->value          => 'gl',
            Locale::Georgian->value          => 'ka',
            Locale::German->value            => 'de',
            Locale::GermanSwitzerland->value => 'de',
            Locale::Greek->value             => 'el',
            Locale::Gujarati->value          => 'gu',
            Locale::Hebrew->value            => 'he',
            Locale::Hindi->value             => 'hi',
            Locale::Hungarian->value         => 'hu',
            Locale::Icelandic->value         => 'is',
            Locale::Indonesian->value        => 'id',
            Locale::Italian->value           => 'it',
            Locale::Japanese->value          => 'ja',
            Locale::Kannada->value           => 'kn',
            Locale::Kazakh->value            => 'kk',
            Locale::Korean->value            => 'ko',
            Locale::Latvian->value           => 'lv',
            Locale::Lithuanian->value        => 'lt',
            Locale::Macedonian->value        => 'mk',
            Locale::Malay->value             => 'ms',
            Locale::Marathi->value           => 'mr',
            Locale::Mongolian->value         => 'mn',
            Locale::Nepali->value            => 'ne',
            Locale::NorwegianBokmal->value   => 'no',
            Locale::NorwegianNynorsk->value  => 'no',
            // Locale::Occitan->value => 'oc',
            Locale::Pashto->value            => 'ps',
            Locale::Persian->value           => 'fa',
            Locale::Pilipino->value          => 'fil',
            Locale::Polish->value            => 'pl',
            Locale::Portuguese->value        => 'pt',
            Locale::PortugueseBrazil->value  => 'pt',
            Locale::Romanian->value          => 'ro',
            Locale::Russian->value           => 'ru',
            // Locale::Sardinian->value => 'sc',
            Locale::SerbianCyrillic->value   => 'sr',
            // Locale::SerbianLatin->value       => 'sr-Latn',
            // Locale::SerbianMontenegrin->value => 'sr-Latn-ME',
            Locale::Sinhala->value           => 'si',
            Locale::Slovak->value            => 'sk',
            Locale::Slovenian->value         => 'sl',
            Locale::Spanish->value           => 'es',
            Locale::Swahili->value           => 'sw',
            Locale::Swedish->value           => 'sv',
            Locale::Tagalog->value           => 'tl',
            Locale::Tajik->value             => 'tg',
            Locale::Thai->value              => 'th',
            Locale::Turkish->value           => 'tr',
            Locale::Turkmen->value           => 'tk',
            Locale::Uighur->value            => 'ug',
            Locale::Ukrainian->value         => 'uk',
            Locale::Urdu->value              => 'ur',
            Locale::UzbekCyrillic->value     => 'uz',
            // Locale::UzbekLatin->value        => 'uz-Latn',
            Locale::Vietnamese->value        => 'vi',
            Locale::Welsh->value             => 'cy',
        ];
    }

    protected static function request(string $value, string $targetLocale, string $sourceLocale): string
    {
        return GT::trans($value, $targetLocale, $sourceLocale);
    }
}
