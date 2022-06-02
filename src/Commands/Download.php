<?php

namespace LaravelLang\StatusGenerator\Commands;

class Download extends Command
{
    protected function configure()
    {
        $this
            ->setName('download')
            ->setDescription('Download and unpack the project');
    }
}
