<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\StatusGenerator\Processors\Translate\Translate as TranslateProcessor;

class Translate extends Command
{
    protected array|string $processor = [
        TranslateProcessor::class,
    ];

    protected function configure(): Command
    {
        return parent::configure()
            ->setName(CommandName::TRANSLATE())
            ->setDescription('Translation of untranslated keys');
    }
}
