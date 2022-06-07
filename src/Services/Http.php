<?php

namespace LaravelLang\StatusGenerator\Services;

use GuzzleHttp\Client;

class Http
{
    public function __construct(
        protected Client $client = new Client()
    ) {
    }

    public function download(string $url, string $path): void
    {

    }
}
