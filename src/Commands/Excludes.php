<?php

namespace LaravelLang\StatusGenerator\Commands;

class Excludes extends Command
{
    protected function configure()
    {
        $this
            ->setName('excludes')
            ->setDescription('Updates the exclusion list');
    }
}
