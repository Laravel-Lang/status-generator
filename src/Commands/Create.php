<?php

namespace LaravelLang\StatusGenerator\Commands;

class Create extends Command
{
    protected function configure()
    {
        $this
            ->setName('create')
            ->setDescription('Creates a directory for the new localization');
    }
}
