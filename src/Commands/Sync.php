<?php

namespace LaravelLang\StatusGenerator\Commands;

class Sync extends Command
{
    protected function configure()
    {
        $this
            ->setName('sync')
            ->setDescription('Updates translation keys');
    }
}
