<?php

namespace LaravelLang\StatusGenerator\Services;

use DragonCode\Support\Facades\Filesystem\Directory;
use GuzzleHttp\Client;

class Http
{
    public function __construct(
        protected Client $client = new Client()
    ) {}

    public function download(string $url, string $sink): void
    {
        Directory::ensureDirectory(dirname($sink));

        $this->client->get($url, compact('sink'));
    }
}
