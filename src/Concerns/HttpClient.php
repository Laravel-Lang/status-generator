<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Concerns;

use LaravelLang\StatusGenerator\Services\Http;

trait HttpClient
{
    protected ?Http $client = null;

    protected function client(): Http
    {
        if (! empty($this->client)) {
            return $this->client;
        }

        return $this->client = new Http;
    }
}
