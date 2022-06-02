<?php

namespace LaravelLang\StatusGenerator\Commands;

class Packages extends Command
{
    protected function configure()
    {
        $this
            ->setName('packages')
            ->setDescription('Gets source files from installed packages');
    }
}
