<?php

namespace LaravelLang\StatusGenerator\Commands;

class Referents extends Command
{
    protected function configure()
    {
        $this
            ->setName('referents')
            ->setDescription('Updates the documentation file with referents');
    }
}
