<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\StatusGenerator\Constants\Option;
use LaravelLang\StatusGenerator\Processors\Translate\Translate as TranslateProcessor;
use Symfony\Component\Console\Input\InputOption;

class Translate extends Command
{
    protected array|string $processor = [
        TranslateProcessor::class,
    ];

    protected function configure(): Command
    {
        return parent::configure()
            ->setName(CommandName::TRANSLATE())
            ->setDescription('Translation of untranslated keys')
            ->addOption(
                Option::LOCALE(),
                null,
                InputOption::VALUE_OPTIONAL,
                'Translation of values only for the selected localization. By default, translation of all localizations'
            );
    }
}
