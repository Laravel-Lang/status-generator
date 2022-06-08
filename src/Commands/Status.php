<?php

namespace LaravelLang\StatusGenerator\Commands;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;

class Status extends Command
{
    protected function configure(): Command
    {
        return parent::configure()
            ->setName(CommandName::STATUS())
            ->setDescription('Updates documentation with the status of translations');
    }
}
