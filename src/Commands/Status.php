<?php

namespace LaravelLang\StatusGenerator\Commands;

class Status extends Command
{
    protected function configure()
    {
        $this
            ->setName('status')
            ->setDescription('Updates documentation with the status of translations');
    }
}
